<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense; 
use Carbon\Carbon;      

class PaymentController extends Controller
{
    
    public function index()
{
    $today = Carbon::today();

    $pendingExpenses = Expense::where('status', 'pendiente')
                              ->whereYear('next_due_date', $today->year)
                              ->whereMonth('next_due_date', $today->month)
                              ->orderBy('next_due_date') // Ordenamos por fecha
                              ->get();

    return view('payments.index', [
        'pendingExpenses' => $pendingExpenses
    ]);
}

    public function confirmPayment(Expense $expense)
{
    $paymentDateToRecord = Carbon::parse($expense->next_due_date);
    $amountToRecord = $expense->amount;

    $expense->payments()->create([
        'amount'       => $amountToRecord,
        'payment_date' => $paymentDateToRecord
    ]);

    $newNextPaymentDate = $paymentDateToRecord->addMonthNoOverflow();

    $expense->update([
        'status'          => 'pagado', 
        'next_due_date'   => $newNextPaymentDate
    ]);

    return redirect()->route('payments.index')
                     ->with('success', '¡Pago de gasto confirmado!');
}
}