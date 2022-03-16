@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            Create Inter Office Memo

        </div>
        <div class="card-body">
            {!! Form::open(["route" => "imo.store", "method" => "POST",'enctype' =>
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

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label("file_no", "File No./ Memo No.", ["class" => "label-control"]) !!}
                            {!! Form::text("file_no", null,["class" => "form-control input-sm", "placeholder" => "000"]) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        {!! Form::label('file_date', 'File Date', ["class" => "label-control"]) !!}
                        {!! Form::text('file_date', null, ["class" => "form-control input-sm", "id" => "fileDate"]) !!}
                    </div>

                    <div class="col-md-3">
                        <label for="file_type">File Type</label>
                        <select name="file_type" id="file_type" class="form-control input-sm select2">
                            @foreach ($file_types as $file_type)
                                <option value="{{$file_type->id}}">{{$file_type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('file_subject', "File Subject", ["class" => 'label-control']) !!}
                            {!! Form::text("file_sub", null, ["class" => "form-control input-sm", "placeholder" => "Enter file subject Here"]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label("details", "Details", ["class" => "label-control"]) !!}
                            {!! Form::textarea("details", null,["class" => "form-control input-sm", "style" => "height:70px", "placeholder" => "details"]) !!}
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
