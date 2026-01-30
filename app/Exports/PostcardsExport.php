<?php

namespace App\Exports;

use App\Models\Postcard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostcardsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Postcard::all();
    }

    public function map($postcard): array
    {
        $cardTypes = [
            1 => 'zwangerschap',
            2 => 'babyfase',
            3 => 'van dreumes',
            4 => 'overzichtstip',
        ];

        return [
            $postcard->id,
            $cardTypes[$postcard->card_id] ?? $postcard->card_id,
            $postcard->name,
            $postcard->email,
            $postcard->message,
            $postcard->duration,
            $postcard->created_at,
            $postcard->updated_at,
        ];
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
