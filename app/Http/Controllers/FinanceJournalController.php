<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Journal;
use App\Models\JournalTransaction;
use App\Models\Account;
use App\Models\Category;



class FinanceJournalController extends Controller
{

    public function index()
    {
        $company = Company::all();
        $journals = Journal::with(['company'])->get();

        return view('journal.index', [
            'company' => $company,
            'journals' => $journals,
        ]);
    }


    public function create()
    {

        $companies = Company::all();
        // $accounts = Account::where('type', 'detail')->get();
        $transactions = JournalTransaction::all();
        // $categories = Category::with(['accounts' => function ($query) {
        //     $query->where('type', 'detail');
        // }])->get()
        //     ->filter(function ($categories) {
        //         return count($categories['accounts']) > 0;
        //     })->values();

        $categories = Category::with('accounts')->get();
        // return $categories;
        return view('finance-journal.create', [
            'companies' => $companies,
            // 'accounts' => $accounts,
            'categories' => $categories,
            'transactions' => $transactions,
        ]);
    }


    public function edit($id)
    {
        $journals = Journal::with(['company'])->findOrFail($id);
        $transactions = JournalTransaction::where('journal_id', $id)->get();
        $company = Company::all();
        return view('finance-journal.edit', [
            'journal' => $journals,
            'transactions' => $transactions,
            'company' => $company,
            'journal_id' => $id,
        ]);
    }


    public function destroy($id)
    {
        //
    }

    public function transaction($id)
    {
        $journals = Journal::with(['company'])->findOrFail($id);
        // return $journals;

        return view('finance-journal.transaction', [
            'id' => $id,
            'journals' => $journals,
        ]);
    }
}
