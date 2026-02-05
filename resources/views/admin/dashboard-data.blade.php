<table class="table table-bordered">
    <thead>
        <tr>
            <th>Type</th>
            <th>Payment Mode</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>

        {{-- INCOME --}}
        @forelse($income ?? [] as $row)
            <tr class="table-success">
                <td>Income</td>
                <td>{{ $row->payment }}</td>
                <td>{{ \Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                <td>₹ {{ number_format($row->amount, 2) }}</td>
            </tr>
        @empty
        @endforelse

        {{-- EXPENSE --}}
        @forelse($expense ?? [] as $row)
            <tr class="table-danger">
                <td>Expense</td>
                <td>{{ $row->payment }}</td>
                <td>{{ \Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                <td>₹ {{ number_format($row->amount, 2) }}</td>
            </tr>
        @empty
        @endforelse

        {{-- NO DATA --}}
        @if ((empty($income) || count($income) === 0) && (empty($expense) || count($expense) === 0))
            <tr>
                <td colspan="4" class="text-center text-muted">
                    No records found
                </td>
            </tr>
        @endif

    </tbody>
</table>

<hr>

<div class="row">
    <div class="col-md-4">
        <strong>Total Income:</strong>
        ₹ {{ number_format($totalIncome ?? 0, 2) }}
    </div>

    <div class="col-md-4">
        <strong>Total Expense:</strong>
        ₹ {{ number_format($totalExpense ?? 0, 2) }}
    </div>

    <div class="col-md-4">
        <strong>Net Balance:</strong>
        ₹ {{ number_format($netBalance ?? 0, 2) }}
    </div>
</div>
