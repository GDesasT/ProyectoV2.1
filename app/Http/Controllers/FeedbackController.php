<?php

namespace App\Http\Controllers;

use App\Models\feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $comments = feedback::all();
        return view('feedback', compact('comments'));
    }

    public function store(Request $request)
    {
        $request -> validate([
            'comment' => 'required|string|max:255',
        ]);

        feedback::create([
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success','Comentario enviado exitosamente.');
    }

    public function destroy($id)
    {
        Feedback::find($id)->delete();
        return redirect()->route('feedback.index')->with('success', 'Comentario eliminado exitosamente.');
    }
}
