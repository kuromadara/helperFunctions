/**
 * Using Scope in model for jQuery
 */

// model

class LoanType extends Model
{
    use SoftDeletes;

    public static $ACTIVE_STATUS = 1;
    public static $ADVANCE_TYPE  = 2;

    protected $guarded = [
        'id',
    ];
   // public static $minimal_select_fields = ["id","name", "is_active"];
    public function getRouteKeyName()
    {
        return 'uuid';
    }
     public function loanAdvances()
    {
        return $this->hasMany('App\Models\LoanAdvance');
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', self::$ACTIVE_STATUS);
    }
    public function scopeAdvanceType($query)
    {
        return $query->where('type', self::$ADVANCE_TYPE);
    }
}

// controller function

public function create()
{
    $employees    = Employee::select('*')->get();
    $designations = Designation::get();
    $loan_types   = LoanType::query()
        ->active()
        ->advanceType()
        ->pluck("name","id")
        ->toArray();

    $loan_head_principal = loan_head_principal_select_array();

    return view("advances.create", compact('employees', 'designations', 'loan_types', 'loan_head_principal'));
}
