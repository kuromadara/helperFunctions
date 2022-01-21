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
    public function  __construct($salhead)
    {
        $this->salhead = $salhead;
    }
    
    public function collection(Collection $collection)
    {   
        //dump($collection);
        //dd($salhead = $this->salhead->id);
        
        $collection->each(function($row, $key){

            $employee_code = $row['employee_code'];
            $salheadtype = $this->salhead->type;

            if($salheadtype == 'E'){
                $claims = $row['amount'];
                $deducts = 0.00;
            }
            elseif($salheadtype == 'D'){
                $deducts = $row['amount'];
                $claims = 0.00;
            }
            
            
            $test = Employee::where('code', $employee_code)->first();
            //dd($test['id']);

            $salaryearblock= EmployeeSalYearBlock::select('salary_month', 'salary_year')
                ->where('status', 1)->first();

            
            $data = [
                'employee_id' => $test['id'],
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

            EmployeeSalaryTemp::updateOrCreate($data);

            
            //dd($test['first_name']);
         
            
        });

        // $test = EmployeeSalaryTemp::get();
        // dd($test->take(10));
        //dd($collection->toArray());
       
    }
}
