<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::all();
        
        return view('expenses.index', [
            'expenses' => $expenses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    // 1. Obtenemos los datos del formulario
    $data = $request->validate([
        'name' => 'required|string',
        'amount' => 'required|numeric',
        'payment_day' => 'required|integer|min:1|max:31',
    ]);

    // 2. --- LÓGICA DE FECHAS ---
    $today = Carbon::today();
    $paymentDay = $data['payment_day'];

    // Creamos la fecha de vencimiento para este mes
    $dueDateThisMonth = Carbon::createFromDate($today->year, $today->month, $paymentDay);

    // Si el día de pago de este mes YA PASÓ...
    if ($today->day > $paymentDay) {
        // ...la próxima fecha de vencimiento es el SIGUIENTE mes.
        $data['next_due_date'] = $dueDateThisMonth->addMonthNoOverflow();
    } else {
        // ...si no, el vencimiento es ESTE mes.
        $data['next_due_date'] = $dueDateThisMonth;
    }

    // 3. Guardamos el nuevo gasto en la base de datos
    Expense::create($data);

    // 4. Redirigimos de vuelta a la lista
    return redirect()->route('expenses.index');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::findOrFail($id);
       return view('expenses.edit', [
        'expense' => $expense
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'payment_day' => 'required|integer|min:1|max:31',
        ]);
        if ($data['payment_day'] != $expense->payment_day) {

        $today = Carbon::today();
        $paymentDay = $data['payment_day'];
        $dueDateThisMonth = Carbon::createFromDate($today->year, $today->month, $paymentDay);

        if ($today->day > $paymentDay) {
            $data['next_due_date'] = $dueDateThisMonth->addMonthNoOverflow();
        } else {
            $data['next_due_date'] = $dueDateThisMonth;
        }
        
        $data['status'] = 'pendiente'; 
    }

    $expense->update($data);

    return redirect()->route('expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return redirect()->route('expenses.index');
    }
}
