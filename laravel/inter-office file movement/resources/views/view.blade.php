@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            View

        </div>
        <div class="card-body">
            {!! Form::open(["route" => ["imo.forward", $file_master->id], "method" => "POST",'enctype' =>
            'multipart/form-data',
            "id" =>
            "addIMO"]) !!}

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label("from", "From", ["class" => "label-control"]) !!}
                            {!! Form::text("from_name", $current_employee->full_name_with_code,["class" => "form-control input-sm", "disabled" => "disabled"]) !!}
                        </div>

                            <input type="text" style="display:none" name="employee_id_from" value="{{ $current_employee->id }}">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="to_name">To</label>
                            <select name="employee_id_to" class="form-control select2">
                                <option value="">--All--</option>
                                @foreach ($employees_search as $employee)
                                    <option value="{{$employee->id}}">{{$employee->full_name_with_code}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="prev_employee_from" value="{{$file_master->from_emp_id}}">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label("file_no", "File No./ Memo No.", ["class" => "label-control"]) !!}
                            {!! Form::text("file_no", $file_master->file_no,["class" => "form-control input-sm", "placeholder" => "000", 'disabled']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        {!! Form::label('file_date', 'File Date', ["class" => "label-control"]) !!}
                        {!! Form::text('file_date', $file_master->file_date, ["class" => "form-control input-sm", "id" => "fileDate", 'disabled']) !!}
                    </div>

                    <div class="col-md-3">
                        <label for="file_type">File Type</label>
                            {!! Form::text("file_type", $file_master->file_type_master->name ?? 'na', ["class" => "form-control input-sm", "placeholder" => "File Type", 'disabled']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('file_subject', "File Subject", ["class" => 'label-control']) !!}
                            {!! Form::text("file_sub", $file_master->file_sub, ["class" => "form-control input-sm", "placeholder" => "Enter file subject Here", 'disabled']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label("details", "Details", ["class" => "label-control"]) !!}
                            {!! Form::textarea("details", $file_master->details,["class" => "form-control input-sm", "style" => "height:70px", "placeholder" => "details", 'disabled']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label("remarks", "Remarks", ["class" => "label-control"]) !!}
                            {!! Form::textarea("remarks", null,["class" => "form-control input-sm", "style" => "height:70px", "placeholder" => "remarks"]) !!}
                        </div>
                    </div>

                </div>



                {!! Form::ladda_submit_button("Submit", "left", ["class" => "btn-primary btn-sm"]) !!}

                {!! Form::close() !!}

        </div>

    </div>
</div>
@endsection
@section('css')
<style>
    span.Zebra_DatePicker_Icon_Wrapper {
        width: unset !important;
    }
</style>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#fileDate').Zebra_DatePicker({
                format: 'Y/m/d',
            });
	    });
    </script>
@endsection
