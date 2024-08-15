<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\enterprise;

class EnterpriseController extends Controller
{
    public function create()
    {
        return view('enterprise');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:45',
            'email' => 'required|max:45|email|unique:enterprises,email',
            'phone' => 'required|max:45',
            'address' => 'required',
        ]);

        enterprise::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        return redirect()->route('enterprises.create')->with('success', 'La empresa se añadió correctamente!');
    }


    public function search(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:45',
            'email' => 'nullable|email|max:45',
            'phone' => 'nullable|string|max:45',
        ]);

        $query = enterprise::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        }

        if ($request->filled('phone')) {
            $query->where('phone', $request->input('phone'));
        }

        $enterprises = $query->get();

        return view('enterprise', compact('enterprises'));
    }


    public function destroy($id)
    {
        $enterprise = enterprise::findOrFail($id);
        $enterprise->delete();

        return redirect()->route('enterprises.create')->with('success', 'La empresa fue eliminada correctamente!');
    }
}
