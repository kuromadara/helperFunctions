<?php

namespace App\Imports;

use App\Models\EmployeeSalaryTemp;
use App\Models\Employee;
use App\Models\EmployeeSalYearBlock;

use DB;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalaryUploadImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    private $row = 0;

    public function  __construct($salhead)
    {
        $this->salhead = $salhead;
    }

    public function collection(Collection $collection)
    {
          // dd($collection->groupBy("employee_code"));

        $collection->groupBy("employee_code")->each(function($row, $employee_code){

          ++this->$row;

            //dd($employee_code, $row, $row->sum("amount"));
            // $employee_code = $row['employee_code'];

            $salheadtype = $this->salhead->type;

            if($salheadtype == 'E'){
                $claims = $row->sum("amount");
                $deducts = 0.00;
            } elseif($salheadtype == 'D') {
                $deducts = $row->sum("amount");
                $claims = 0.00;
            }

            // dump($employee_code, $row);

            $employee_master = Employee::select("id")->where('code', $employee_code)->first();
            // dd($employee_master);
            if(!$employee_master){
                throw new \Exception("Employee code {$employee_code} not found.");
            }

            $salaryearblock= EmployeeSalYearBlock::select('salary_month', 'salary_year')
                ->where('status', 1)->first();

            $temp_sal_row = EmployeeSalaryTemp::query()
                ->where('employee_code', $employee_code)
                ->where("sal_head_id", $this->salhead->id)
                ->first();

            if($temp_sal_row) {
                $temp_sal_row->update([
                    "claims" => $claims,
                    "deducts" => $deducts,
                ]);
            } else {

                $data = [
                    'employee_id' => $employee_master->id,
                    'uuid' => Str::uuid()->toString(),
                    'employee_code' => $employee_code,
                    'sal_head_id' => $this->salhead->id,
                    'salary_head_code' => $this->salhead->code,
                    'salary_head' => $this->salhead->name,
                    'claims' => $claims,
                    'deducts' => $deducts,
                    'salMonth' => $salaryearblock->salary_month,
                    'salYear' => $salaryearblock->salary_year,
                    'status' => '1',
                    'head_type' => $this->salhead->type,
                ];

                EmployeeSalaryTemp::Create($data);
            }

        });

    }

    public function getRowCount(): int
    {
      return $this->row;
    }
}
