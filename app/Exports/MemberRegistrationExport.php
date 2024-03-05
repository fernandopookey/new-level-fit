<?php

namespace App\Exports;

use App\Models\Member\MemberRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;

class MemberRegistrationExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return MemberRegistration::select('full_name', 'nickname', 'member_code', 'gender', 'born', 'phone_number', 'email', 'ig', 'emergency_contact', 'address')->get();

        $data = MemberRegistration::select(
            'member_registrations.full_name',
            'member_registrations.nickname',
            'member_registrations.member_code',
            'member_registrations.gender',
            'member_registrations.born',
            'member_registrations.phone_number',
            'member_registrations.email',
            'member_registrations.ig',
            'member_registrations.emergency_contact',
            'member_registrations.address',
            // 'members.some_column' // Include columns from the members table
        )
            ->leftJoin('members', 'member_registrations.member_id', '=', 'members.id')
            ->get();

        return $data;
    }
}
