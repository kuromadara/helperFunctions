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
                                <th style="min-width: 70px">Attendance</th>

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
                                <td class="left">
                                    {{-- <textarea name="attJson[]" cols="30" rows="10" style="display: none;"></textarea> --}}
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#workerAttModal{{$worker->id}}">
                                        Attendence
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade  modal-fullscreen" id="workerAttModal{{$worker->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add Attendence</h4>
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
                                                                        FN<input type="checkbox" name="wid_fns[{{$worker->casualWorker->id}}][]" value="{{$date}}"}}>
                                                                        AN<input type="checkbox" name="wid_ans[{{$worker->casualWorker->id}}][]" value="{{$date}}"}}>
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
                                    <div class="row" style="align-items:start !important;">

                                        <h1 id="attnden"></h1>
                                        <div class="col-md-4">
                                           <div class="form-group">
                                               <label for="name">Total Days</label>
                                               {!! Form::number("total_days",null, [
                                               "class" => " form-control text-right", "placeholder" => "Total Days", "style" => "width:auto", "id" => "total_days"
                                               ]) !!}
                                           </div>
                                       </div>

                                       <div class="col-md-4">
                                           <div class="form-group">
                                               <label for="name">Rate</label>
                                               {!! Form::number("rate", $rate->rate, [
                                               "class" => "form-control text-right", "placeholder" => "Rate", "style" => "width:auto", "value" => "{{$rate->rate}}", "id" => "rate"
                                               ]) !!}
                                           </div>
                                       </div>
                                       <div class="col-md-4">
                                           <div class="form-group">
                                               <label for="name">Gross Amount</label>
                                               {!! Form::number("gross_amount", null, [
                                               "class" => "form-control text-right", "placeholder" => "Gross Amount", "style" => "width:auto", "id" => "gross_amount"
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

<div id="attnModal" class="modal">

    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title">List of Dates</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

            <button type="button" class="save" id="btnSave">Save</button>
    </div>
</div>

@endsection
@section('css')

<style>
    @media (max-width: 767px) {
    .modal-fullscreen-xs-down {
        padding: 0 !important;
    }
    .modal-fullscreen-xs-down .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .modal-fullscreen-xs-down .modal-content {
        height: auto;
        min-height: 100%;
        border: 0 none;
        border-radius: 0;
        box-shadow: none;
    }
    }
    @media (max-width: 991px) {
    .modal-fullscreen-sm-down {
        padding: 0 !important;
    }
    .modal-fullscreen-sm-down .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .modal-fullscreen-sm-down .modal-content {
        height: auto;
        min-height: 100%;
        border: 0 none;
        border-radius: 0;
        box-shadow: none;
    }
    }
    @media (max-width: 1199px) {
    .modal-fullscreen-md-down {
        padding: 0 !important;
    }
    .modal-fullscreen-md-down .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .modal-fullscreen-md-down .modal-content {
        height: auto;
        min-height: 100%;
        border: 0 none;
        border-radius: 0;
        box-shadow: none;
    }
    }
    .modal-fullscreen {
    padding: 0 !important;
    }
    .modal-fullscreen .modal-dialog {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    }
    .modal-fullscreen .modal-content {
    height: auto;
    min-height: 100%;
    border: 0 none;
    border-radius: 0;
    box-shadow: none;
    }

    /* html {
    display: flex;
    height: 100%;
    }

    body {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    } */

    .btn-open-modal {
    margin-bottom: 0.5em;
    }
</style>

@endsection
@section('js')

<script>

    saveAttData = function(obj){
        var $this = $(obj);

        var logicTr = $this.parents("tr").next("tr");
        /*
        * next TR because the calculation is done in next row of the button. reffer to image.
        */
        var arrayData = $modal.find("input:checked").serializeArray();
        console.log(arrayData.length);

        var days = arrayData.length * 0.5;
        var rate = logicTr.find('#rate').val();
        var gross_amount = days * rate;


        logicTr.find("#total_days").val(days);
        logicTr.find("#gross_amount").val(gross_amount);

        $modal.modal("hide");

    }
</script>


@endsection
