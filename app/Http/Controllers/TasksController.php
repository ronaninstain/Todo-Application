<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('dashboard', [
            'tasks' => Task::orderBy('id', 'asc')->where('user_id', $user->id)->get(),
        ]);
    }

  /*   public function index_all(){
        $user = Auth::user();

        return view('tasks.filtered',[
            'tasks' => Task::orderBy('created_at', 'asc')->where('user_id', $user->id)->get(),
        ]);
    }

    public function index_incomplete(){
        $user = Auth::user();

        return view('tasks.filtered', [
            'tasks' => Task::orderBy('created_at', 'asc')->where('user_id', $user->id)->where('completed', '0')->get(),
        ]);
    }

    public function index_complete(){
        $user = Auth::user();

        return view('tasks.filtered', [
            'tasks' => Task::orderBy('created_at', 'asc')->where('user_id', $user->id)->where('completed', '1')->get(),
        ]);
    }

    */

    public function add(){
        $statuses = [
            [
                'label' => 'Todo',
                'value' => 'Todo',
            ],
            [
                'label' => 'Done',
                'value' => 'Done',
            ],
        ];
        return view('add', compact('statuses'));
    }

    public function create(Request $request){
        $this->validate($request, [
            'description' => 'required'
        ]);

        $task = new Task();
        $task->description = $request->description;
        $task->user_id = auth()->user()->id;
        $task->status = $request->status;
        $task->save();

        return redirect('/dashboard');

    }

    public function edit(Task $task){
        if(auth()->user()->id == $task->user_id){

            $statuses = [
                [
                    'label' => 'Todo',
                    'value' => 'Todo',
                ],
                [
                    'label' => 'Done',
                    'value' => 'Done',
                ],
            ];

            return view('edit', compact('statuses', 'task'));

        }else{

            return redirect('/dashboard');
        }
    }

    public function update(Request $request, Task $task){
        if(isset($_POST['delete'])){

            $task->delete();

            return redirect('/dashboard');

        }else{

            $this->validate($request, [
                'description' => 'required'
            ]);

            $task->description = $request->description;
            $task->status = $request->status;
            $task->save();

            return redirect('/dashboard');
        }
    }
}
