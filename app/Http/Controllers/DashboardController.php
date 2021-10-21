<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $customersCount = Customer::all()->count();
        $customersGainCurrentMonth = Customer::query()->whereMonth('created_at', date("m"))->count();
        $usersCount = User::all()->count();
        $transactions = Transaction::with(['customer', 'invoices'])->orderBy('date', 'desc')->limit(6)->get();

        $overDueInvoices = Invoice::with(['customer', 'transactions'])
            ->where('due_date', '<', date("Y-m-d"))
            ->orderBy('due_date', 'desc')
            // ->limit(6)
            ->get()
            ->filter(function ($invoice) {
                $paid = collect($invoice->transactions)->map(function ($transaction) {
                    return $transaction->pivot->amount;
                })->sum();

                $invoice['unpaid'] = $invoice->total - $paid;

                return $paid < $invoice->total;
            })
            ->take(6)
            ->all();

        // return $overDueInvoices;

        return view('dashboard', [
            'customers_count' => $customersCount,
            'customers_gain_current_month' => $customersGainCurrentMonth,
            'users_count' => $usersCount,
            'transactions' => $transactions,
            'over_due_invoices' => $overDueInvoices,
        ]);
    }
}
