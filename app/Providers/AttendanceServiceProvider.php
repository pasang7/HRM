<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Attendance;
use Carbon\Carbon;
class AttendanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
            if(auth()->user()){

                $user=auth()->user();
                $date=Carbon::today();
                $old_default_clockout = Attendance::where('user_id',$user->id)
                                    ->where('default_clockout',true)
                                    ->first();
                $clockin_time='';
                if($old_default_clockout){
                    $attendance_status='show_default_clockout';
                    $view->with('old_default_clockout', $old_default_clockout);

                }else{
                    $already_clocked_in = Attendance::whereDate('date', $date)
                                        ->where('user_id',$user->id)
                                        ->where('clockout',null)
                                        ->first();
                    if($already_clocked_in){
                        $attendance_status='show_clockout';
                        $clockin_time=Carbon::parse($already_clocked_in->clockin);
    
                    }else{
                        $attendance_status='show_clockin';
    
                    }
                }
                $view->with('attendance_status', $attendance_status);
                $view->with('clockin_time', $clockin_time);

            }
        });
    }
}
