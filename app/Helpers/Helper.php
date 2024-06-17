<?php
namespace App\Helpers;

use App\Models\EngMonth;
use App\Models\Leave;
use App\Models\Travel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class Helper
{
    public static function calculateTravelRequest()
    {
        $total=Travel::orderBy('created_at', 'asc')->where('is_reviewed', 0)
        ->whereHas('user.department', function($query){
                $query->where('id', Auth::user()->department->id);
        })->get()->count();
        return $total;
    }
    public static function calculateTravelApproval()
    {
        $total=Travel::orderBy('created_at', 'asc')->where('is_reviewed', 1)
        ->where('is_accepted', 0)->get()->count();
        return $total;
    }
    public static function calculateLeaveRequest()
    {
        $total=Leave::where('is_reviewed', 0)->where('is_accepted', 0)->where('is_rejected', 0)
        ->whereHas('user.approveBy', function($query){
                $query->where('id', Auth::user()->id);
        })->get()->count();
        return $total;
    }
    public static function calculateLeaveApprove()
    {
        $total=Leave::orderBy('created_at', 'asc')->where('is_reviewed', 1)->where('is_accepted', 0)
        ->where('is_rejected', 0)
        ->get()->count();
        return $total;
    }
    public static function getEngMonths(){
        $months = EngMonth::orderBy('created_at')->get();
        return $months;
    }
}
?>
