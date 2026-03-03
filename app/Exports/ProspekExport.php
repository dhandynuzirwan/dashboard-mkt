<?php

namespace App\Exports;

use App\Models\Prospek;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProspekExport implements FromCollection
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Prospek::with('marketing', 'cta');

        if ($this->request->start_date && $this->request->end_date) {
            $query->whereBetween('tanggal_prospek', [
                $this->request->start_date,
                $this->request->end_date,
            ]);
        }

        if ($this->request->marketing_id) {
            $query->where('marketing_id', $this->request->marketing_id);
        }

        return $query->get();
    }
}
