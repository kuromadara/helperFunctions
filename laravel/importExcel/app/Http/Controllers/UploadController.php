<?php

namespace App\Http\Controllers;

use App\Models\SalHead;
use App\Imports\SalaryUploadImport;

use DB;
use Excel;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        $salheads = SalHead::whereNotIn("id", [])->pluck("name", "id")->toArray();
        return view("upload.index", compact('salheads'));
    }

    public function store(Request $request)
    {   
        
        $request->validate([
            'salhead' => 'required|exists:sal_heads,id',
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $sal_head = SalHead::find($request->salhead);
        DB::beginTransaction();
        try{
            Excel::import(new SalaryUploadImport($sal_head), $request->file );
        }
        catch(\Exception $e){
            report($e);
            DB::rollback();
            dd($e->getMessage());
            return Redirect::back()->with("error", "Something went wrong");
        }
        DB::commit();
        return redirect()->back()->with("success", " successfully uploaded");
        
    }
}
