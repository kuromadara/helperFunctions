<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticHelp extends Model
{
    use HasFactory;

    public static $ACCEPTED = 1;
    public static $CLOSED = 2;
    public static $WITHDRAWN = 3;
    public static $REJECTED = 4;
    public static $INACTIVE = 0;

    protected $guarded = ['_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function district()
    {
        return $this->hasOne(District::class, 'id','district_id');
    }

    public function perma_district()
    {
        return $this->hasOne(District::class, 'id','perma_district_id');
    }

    public function police_station()
    {
        return $this->hasOne(PoliceStation::class, 'id','police_station_id');
    }

    public function perma_police_station()
    {
        return $this->hasOne(PoliceStation::class, 'id','perma_police_station_id');
    }

    public function nationality()
    {
        return $this->hasOne(Nationality::class, 'id', 'nationality_id');
    }
}
