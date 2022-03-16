<?php

namespace App;

use App\Models\Employee;
use App\Traits\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class FileMaster extends Model
{
    use ActiveScope;

    public static $TO_SEND = 1;
    public static $SENT    = 2;
    public static $TO_RECV = 3;
    public static $RECVD   = 4;

    public static $ACTIVE  = 1;
    public static $CLOSED  = 0;

    protected $guarded = ['id'];

    public function file_type_master()
    {
        return $this->belongsTo(FileType::class, 'file_type');
    }
    public function to_employee()
    {
        return $this->belongsTo(Employee::class, 'to_emp_id');
    }

}
