<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActionExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return $this->results;
    }

    public function headings(): array
    {
        return [
            'Create_At',
            'Name',
            'Operator',
            'Status',
            'Country',
            'Commentaire'
        ];
    }

    public function map($results): array
    {
        return [
            $results->created_at->format('d/m/Y H:i'),
            $results->name,
            $results->operator,
            $this->getStatusLabel($results->status),
            $results->country,
            $results->commentaire
        ];
    }

    private function getStatusLabel($status): string
    {
        return match ($status) {
            'pending' => 'Pending',
            'valid' => 'Validate',
            'close' => 'Close',
            default => $status,
        };
    }
}
