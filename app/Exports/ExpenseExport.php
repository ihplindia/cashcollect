<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExpenseExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View{
      $all=Expense::where('expense_status',1)->orderBy('expense_id', 'DESC')->get();
        return view('admin.expense.main.excel', compact('all'));
    }
}
