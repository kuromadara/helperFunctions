<?php

namespace App\Exports;

use Barryvdh\Debugbar\Twig\Extension\Dump;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Termwind\Components\Dd;

class CommonExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    private $selectedColumns;
    private $headings;
    private $model;
    private $relations;

    public function __construct($selectedColumns, $headings, $model, $relations)
    {
        $this->selectedColumns = $selectedColumns;
        $this->headings = $headings;
        $this->model = $model;
        $this->relations = $relations;
    }

    public function headings(): array
    {
        return $this->headings;
    }


    public function collection()
    {

        $data =  $this->model::select($this->selectedColumns)->get();

        /**
        * The code comented below is for staticaly fetch the relation
        */

        // foreach ($data as &$item) {
        //     $item->user_id = $item->user->name;
        //     $item->district_id = $item->district->name;
        //     $item->perma_district_id = $item->perma_district->name;
        //     $item->police_station_id = $item->police_station->name;
        //     $item->perma_police_station_id = $item->perma_police_station->name;
        //     $item->nationality_id = $item->nationality->name;
        // }


        /**
        * The code comented below is for dynamically fetch the relation
        */

        foreach ($data as &$item) {
            foreach($this->relations as $relation) {
                $item->{$relation['id']} = $item->{$relation['relation']}->name;
            }
        }
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [

            1    => ['font' => ['bold' => true]],
        ];
    }
}
