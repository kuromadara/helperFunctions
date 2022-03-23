@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            File Movements
        </div>
        <div class="card-body">
            <h4 class="text-center">
                List of Files
            </h4>
            <div class="table-responsive-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>File No.</th>
                            <th>Subject</th>
                            <th>Created By</th>
                            {{-- <th>Active From Emp.</th> --}}
                            <th>Active To Emp.</th>
                            <th>Last Remark</th>
                            <th>Created Date</th>
                            {{-- <th>Updated Date</th> --}}
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($file_masters as $key =>$file)
                            @if($file->status == '1')
                                <tr class="bg-success">
                            @else
                                <tr class="bg-danger">
                            @endif
                                    <td class="left">{{ $key+1 }}</td>
                                    <td class='left'>{{ $file->file_no}}</td>
                                    <td class='left'>{{ $file->file_sub}}</td>
                                    <td class='left'>{{ $file->employee->full_name_with_code . ' , ' . $file->created_by_department . ' , ' . $file->created_by_designation }}</td>
                                    {{-- <td class='left'>{{ $file->from_employee->full_name_with_code . ' , ' . $file->from_employee->department->name . ' , '. $file->from_employee->designation->name}}</td> --}}
                                    <td class='left'>{{ $file->to_employee->full_name_with_code. ' , ' . $file->to_employee->department->name . ' , ' . $file->to_employee->designation->name}}</td>
                                    <td class='left'>{{ $file->last_remarks}}</td>
                                    <td class='left'>{{ $file->created_at->format('Y-d-m')}}</td>
                                    {{-- <td class='left'>{{ $file->updated_at->format('Y-d-m') }}</td> --}}
                                    <td class='left'>
                                        @if ($file->status == '0')
                                            <span class="badge badge-success">Closed</span>
                                        @elseif($file->status == '1')
                                            <span class="badge badge-danger">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('imo.list',$file->id) }}" class="btn btn-primary btn-sm view-details">View</a>
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
{{-- modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">File Movement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            $(".view-details").click(function(event){
                event.preventDefault();
                var url = $(this).attr('href');
                // $.ajax({
                //     url: url,
                //     type: 'GET',
                //     dataType: 'html',
                //     success: function(response){
                //         $('.modal-body').html(response);
                //         $('#exampleModal').modal('show');
                //     }
                // });
                $.get(url)
                .done(function(data) {
                    $('#exampleModal .modal-body').html(data);
                    $('#exampleModal').modal('show');
                })
                .fail(function() {
                    console.log("error");
                })
                // $("#exampleModal").modal('show');

            })
	    });
    </script>
@endsection
