<?php

namespace App\Exports;

use App\Models\Member\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MemberExport implements FromView
{
    public function view(): View
    {
        return view('admin.members.excel', [
            'members' => Member::where('status', 'sell')->get()
        ]);
    }
}
