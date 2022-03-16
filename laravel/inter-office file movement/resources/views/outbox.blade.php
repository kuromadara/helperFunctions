@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            Outbox

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
                                        {{-- <input type="hidden" name="file_id" value={{ $message->id }}> --}}
                                        <form method="post" action="{{route('imo.outboxSend', $message->id )}}">
                                            @csrf
                                            <button class="btn btn-success" type='submit'>
                                                Send
                                            </button>

                                        </form>
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
