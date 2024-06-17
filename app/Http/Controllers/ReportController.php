<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Project;
use App\Models\Report;
use Carbon\Carbon;
use Storage;
class ReportController extends Controller
{
    public function index(){
        $reports=Report::with('project')->whereDate('date',Carbon::today())->get();
        return view('report.my-report')->with('reports',$reports);

    }
    public function myReport(){
        $reports=Report::with('project')->where('user_id',Auth::user()->id)->orderBy('date','desc')->get();
        return view('report.my-report')->with('reports',$reports);

    }
    public function create(){
        $projects=Project::select(['id','name','is_other'])->where('department_id',Auth::user()->department_id)->where('status',0)->get();
        return view('report.create')->with('projects',$projects);
    }

    public function store(Request $request){

        $request->validate([
            'report' => 'required',
            'report.*.date' => 'required|date',
            'report.*.project' => 'required|exists:projects,id',
            'report.*.title' => 'sometimes',
            'report.*.time' => 'required',
            'report.*.description' => 'required',
            'report.*.remark' => 'sometimes',
        ]);
        $user=Auth::user();
        foreach($request->report as $report){
            $data=[];

            $project=Project::find($report['project']);
            $data['user_id']=$user->id;
            $data['project_id']=$project->id;
            if(isset($report['title'])){
                $data['title']=$report['title'];
            }
            $data['description']=$report['description'];
            if(isset($report['remark'])){
                $data['remark']=$report['remark'];
            }
            //IF  file
            if(isset($report['file'])){
                $file = $report['file'];
                // $filename=$file->getClientOriginalName();
                $filename=  pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().chr(rand(65,90)).chr(rand(65,90)).'.'.$file->getClientOriginalExtension();
                Storage::disk('files')->put($filename, file_get_contents($file));
                $data['files'] = $filename;
            }
            //IF  file
            $data['date']=Carbon::parse($report['date']);
            $hr = floor( $report['hr_time'] );
            $min = floor( $report['time'] );
            // $min = $report['time'] - $hr;
            $total_time=$hr*60+$min;
            $data['time']=$total_time;
            Report::create($data);
        }
        toastr()->success('Report sent successfully', 'Success !!!');
        return redirect()->back();
    }
}
