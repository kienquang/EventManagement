<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistrationsExport implements FromCollection, WithHeadings
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId= $eventId;
    }

    public function collection()
    {
        return Registration::with('user')
            ->where('event_id', $this->eventId)
            ->get()
            ->map(function($r){
                return[
                    'Họ tên' => $r->user->name,
                    'Email' => $r->user->email,
                    'Trạng thái' => $r->status,
                    'Thời gian check-in' => $r->checked_in_at,
                ];
            });
    }

    public function headings(): array
    {
        return ['Họ tên', 'Email', 'Trạng thái', 'Thời gian check-in'];
    }
}
