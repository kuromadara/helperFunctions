@extends('layouts.app')
@section('content')

<div class="card">
    <div class="card-header">
        <i class="fa fa-file-excel-o"></i> Upload CSV.
    </div>
    <div class="card-body">

        <form method="post" action="{{route("upload.store")}}" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Salary Head</label>
                            {{-- <select name="salhead" id="sal_head" class="form-control select2"> --}}
                                {{-- <option value="">--All--</option> --}}
                                {{-- @foreach ($salheads as $key => $salhead)
                                    <option value="{{$salhead->code}}" {{request("code") == $salhead->code ? "selected" : ""}}>{{$salhead->name}}</option>
                                @endforeach --}}
                                {!! Form::select('salhead', $salheads, null, ['class' => 'form-control select2', "required" => true]) !!}
                            {{-- </select> --}}
                        </div>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <input type="file" name="file" data-validation="required" data-validation-error-msg="Please Upload Excel File"/></br>
                </div>

                <button type="submit" class='btn btn-primary text-white'>Upload </button>

        </form>
    </div>
</div>

@endsection
@section('css')

@endsection
@section('js')


@endsection
