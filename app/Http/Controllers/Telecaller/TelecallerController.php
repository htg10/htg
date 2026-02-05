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
        $telecallers = Telecaller::latest()->paginate(10);
        return view('telecaller.index', compact('telecallers'));
    }

    public function create()
    {
        $users = User::where('role_id', 2)->get();
        return view('telecaller.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'user_id' => 'required|exists:users,id',
            'meeting_datetime' => 'required|date',
            'interest' => 'required|string',
        ]);

        $telecaller = new Telecaller([
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
