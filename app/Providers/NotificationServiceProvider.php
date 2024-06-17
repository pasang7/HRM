<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Leave;
use App\Models\User;
use DateTime;
use DateInterval;
use Carbon\Carbon;
use Auth;
class NotificationServiceProvider extends ServiceProvider
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
            $leave=[
                'alert'=>false,
                'count'=>0
            ];
            $birthday=[
                'alert'=>false,
                'count'=>0
            ];
            if(auth()->user()){
                if(auth()->user()->role==1){ //Department HEad
                    $valid_users=User::select('id')->where('department_id',Auth::user()->department_id)->get();
                    $users=[];
                    foreach($valid_users as $valid_user){
                        $users[]=$valid_user->id;
                    }
                    $leave_requests=Leave::whereIn('user_id', $users)
                                            ->where('is_accepted',false)
                                            ->where('is_rejected',false)
                                            ->count();
                    if($leave_requests>0){
                        $leave=[
                            'alert'=>true,
                            'count'=>$leave_requests
                        ];

                    }
                }
                if(auth()->user()->role==2 || auth()->user()->role==4 ){ //HR and Admin
                    $leave_requests=Leave::where('is_accepted',false)
                                            ->where('is_rejected',false)
                                            ->count();
                    if($leave_requests>0){
                        $leave=[
                            'alert'=>true,
                            'count'=>$leave_requests
                        ];

                    }
                }

                if(auth()->user()->role!=0){
                    $birthday=array();
                    $users = User::where('department_id','!=',1)->where('is_deleted',0)->get();
                    $date = new DateTime();
                    
                    foreach($users as $user){
                        
                        $dob= $user->dob->format('m-d');
                        $dob_m =$user->dob->format('m');
                      
                        if($dob==date('m-d')){
                            $birthday['today'][]=$user;
                        }
                        if($dob>date('m-d') && $dob <= Carbon::now()->endOfWeek()->format('m-d')){
                            $birthday['this_week'][]=$user;
                        }
                        if($dob_m==date('m') && $dob > date('m-d') ){
                            $birthday['this_month'][]=$user;            
                        }
                        
                        
                    }

                    if(isset($birthday['today'])){
                        $birthday=[
                            'alert'=>true,
                            'count'=>count($birthday['today'])
                        ];
                    }
                }

                
            }
            $view->with('nsp_leave', $leave);
            $view->with('nsp_birthday', $birthday);

            
        });
    }
}
