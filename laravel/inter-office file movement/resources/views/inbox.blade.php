@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            Inbox

        </div>
        <div class="card-body">
            <h4 class="text-center">
                Message
            </h4>

                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>To</th>
                                <th>From</th>
                                <th>Details</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $key =>$message)
                                <tr>
                                    <td class="left">{{ $key+1 }}</td>
                                    <td class='left'>{{ $message->to_employee->full_name_upper}}</td>
                                    <td class='left'>{{ $message->created_by_name }}</td>
                                    <td class='left'>{{ $message->details}}</td>
                                    <td>

                                        @if($message->trans_stage == 2)
                                            <form method="post" action="{{route('imo.inboxRead', $message->id )}}">
                                                @csrf
                                                <button class="btn btn-success" type='submit'>
                                                    Mark As Received
                                                </button>
                                            </form>
                                        @else
                                            <form method="get" action="{{route('imo.view', $message->id)}}">
                                                <button class="btn btn-success" type='submit'>
                                                    View / Forward
                                                </button>
                                            </form>

                                            @if($message->created_by_id == $message->to_emp_id)

                                                <form method="post" action="{{route('imo.close', $message->id)}}">
                                                    @csrf
                                                    <button class="btn btn-warning" type='submit'>
                                                        Close
                                                    </button>
                                                </form>
                                            @endif
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
