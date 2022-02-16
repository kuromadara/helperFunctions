@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        Attendence for Casual Worker
    </div>
    <div class="card-body">
        <div class="table-responsive">
            {!! Form::open(["route" => ["newCasual-worker-attendance.post", $requision_id], "method" => "POST"]) !!}
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th style="min-width: 200px">Name</th>
                                <th>Cw. No</th>
                                <th style="min-width: 162px">Work</th>
                                <th style="min-width: 70px" colspan="2">Process</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allocatedWorkers as $key => $worker)
                                <tr>
                                    <td class="center">
                                        {{ $key+ 1 }}
                                    </td>
                                    <td class="left">   {{ $worker->casualWorker->name}}   </td>
                                    <td class="left">   {{ $worker->casual_worker_no}}  </td>
                                    <td class="left">   {{ $worker->casualWorkerRequision[0]->name_of_work ?? "NA"}}   </td>
                                    <td class="left" colspan="2">
                                        <input type="text" name="from_date" value="{{$requision->from_date}}" hidden>
                                        <input type="text" name="to_date" value="{{$requision->to_date}}" hidden>
                                        <input type="text" name="department_id" value="{{$requision->department_id}}" hidden>

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#workerAttModal{{$worker->id}}">
                                            Attendence
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade  modal-fullscreen" id="workerAttModal{{$worker->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Attendence From {{$requision->from_date}} to {{$requision->to_date}}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="">
                                                        <table class="table table-sm table-bordered" style="table-layout:fixed;">
                                                            <thead>
                                                                <tr>
                                                                    @foreach($dates as $date)
                                                                        <th style="min-width:98px">{{date("d",strtotime($date))}}</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    @foreach($dates as $date)
                                                                        <td class="left" style="word-wrap:break-word;">
                                                                            FN<input type="checkbox" name="data[{{$worker->casualWorker->id}}][wid_fns][]" value="{{$date}}"}}>
                                                                            AN<input type="checkbox" name="data[{{$worker->casualWorker->id}}][wid_ans][]" value="{{$date}}"}}>
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" onclick="saveAttData(this)">Save changes</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td colspan="4">
                                        <div class="row">

                                            <div class="col-md-4">
                                                <input type="text" name= "data[{{$worker->casualWorker->id}}][casual_worker_no]" value="{{ $worker->casual_worker_no}}" hidden>
                                                <div class="form-group">
                                                    <label for="name">Total Days</label>
                                                    {!! Form::number("data[".$worker->casualWorker->id."][total_days]",null, [
                                                    "class" => " form-control text-right", "placeholder" => "Total Days", "style" => "width:auto", "id" => "total_days", "step" => "0.01", "min" => "0", "required" => "required"
                                                    ]) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Rate</label>
                                                    {!! Form::number("data[".$worker->casualWorker->id."][rate]", $rate->rate, [
                                                    "class" => "form-control text-right", "placeholder" => "Rate", "style" => "width:auto", "value" => "{{$rate->rate}}", "id" => "rate", "step" => "0.01", "required" => "required"
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Gross Amount</label>
                                                    {!! Form::number("data[".$worker->casualWorker->id."][gross_amount]", null, [
                                                    "class" => "form-control text-right", "placeholder" => "Gross Amount", "style" => "width:auto", "id" => "gross_amount", "step" => "0.01", "required" => "required"
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Net Amount</label>
                                                        {!! Form::number("data[".$worker->casualWorker->id."][net_amount]", null, [
                                                        "class" => "form-control text-right", "placeholder" => "Net Amount", "style" => "width:auto", "id" => "net_amount", "step" => "0.01", "required" => "required", "onKeyUp" => "calculateTotal(this)"
                                                        ]) !!}
                                                    </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Overtime Hour</label>
                                                    {!! Form::number("data[".$worker->casualWorker->id."][ot_hour]", null, [
                                                    "class" => "form-control text-right", "placeholder" => "Overtime Hour", "style" => "width:auto", "id" => "ot_hour", "step" => "0.01", "required" => "required", "onKeyUp" => "calculateTotal(this)"

                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Overtime Rate</label>
                                                    {!! Form::number("data[".$worker->casualWorker->id."][ot_rate]", null, [
                                                    "class" => "form-control text-right", "placeholder" => "Overtime Rate", "style" => "width:auto", "id" => "ot_rate", "step" => "0.01", "required" => "required", "onKeyUp" => "calculateTotal(this)"

                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Overtime Amount</label>
                                                    {!! Form::number("data[".$worker->casualWorker->id."][ot_amount]", null, [
                                                    "class" => "form-control text-right", "placeholder" => "Overtime Amount", "style" => "width:auto", "id" => "ot_amount", "step" => "0.01", "required" => "required",
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">VDA</label>
                                                    {!! Form::number("data[".$worker->casualWorker->id."][ot_amount]", null, [
                                                    "class" => "form-control text-right", "placeholder" => "VDA", "style" => "width:auto", "id" => "vda", "step" => "0.01", "required" => "required", "onKeyUp" => "calculateTotal(this)",
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Total Amount</label>
                                                    {!! Form::number("data[".$worker->casualWorker->id."][total_amount]", null, [
                                                    "class" => "form-control text-right", "placeholder" => "Overtime Amount", "style" => "width:auto", "id" => "total_amount", "step" => "0.01", "required" => "required",
                                                    ]) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="name">Acknowledgement</label>
                                                    {!! Form::textarea("data[".$worker->casualWorker->id."][ack]", null, [
                                                    "class" => "form-control", "rows"=>"1", "cols"=>"8", "placeholder" => "Acknowledgement", "required"
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    <td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            {!!Form::submit('Submit',['class' => 'btn btn-primary'])!!}
            {!! Form::close() !!}
    </div>
</div>

@endsection
@section('css')

<style>

    .modal-fullscreen {
    padding: auto !important;
    }
    .modal-fullscreen .modal-dialog {
    width: 100%;
    height: 50%;
    margin-top: 100px;
    padding: auto;
    }
    .modal-fullscreen .modal-content {
    height: auto;
    min-height: 100%;
    border: 0 none;
    border-radius: 0;
    box-shadow: none;
    }

    .btn-open-modal {
    margin-bottom: 0.5em;
    }
</style>

@endsection
@section('js')

<script>

    calculateTotal = function(obj){
        var $this = $(obj);
        var logicTr = $this.parents("tr");
        var ot_rate = logicTr.find('#ot_rate').val();
        var ot_hour = logicTr.find('#ot_hour').val();
        var ot_amount = ot_hour * ot_rate;
        var net_amount = logicTr.find('#net_amount').val();

        var total_amount = parseFloat(ot_amount) + parseFloat(net_amount);

        logicTr.find("#ot_amount").val(ot_amount);
        logicTr.find("#total_amount").val(total_amount);
    }

    saveAttData = function(obj){
        var $this = $(obj);
        var $modal = $this.parents(".modal");
        var logicTr = $this.parents("tr").next("tr");
        /*
        * the calculation is done in the next row of the attendence so next tr is used
        * see image to understand better. In the previous function there is no next try {
        * because we are finding in the same row.
        */
        var arrayData = $modal.find("input:checked").serializeArray();
        //console.log(arrayData.length);

        var days = arrayData.length * 0.5;
        var rate = logicTr.find('#rate').val();
        var gross_amount = days * rate;


        logicTr.find("#total_days").val(days);
        logicTr.find("#gross_amount").val(gross_amount);

        //$modal.parents("td").find("textarea").val(JSON.stringify(arrayData));

        $modal.modal("hide");

    }
</script>


@endsection
