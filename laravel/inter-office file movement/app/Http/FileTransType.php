<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileTransType extends Model
{
    public static $INITIATED    = 1;
    public static $SENT         = 2;
    public static $RECEIVED     = 3;
    public static $FORWARDED    = 4;
    public static $CLOSED       = 0;

    public static $ACTIVE_NOW   = 1;
    public static $NOT_ACTIVE   = 0;


    protected $guarded = ['id'];

}
