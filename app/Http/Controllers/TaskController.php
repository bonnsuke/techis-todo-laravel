<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Repositories\TaskRepository;


class TaskController extends Controller

{
    /**
     * TaskRepository
     *
     * @var TaskRepository
     */
    protected $tasks;
    

    //コンストラクタを設置(自動的に呼び出される初期化処理用のメソッド)
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');  //認証機能をタスクコントローラーで有効にする

        $this->tasks = $tasks;
    }


    /**
        * タスク一覧
        *
        * @param Request $request
        * @return Response
        */
    public function index(Request $request)
    {
        // $tasks = Task::orderBy('created_at', 'asc')->get();
        // $tasks = $request->user()->tasks()->get();

        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }
    

    /**
     * タスク登録
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        // タスク作成
        // Task::create([
        //     'user_id' => 0,
        //     'name' => $request->name
        // ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');

    }

    /**
     * タスク削除
     *
     * @param Request $request
     * @param Task $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();
        return redirect('/tasks');
    }
}
