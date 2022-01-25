// if index 1 and arry starts from zero. see the remark field

            foreach($request->salhead as $key => $value){
                $remarks = 'remarks_'.$value;
                $remarks_field = $request->$remarks;
                $salhead = SalHead::select("id", "name", "type","code","status")
                ->where("id", $value)
                ->first();
                //dump($salhead->id);
                EmployeeSalaryTemp::create([
                    "uuid"          =>  Str::uuid()->toString(),
                    "employee_id"   =>  $employee->id,
                    "employee_code" =>  $employee->code,
                    "sal_head_id"   =>  $salhead->id,
                    "salary_head_code" =>  $salhead->code,
                    "salary_head"   =>  $salhead->name,
                    "claims"        =>  0.00,
                    'deducts'       =>  0.00,
                    'remarks'       =>  $remarks_field,
                    'status'        =>  1,
                ]);
    
            }

// view

@forelse ($claims as $key => $item)
                                <tr data-id="{{$item->id}}">
                                    <td>
                                        <input type="checkbox" class="checkbox" name="salhead[]" value="{{$item->id}}" />    
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td class="text-right" data-field="amount" data-type="number">0.00</td>
                                    <td>
                                        <input type="text" class="form-control" name="remarks_{{$item->id}}" placeholder="Remarks" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-danger text-center" colspan="5">Claims head not found.</td>
                                </tr>
                            @endforelse