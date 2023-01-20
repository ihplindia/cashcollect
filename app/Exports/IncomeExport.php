<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncomeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View{
      $all=Income::where('income_status',1)->orderBy('income_id', 'DESC')->get();
        return view('admin.income.main.excel', compact('all'));
    }
}
