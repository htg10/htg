<?php

namespace App\Http\Controllers\Telecaller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Telecaller;

class TelecallerController extends Controller
{
    public function index(Request $request)
    {
        $telecallers = Telecaller::query();

        if ($request->filled('business')) {
            $telecallers->where('business', 'like', '%' . $request->business . '%');
        }

        if ($request->filled('bdm_id')) {
            $telecallers->where('user_id', $request->bdm_id);
        }

        // Filter by interest
        if ($request->filled('interest')) {
            $telecallers->where('interest', 'like', '%' . $request->interest . '%');
        }

        // Filter by deal status
        if ($request->filled('deal_status')) {
            $telecallers->where('deal_status', $request->deal_status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $telecallers->whereBetween('created_at', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $telecallers = $telecallers->latest()->get();
        $users = User::where('role_id', 2)->get();
        return view('telecaller.index', compact('telecallers', 'users'));
    }

    public function create()
    {
        $users = User::where('role_id', 2)->get();
        return view('telecaller.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'user_id' => 'required|exists:users,id',
            'meeting_datetime' => 'required|date',
            'interest' => 'required|string',
        ]);

        $telecaller = new Telecaller([
            'business' => $request->input('business'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'mobile' => $request->input('mobile'),
            'user_id' => $request->input('user_id'),
            'meeting_datetime' => $request->input('meeting_datetime'),
            'interest' => $request->input('interest'),
            'status' => 'NEW'
        ]);

        $telecaller->save();

        return redirect('/telecaller/index')->with('success', 'Add successfully.');
    }


    public function edit($id)
    {
        $telecallers = Telecaller::findOrFail($id);
        $users = User::where('role_id', 2)->get();
        // dd($telecallers);
        return view('telecaller.edit', compact('users', 'telecallers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'business' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'user_id' => 'required|exists:users,id',
            'meeting_datetime' => 'required|date',
            'interest' => 'required|string',
        ]);

        $telecaller = Telecaller::findOrFail($id);
        // $data = $request->all();

        $telecaller->update([
            'business' => $validated['business'],
            'name' => $validated['name'],
            'address' => $validated['address'],
            'mobile' => $validated['mobile'],
            'user_id' => $validated['user_id'],
            'meeting_datetime' => $validated['meeting_datetime'],
            'interest' => $validated['interest'],
        ]);
        return redirect('/telecaller/index')->with('success', 'Update successfully.');
    }

    function delete($id)
    {
        $telecaller = Telecaller::find($id);
        $telecaller->delete();
        return redirect('/telecaller/index')->with('success', 'Delete successfully.');
    }


}
