@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            File Movements
        </div>
        <div class="card-body">
            <h4 class="text-center">
                File Created at {{ $initiation_date->created_at->format('d-m-Y') }}
            </h4>

                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Sent Date</th>
                                <th>Recive Date</th>
                                <th>Remarks</th>
                                <th>Status </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $key =>$transaction)
                                @if($transaction->trans_status == '1' OR $transaction->trans_type == '3')
                                    <tr class="bg-success">

                                @elseif($transaction->trans_status == '0' AND $transaction->trans_type == '0')
                                    <tr class="bg-danger">
                                @else
                                    <tr>
                                @endif
                                        <td class="left">{{ $key+1 }}</td>
                                        <td class='left'>{{ $transaction->from_user_details}}</td>
                                        <td class='left'>{{ $transaction->to_user_details }}</td>
                                        <td class='left'>{{ $transaction->actual_sent_date}}</td>
                                        <td class='left'>{{ $transaction->actual_rcv_date}}</td>
                                        <td class='left'>{{ $transaction->remarks}}</td>
                                        <td class='left'>
                                            @if ($transaction->trans_type == '1')
                                                <span class="badge badge-primary">Initiated</span>
                                            @elseif($transaction->trans_type == '2')
                                                <span class="badge badge-dark">Sent</span>
                                            @elseif($transaction->trans_type == '3')
                                                <span class="badge badge-dark">Received</span>
                                            @elseif($transaction->trans_type == '4')
                                                <span class="badge badge-warning">Forwarded</span>
                                            @elseif($transaction->trans_type == '0')
                                                <span class="badge badge-dark">Closed</span>
                                            @endif
                                        </td>

                                    </tr>

                            @endforeach
                        </tbody>
                    </table>

                </div>
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
