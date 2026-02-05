<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Telecaller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Entry;
use App\Models\Products;
use DB;
use App\Exports\FinanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BackendIndexController extends Controller
{
    public function index()
    {
        $entry = Entry::all();
        $services = Products::all();
        $banks = Bank::all();

        $entries = Entry::with(['product', 'user'])->get();

        $totalAmount = $entries->reduce(function ($carry, $entry) {
            return $carry + ($entry->product ? $entry->product->sum('total_amount') : 0);
        }, 0);

        $totalBalance = $entries->reduce(function ($carry, $entry) {
            return $carry + ($entry->product ? $entry->product->sum('total_amount') - $entry->product->sum('paid_amount') : 0);
        }, 0);

        // =========================
        // TYPE WISE (New / Renew)
        // =========================
        $result = DB::select("select count(*) as total_entry, type from entries group by type");
        $charData = "";
        foreach ($result as $list) {
            // $charData .= "['" . $list->user_id . "', " . $list->total_user . "],";
            $charData .= "['" . $list->type . "', " . $list->total_entry . "],";
        }
        $chartData = rtrim($charData, ',');


        // =========================
        // BDM NAME WISE DATA
        // =========================
        $bdmData = $entries->groupBy(function ($entry) {
            return optional($entry->user)->name ?? 'Unknown';
        })->map->count();

        $bdmDataString = '';
        foreach ($bdmData as $bdmName => $count) {
            $bdmDataString .= "['{$bdmName}', {$count}],";
        }
        $bdmDataString = rtrim($bdmDataString, ',');

        // =========================
        // PRODUCT NAME WISE DATA
        // =========================
        $productData = $entries->flatMap(function ($entry) {
            return $entry->product->pluck('product_name');
        })->countBy();

        $productDataString = '';
        foreach ($productData as $productName => $count) {
            $productDataString .= "['{$productName} [{$count}]', {$count}],";
        }
        $productDataString = rtrim($productDataString, ',');

        // =========================
        // PAYMENT MODE WISE TOTAL
        // =========================
        // $paymentResult = DB::select("
        //     SELECT e.payment, SUM(p.paid_amount) as total
        //     FROM entries e
        //     JOIN products p ON p.entry_id = e.id
        //     WHERE e.payment IS NOT NULL
        //     GROUP BY e.payment
        // ");

        $paymentResult = DB::table('entries as e')
            ->join('products as p', 'p.entry_id', '=', 'e.id')
            ->select('e.payment', DB::raw('SUM(p.paid_amount) as total'))
            ->whereNotNull('e.payment')
            ->groupBy('e.payment')
            ->get();


        $paymentChartData = '';
        foreach ($paymentResult as $row) {
            $paymentChartData .= "[' {$row->payment}', {$row->total}],";
        }
        $paymentChartData = rtrim($paymentChartData, ',');


        // =========================
        // DATE WISE PAYMENT TOTAL
        // =========================
        $dateResult = DB::select("
            SELECT e.date, SUM(p.paid_amount) as total
            FROM entries e
            JOIN products p ON p.entry_id = e.id
            GROUP BY e.date
            ORDER BY e.date ASC
        ");

        $dateChartData = '';
        foreach ($dateResult as $row) {
            $dateChartData .= "['{$row->date}', {$row->total}],";
        }
        $dateChartData = rtrim($dateChartData, ',');

        if (Auth::user()->role_id == 1) {

            return view('admin.dashboard', compact('entry', 'services', 'totalAmount', 'totalBalance', 'chartData', 'bdmDataString', 'productDataString', 'paymentChartData', 'dateChartData', 'banks'));
        } elseif (Auth::user()->role_id == 2) {
            return view('user.index');
        } elseif (Auth::user()->role_id == 3) {
            $telecallers = Telecaller::all();
            return view('telecaller.dashboard', compact('telecallers'));
        }

        return redirect()->route('login');
    }

    public function paymentFilter(Request $request)
    {
        $payment = $request->payment_mode;
        $from = $request->from_date;
        $to = $request->to_date;

        /* ================= INCOME ================= */
        $incomeQuery = DB::table('entries as e')
            ->join('products as p', 'p.entry_id', '=', 'e.id')
            ->select(
                'e.payment',
                'e.date',
                DB::raw('SUM(p.paid_amount) as amount'),
                DB::raw("'Income' as type")
            )
            ->whereNotNull('e.payment')
            ->groupBy('e.payment', 'e.date');

        if ($payment) {
            $incomeQuery->where('e.payment', $payment);
        }

        if ($from && $to) {
            $incomeQuery->whereBetween('e.date', [$from, $to]);
        }

        $income = $incomeQuery->get();

        /* ================= EXPENSE ================= */
        $expenseQuery = DB::table('expenses')
            ->select(
                'payment_mode as payment',
                'date',
                'amount',
                DB::raw("'Expense' as type")
            );

        if ($payment) {
            $expenseQuery->where('payment_mode', $payment);
        }

        if ($from && $to) {
            $expenseQuery->whereBetween('date', [$from, $to]);
        }

        $expense = $expenseQuery->get();

        /* ================= TOTALS ================= */
        $totalIncome = $income->sum('amount');
        $totalExpense = $expense->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        return view('admin.dashboard-data', compact(
            'income',
            'expense',
            'totalIncome',
            'totalExpense',
            'netBalance'
        ));
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getFinanceData($request);

        return Excel::download(
            new FinanceExport($data),
            'finance-report.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getFinanceData($request);

        $pdf = Pdf::loadView('admin.export.finance-pdf', [
            'records' => $data
        ]);

        return $pdf->download('finance-report.pdf');
    }


    private function getFinanceData($request)
    {
        $payment = $request->payment_mode;
        $from = $request->from_date;
        $to = $request->to_date;

        $records = [];

        /* ===== INCOME ===== */
        $income = DB::table('entries as e')
            ->join('products as p', 'p.entry_id', '=', 'e.id')
            ->select(
                'e.payment as payment',
                'e.date as date',
                DB::raw('SUM(p.paid_amount) as amount')
            )
            ->whereNotNull('e.payment')
            ->groupBy('e.payment', 'e.date');

        if ($payment)
            $income->where('e.payment', $payment);
        if ($from && $to)
            $income->whereBetween('e.date', [$from, $to]);

        foreach ($income->get() as $row) {
            $records[] = [
                'Income',
                $row->payment,
                $row->date,
                $row->amount
            ];
        }

        /* ===== EXPENSE ===== */
        $expense = DB::table('expenses')
            ->select(
                'payment_mode as payment',
                'date',
                'amount'
            );

        if ($payment)
            $expense->where('payment_mode', $payment);
        if ($from && $to)
            $expense->whereBetween('date', [$from, $to]);

        foreach ($expense->get() as $row) {
            $records[] = [
                'Expense',
                $row->payment,
                $row->date,
                $row->amount
            ];
        }

        return $records;
    }


}
