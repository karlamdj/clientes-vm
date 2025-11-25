<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reminders = Reminder::all();
        return view('reminders.index', compact('reminders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reminders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Reminder::create($request->all());

        return redirect()->route('reminders.index')
            ->with('success', 'Reminder created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reminder = Reminder::findOrFail($id);
        return view('reminders.show', compact('reminder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reminder = Reminder::findOrFail($id);
        return view('reminders.edit', compact('reminder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $reminder = Reminder::findOrFail($id);
        $reminder->update($request->all());

        if ($request->has('layout_ids')) {
            $reminder->layouts()->sync($request->input('layout_ids'));
        }

        return redirect()->route('reminders.index')
            ->with('success', 'Reminder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();

        return redirect()->route('reminders.index')
            ->with('success', 'Reminder deleted successfully.');
    }
}
