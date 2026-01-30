<?php

namespace App\Exports;

use App\Models\Postcard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostcardsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Postcard::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Card ID',
            'Name',
            'Email',
            'Message',
            'Duration',
            'Created At',
            'Updated At',
        ];
    }
}
