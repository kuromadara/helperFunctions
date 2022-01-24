// where doesnot exist 

select * from `employees` where not exists (select * from `employee_salary_temps` where `employees`.`id` = `employee_salary_temps`.`employee_id`) and `employees`.`deleted_at` is null

//laravel

$emp = Employee::query()
            ->whereDoesntHave("temp_payslip_data")
            ->get();