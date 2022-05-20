@extends('layouts.app')
@section('content')
{!! Form::open(["route" => "payslip.batch-saledit.post", "method" => "POST"]) !!}
<div class="card">
    <div class="card-header">
       <i class="fa fa-list-alt"></i>Batch Salary Head Edit
    </div>

    <div class="card-body">

        <div class="row">
            <div class="form-group col-3">
                <label for="salhead_id">Salary Head</label>
                <select class="select2 form-control" name="salhead_id" id="salhead_id">
                    @foreach ($salheads as $salhead)
                        <option name="" value="{{ $salhead->id }}">{{ $salhead->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-3">
                <label for="amount">Month</label>
                {!! Form::select('month', \App\Helpers\CommonHelper::getMonthArray($salarystatus->salary_month), $salarystatus->salary_month, ['class' => 'form-control', 'placeholder' => '--SELECT--', 'required' => 'required']) !!}
            </div>
            <div class="form-group col-3">
                <label for="amount">Year</label>
                {!! Form::text('year', $salarystatus->salary_year, ['class' => 'form-control', 'placeholder' => 'year', 'readonly' => true ]) !!}
            </div>
        </div>

    </div>
</div>
<div class="card">
    <div class="card-header">
       <i class="fa fa-list-alt"></i>Employee List
    </div>

    <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <p>Press <kbd>Ctrl</kbd> + <kbd>></kbd> to Add More.</p>
                </div>
            </div>
            <div class="row field_wrapper">
                <div class="form-group col-4">
                    <label for="employee_id">Employee</label>
                    {!! Form::select("datas[0][employee_id]", $employees, request("employee_id"), ["class" => "select2 form-control", "placeholder" => "Name or Code", "required" => "required"]) !!}
                </div>
                <div class="form-group col-4">
                    <label for="month">Amount</label>
                    <input type="number" class="form-control" name="datas[0][amount]" id="amount" value="0.00" required>
                </div>
                <div class="form-group col-4">
                    <button class="btn btn-danger remove_button" style="margin-top: 26px" type="button" onclick="removeMe(this)"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <a href="javascript:void(0);" class="add_button btn btn-success" title="Add field"><i class="fa fa-plush"></i> ADD MORE</a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    {!!Form::submit('Submit',['class' => 'btn btn-primary','id'=>'process'])!!}
                    {!! Form::close() !!}
                </div>
            </div>
    </div>
</div>

@endsection
@section('css')

@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){

    var maxField = 7000; 
    var addButton = $('.add_button'); 
    var wrapper = $('.field_wrapper'); 
    
    var x = 1; 
    
    
    $(addButton).click(function(){

        if(x < maxField){ 
            x++;
            $('.field_wrapper:last').after(drow(x));
            $('.field_wrapper:last').slideDown(function(){
                // $(this).find('select').select2();
                $("#employee_id_"+x).select2({
                    theme: 'bootstrap'
                });
                $("#employee_id_"+x).select2('open');
            });

        }
        //$('.field_wrapper:last').find("select").select2();
    });

   removeMe = function(obj){
        console.log(obj);
        if($(".field_wrapper").length == 1){
            toastr.error("Atleast one field required");

            return false;
        }
        $(obj).parents('.field_wrapper').slideUp(function(){
            $(this).remove();
        });
    }

    function drow(key){
        var fieldHTML = `
            <div class="row field_wrapper" style='display:none'>
                <div class="form-group col-4">
                    <label for="employee_id">Employee</label>
                    <select class="form-control" name="datas[${key}][employee_id]" id="employee_id_${key}">
                        <option value="">Name or Code</option>
                        @foreach ($employees as $id => $full_name_with_code)
                            <option name="voucher_no" value="{{ $id }}">{{ $full_name_with_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-4">
                    <label for="month">Amount</label>
                    <input type="number" class="form-control" name="datas[${key}][amount]" id="amount" value="0.00">
                </div>
                <div class="form-group col-4">
                    <button class="btn btn-danger remove_button" style="margin-top: 26px" type="button" onclick="removeMe(this)"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        `;
        return fieldHTML;
    }
});

$(window).keydown(function(e){

    if(event.ctrlKey && (event.which == 190)){
        $('.add_button').trigger("click")
        // $(".select2:last")[0].focus();
        event.preventDefault(); 
        
    } 

});
</script>
@endsection


