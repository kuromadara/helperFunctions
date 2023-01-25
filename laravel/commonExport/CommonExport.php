<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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
    private $attributes;
    private $unsetColumn;

    public function __construct($selectedColumns, $headings, $model, $relations=null, $attributes=null, $unsetColumn=null)
    {
        $this->selectedColumns = $selectedColumns;
        $this->headings = $headings;
        $this->model = $model;
        $this->relations = $relations;
        $this->attributes = $attributes;
        $this->unsetColumn = $unsetColumn;
    }

    public function headings(): array
    {
        return $this->headings;
    }


    public function collection()
    {

        // add select is used to add the title column
        $data =  $this->model::select($this->selectedColumns)->addSelect($this->unsetColumn)->get();
        foreach ($data as &$item) {
            foreach ($this->relations as $relation) {
                $item->{$relation['id']} = $item->{$relation['relation']}->name;
            }
        }

        foreach ($data as &$item) {
            foreach ($this->attributes as $attribute) {
                $item->{$attribute['id']} = $item->{$attribute['attribute']};
            }
        }

        // addSelect is removed here from the colloction
        $data = $data->map(function($item){
            unset($item->{$this->unsetColumn});
            return $item;
        });

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [

            1    => ['font' => ['bold' => true]],
        ];
    }
}
