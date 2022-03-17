<?php

namespace App\Http\Controllers;

use App\FileMaster;
use App\FileTrans;
use App\FileTransType;
use App\FileType;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use DB;
use Exception;
use File;
use Illuminate\Http\Request;
use Log;

class InterOfficeMemo extends Controller
{
    public function add()
    {
        $employees_search = Employee::select('id', 'first_name', 'middle_name', 'last_name', 'code')
            ->get();

        $current_employee = auth()->user()->employee;

        $file_types = FileType::select('id', 'name')
            ->get();



        return view('imo.add', compact('employees_search', 'current_employee', 'file_types'));
    }

    public function view(Request $request, $id)
    {
        $employees_search = Employee::select('id', 'first_name', 'middle_name', 'last_name', 'code')
            ->get();

        $current_employee = auth()->user()->employee;


        $file_master = FileMaster::with('file_type_master')->find($id);

        return view('imo.view', compact('employees_search', 'current_employee', 'file_master'));
    }

    public function store(Request $request)
    {

        $designation_id = auth()->user()->employee->designation_id;
        $designation = Designation::select('id', 'name')
            ->where('id', $designation_id)
            ->first();

        $department_id = auth()->user()->employee->department_id;
        $department = Department::select('id', 'name')
            ->where('id', $department_id)
            ->first();

        $to_employee = Employee::select('id', 'first_name', 'middle_name', 'last_name', 'code', 'department_id', 'designation_id')
            ->with('department', 'designation')
            ->where('id', $request->employee_id_to)
            ->first();

        $to_designation = $to_employee->designation;

        $to_department = $to_employee->department;


        DB::beginTransaction();

        try{

            $data_master = [
                'file_no' => $request->file_no,
                'reference_no' => 'TEST123',
                'file_sub'     => $request->file_sub,
                'file_type'    => $request->file_type,
                'file_date'    => $request->file_date,
                'details'      => $request->details,
                'created_by_id' => auth()->user()->employee->id,
                'created_by_name' => auth()->user()->employee->full_name,
                'created_by_designation' => $designation->name,
                'created_by_department'  => $department->name,
                'from_emp_id'            => $request->employee_id_from,
                'to_emp_id'              => $request->employee_id_to,
                'trans_type'             => FileTransType::$INITIATED,
                'last_remarks'           => $request->remarks,
                'trans_stage'            => FileMaster::$TO_SEND,
                'status'                 => FileMaster::$ACTIVE,

            ];

            $file_master = FileMaster::create($data_master);

            $data_trans_initiated = [
                'file_id' => $file_master->id,
                'from_emp_id'       => $request->employee_id_from,
                'trans_type'        => FileTransType::$INITIATED,
                'sent_date'         => date('Y-m-d'),
                'from_user_details' => $file_master->from_employee->code . ' - ' . $file_master->created_by_name . ' ,' . $file_master->created_by_designation . ' ,' . $file_master->created_by_department,
                'remarks'           => $request->remarks,
            ];

            FileTrans::create($data_trans_initiated);

            $data_trans_forward = [
                'file_id' => $file_master->id,
                'from_emp_id'   => $request->employee_id_from,
                'to_emp_id'     => $request->employee_id_to,
                'trans_type'    => FileTransType::$FORWARDED,
                'trans_status'      => FileTransType::$ACTIVE_NOW,
                'sent_date'         => date('Y-m-d'),
                'from_user_details' => $file_master->from_employee->code . ' - ' . $file_master->created_by_name . ' ,' . $file_master->created_by_designation . ' ,' . $file_master->created_by_department,
                'to_user_details'   => $to_employee->full_name_with_code . ' ,' . $to_designation->name . ' ,' . $to_department->name,
                'remarks'           => $request->remarks,
            ];

            FileTrans::create($data_trans_forward);

        } catch (Exception $e) {
            DB::rollback();
            Log::critical($e);
            dd($e->getMessage());
            $request->session()->flash('error', 'Something went wrong');

            return back();
        }
        DB::commit();
        $request->session()->flash('success', 'Successfully added');
        return back();
    }

    public function inbox()
    {
        $current_employee = auth()->user()->employee;

        //dd($current_employee->id);

        $messages = FileMaster::with('to_employee')
            ->active()
            ->where('to_emp_id', $current_employee->id)
            ->whereIn('trans_stage', [ FileMaster::$SENT, FileMaster::$RECVD])
            ->get();

        // dd($messages);

        return view('imo.inbox', compact('messages'));
    }

    public function inboxRead(Request $request, $id)
    {
        //dd($id);

        $file_master = FileMaster::find($id);

        try{

            FileMaster::where('id', $id)
                ->update([
                    'trans_type'  => FileTransType::$RECEIVED,
                    'trans_stage' => FileMaster::$RECVD
                ]);
            FileTrans::where('file_id', $id)
                ->where('from_emp_id', $file_master->from_emp_id)
                ->where('to_emp_id', $file_master->to_emp_id)
                ->update([
                    'trans_type'  => FileTransType::$RECEIVED,
                    'trans_status'      => FileTransType::$NOT_ACTIVE,
                    'actual_rcv_date' => date('Y-m-d')
                ]);

        } catch (Exception $e) {
            DB::rollback();
            Log::critical($e);
            dd($e->getMessage());
            $request->session()->flash('error', 'Something went wrong');

            return back();
        }
        DB::commit();
        $request->session()->flash('success', 'Marked as read');
        return back();
    }

    public function outbox()
    {
        $current_employee = auth()->user()->employee;

        $messages = FileMaster::with('to_employee')
            ->active()
            ->where('from_emp_id', $current_employee->id)
            ->where('trans_stage', FileMaster::$TO_SEND)
            ->get();

        // dd($messages);

        return view('imo.outbox', compact('messages'));
    }

    public function outboxSend(Request $request, $id)
    {

        // dd($id);
        $file_master = FileMaster::find($id);

        try{

            FileMaster::where('id', $id)
                ->update([
                    'trans_type'  => FileTransType::$SENT,
                    'trans_stage' => FileMaster::$SENT
                ]);
            FileTrans::where('file_id', $id)
                ->where('from_emp_id', $file_master->from_emp_id)
                ->where('to_emp_id', $file_master->to_emp_id)
                ->update([
                    'trans_type'       => FileTransType::$SENT,
                    'actual_sent_date' => date('Y-m-d'),
                    'rcv_date'         => date('Y-m-d'),
                ]);

        } catch (Exception $e) {
            DB::rollback();
            Log::critical($e);
            dd($e->getMessage());
            $request->session()->flash('error', 'Something went wrong');

            return back();
        }
        DB::commit();
        $request->session()->flash('success', 'Sent Successfully');
        return back();
    }

    public function close(Request $request, $id)
    {
        $file_master = FileMaster::find($id);

        try{


            $file_master->update([
                    'status' => FileMaster::$CLOSED
                ]);

            $data_trans_closed = [
                'file_id' => $file_master->id,
                'from_emp_id'       => $file_master->from_employee->id,
                'trans_type'        => FileTransType::$CLOSED,
                'actual_rcv_date'   => date('Y-m-d'),
                'trans_date'        => date('Y-m-d'),
                'from_user_details' => $file_master->to_employee->code . ' - ' . $file_master->created_by_name . ' ,' . $file_master->created_by_designation . ' ,' . $file_master->created_by_department,
            ];

            FileTrans::create($data_trans_closed);

        } catch (Exception $e) {
            DB::rollback();
            Log::critical($e);
            dd($e->getMessage());
            $request->session()->flash('error', 'Something went wrong');

            return back();
        }
        DB::commit();
        $request->session()->flash('success', 'File Closed Succesfully');
        return back();
    }

    public function forward(Request $request, $id)
    {
        // dump($id);
        // dd($request->all());

        $designation_id = auth()->user()->employee->designation_id;
        $from_designation = Designation::select('id', 'name')
            ->where('id', $designation_id)
            ->first();

        $department_id = auth()->user()->employee->department_id;
        $from_department = Department::select('id', 'name')
            ->where('id', $department_id)
            ->first();


        $from_employee = Employee::select('id', 'first_name', 'middle_name', 'last_name', 'code')
            ->where('id', $request->employee_id_from)
            ->first();


        $to_employee = Employee::select('id', 'first_name', 'middle_name', 'last_name', 'code', 'department_id', 'designation_id')
            ->with('department', 'designation')
            ->where('id', $request->employee_id_to)
            ->first();

        $to_designation = $to_employee->designation;

        $to_department = $to_employee->department;

        DB::beginTransaction();

        try{

            FileTrans::where('file_id', $id)
                ->where('from_emp_id', $request->prev_employee_from)
                ->where('to_emp_id', $request->employee_id_from)
                ->update([
                    'trans_type'        => FileTransType::$FORWARDED,
                    'trans_date'        => date('Y-m-d'),
                ]);

            $data_master = [

                'trans_stage'   => FileMaster::$TO_SEND,
                'from_emp_id'   => $request->employee_id_from,
                'to_emp_id'     => $request->employee_id_to,
                'trans_type'    => FileTransType::$FORWARDED,
                'last_remarks'  => $request->remarks,
                'trans_stage'       => FileMaster::$TO_SEND,

            ];

            $file_master = FileMaster::findOrfail($id);

            $file_master->update($data_master);

            $data_trans = [
                'file_id'           => $file_master->id,
                'from_emp_id'       => $request->employee_id_from,
                'to_emp_id'         => $request->employee_id_to,
                'trans_type'        => FileTransType::$SENT,
                'trans_status'      => FileTransType::$ACTIVE_NOW,
                'sent_date'         => date('Y-m-d'),
                // 'actual_sent_date'  => date('Y-m-d'),
                'rcv_date'          => date('Y-m-d'),
                'trans_date'        => date('Y-m-d'),
                'from_user_details' => $from_employee->code . ' - ' . $from_employee->full_name . ' ,' . $from_designation->name . ' ,' . $from_department->name,
                'to_user_details'   => $to_employee->full_name_with_code . ' ,' . $to_designation->name . ' ,' . $to_department->name,
                'remarks'           => $request->remarks,
            ];

            FileTrans::create($data_trans);

        } catch (Exception $e) {
            DB::rollback();
            Log::critical($e);
            dd($e);
            $request->session()->flash('error', 'Something went wrong');

            return back();
        }
        DB::commit();
        $request->session()->flash('success', 'Successfully Forwarded');
        return back();
    }

    public function list(Request $request, $id)
    {

        $transactions = FileTrans::query()
            ->where('file_id', $id)
            ->get();

        $initiation_date = FileMaster::select('created_at')
            ->where('id', $id)
            ->first();

        return view('imo.list', compact('transactions', 'initiation_date'));
    }
}
