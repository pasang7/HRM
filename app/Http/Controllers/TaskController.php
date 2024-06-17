<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

use Carbon\Carbon;
use Auth;
class TaskController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'user_id' => 'required',
            'deadline' => 'required|date',
            'priority'=>'required',
            'task'=>'required'
        ]);


        $data=$request->except('_token','deadline');
        $data['deadline']=Carbon::parse($request->deadline);
        Task::create($data);
        return redirect()->back();
    }

    public function markComplete(Request $request){
        $task=Task::find($request->id);
        $task->is_complete=true;
        $task->update();
        return json_encode(true);
    }
    public function removeTask(Request $request){
        $task=Task::find($request->id);
        $task->is_removed=true;
        $task->update();
        return json_encode(true);
    }
    public function clearCompleted(){
        $tasks=Task::where('user_id',Auth::user()->id)
                    ->where('is_complete',true)
                    ->where('is_removed',false)
                    ->get();
        foreach($tasks as $task){
            $task->is_removed=true;
            $task->update();
        }

        return redirect()->back();

    }
    public function clearAll(){
        $tasks=Task::where('user_id',Auth::user()->id)
                    ->where('is_removed',false)
                    ->get();
        foreach($tasks as $task){
            $task->is_removed=true;
            $task->update();
        }

        return redirect()->back();
    }
}
