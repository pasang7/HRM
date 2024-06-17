<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Auth;
use Carbon\Carbon;
use PDO;

class User extends Authenticatable
{
    use Notifiable;
    use HasSlug;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['employee_id', 'name','gender','role','department_id','designation','is_married','blood_group','religion',
    'province', 'district', 'municipality_vdc','address','temp_province','temp_district', 'temp_municipality_vdc','temp_address',
    'phone','phone_2','email','email_2','password','pin','dob','interview_date','joined','profile_image','citizenship','cv','is_head',
    'allow_overtime','has_pan','pan_no','has_ssf','ssf_no','has_pf','pf_no','has_cit','cit_no','cit_percent','cit_amount','salary_slip','tax_calculate',
    'first_approval_id','sec_approval_id','created_by','is_deleted'
    ];
    protected $dates=[
        'dob','joined', 'interview_date'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            if(Auth::user()){
                $model->created_by = Auth::user()->id;
            }else{
                $model->created_by = 1;
            }
        });
    }

    public function userReligion(){
        return $this->belongsTo('App\Models\Religion', 'religion', 'id');
    }
    public function bloodGroup(){
        return $this->belongsTo('App\Models\BloodGroup', 'blood_group', 'id');
    }
    public function department(){
        return $this->belongsTo('App\Models\Department');
    }
    public function userDesignation(){
        return $this->belongsTo('App\Models\Designation', 'designation', 'id');
    }
    public function userRole(){
        return $this->belongsTo('App\Models\Role', 'role', 'id');
    }

    public function approveBy(){
        return $this->belongsTo('App\Models\User', 'first_approval_id');
    }
    public function holidays(){
        return $this->hasMany('App\Models\UserHoliday')->where('status',1);
    }

    public function clockout(){
        return $this->belongsTo('App\Models\Attendance','id','user_id')->where('clockout',null)->whereDate('date',Carbon::today());
    }
    public function default_clockout(){
        return $this->belongsTo('App\Models\Attendance','id','user_id')->where('default_clockout','=',1);
    }

    public function permissions(){
        return $this->hasMany('App\Models\UserPermission');
    }
    public function tasks(){
        return $this->hasMany('App\Models\Task');
    }

    public function active_tasks(){
        return $this->hasMany('App\Models\Task')->where('is_removed',false);
    }

    public function assigned_tasks(){
        return $this->hasMany('App\Models\Task', 'assigned_by');
    }

    public function leave_types(){
        return $this->hasMany('App\Models\UserLeaveType','user_id','id');
    }
    public function today_attendance(){
        return $this->hasMany('App\Models\Attendance','user_id','id')->whereDate('date',Carbon::today());
    }

    public function today_late_attendance(){
        return $this->hasMany('App\Models\Attendance','user_id','id')->whereDate('date',Carbon::today());
    }

    public function reports(){
        return $this->hasMany('App\Models\Report','user_id','id');
    }

    public function current_salary(){
        return $this->belongsTo('App\Models\Salary','id','user_id')->where('is_active',1);
    }
    public function salary_histories(){
        return $this->hasMany('App\Models\SalaryHistory','user_id','id');
    }
    public function allowances(){
        return $this->belongsToMany('App\Models\PayrollIncome', 'pivot_user_allowances', 'user_id', 'income_id')->withPivot('percent_rate','amount');
    }

    public function recentTravelReports(){
        return $this->hasMany('App\Models\Travel','user_id','id')->latest()->take(2);
    }
    public function allowanceById($allowanceId)
    {
        foreach($this->allowances as $allowance){
            if($allowanceId == $allowance->id){
                return $allowance;
            }
        }
    }
}
