<?php

namespace App\Http\Controllers;

use App\Models\ExtraIncome;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExtraIncomeController extends Controller
{
    public function index()
    {
        $extras = ExtraIncome::orderBy('income_date', 'desc')->get();
        return view('extras.index', compact('extras'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'concept' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'income_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        ExtraIncome::create($data);

        return redirect()->route('extras.index')->with('success', 'Ingreso extra registrado.');
    }

    public function destroy(ExtraIncome $extra)
    {
        $extra->delete();
        return redirect()->route('extras.index')->with('success', 'Registro eliminado.');
    }
}
