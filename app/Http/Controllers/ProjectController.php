<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Project;

use Carbon\Carbon;
use Validator;
class ProjectController extends Controller
{
    public function index(){
        $projects=Project::with('department')->get();
        return view('project.index')
                ->with('projects',$projects);

    }
    public function create(){
        $departments=Department::where('is_default',false)->get();
        return view('project.create')
                ->with('departments',$departments);
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'deadline' => 'required|date',
            'department_id' => 'required|array',
            'department_id.*' => 'required|numeric|exists:departments,id',
        ]);
       

        $data=$request->except('_token','deadline', 'department_id');
        $data['deadline']=Carbon::parse($request->deadline);
        
        foreach($request->department_id as $department_id){
            $department=Department::find($department_id);           
            $data['department_id']= $department->id;
            Project::create($data);
        }


        return redirect()->route('project.index');
    }

    public function edit($slug){
        $project=Project::where('slug',$slug)->first();
        if($project){
            return view('project.edit')
                    ->with('project',$project);
        }else{
            return redirect()->route('project.index');
        }
    }

    public function update(Request $request){
        $request->validate([
            'slug'=>'required|exists:projects,slug',
            'deadline' => 'required|date',

        ]);
       
        $project=Project::where('slug',$request->slug)->first();

        if($request->name!=$project->email){
            $project->name=$request->name;
        }
        if(Carbon::parse($request->deadline)!=$project->deadline){
            $project->deadline=Carbon::parse($request->deadline);
        }
        $project->update();
        return redirect()->route('project.index');

    }

    public function markComplete($slug){
        $project=Project::where('slug',$slug)->first();
        if($project){
            $project->status=true;
            $project->update();
            return redirect()->route('project.index');
        }else{
            return redirect()->route('project.index');
        }
    }
}
