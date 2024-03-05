<?php

namespace App\Exports;

use App\Models\Member\Member;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\StringHelper;

class MemberExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //return DB::select($sql);

        return DB::table('members as a')
            // ->select(

            // )
            ->addSelect(
                'id',
                'full_name',
                'nickname',
                // 'member_code',
                DB::raw('CONCAT(" ", CONVERT(member_code, CHAR), " ") as mc'),
                'gender',
                'born',
                DB::raw('CONCAT(" ", CONVERT(phone_number, CHAR), " ") as asdf'),
                // 'phone_number',
                'email',
                'ig',
                'emergency_contact',
                'address',
                'status',
            )
            ->get();

        // SELECT id, CONVERT(phone_number, CHAR) FROM members;
        //  return Member::select('full_name', 'nickname', 'member_code', 'gender', 'born', 'phone_number', 'email', 'ig', 'emergency_contact', 'address')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Nickname',
            'Member Code',
            'Gender',
            'Born',
            'Phone Number',
            'Email',
            'Instagram',
            'Emergency Contact',
            'Address',
            'Status',
        ];
    }
}
