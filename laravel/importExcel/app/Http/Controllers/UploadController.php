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

        $import = new SalaryUploadImport($sal_head)

        DB::beginTransaction();
        try{
            Excel::import($import, $request->file );
        }
        catch(\Exception $e){
            report($e);
            DB::rollback();
            dd($e->getMessage());
            return Redirect::back()->with("error", "Error at row ". ($import->getRowCount() + 2) .". Please check the file and try again.");
        }
        DB::commit();
        return redirect()->back()->with("success", " successfully uploaded");

    }
}
