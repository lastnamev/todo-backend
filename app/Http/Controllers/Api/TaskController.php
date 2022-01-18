<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function index($id_category)
    {
        $tasks = auth()->user()->categories()->find($id_category)->tasks;

        if(!$tasks){
            return response()->json([
                'success' => false,
                'message' => 'Нет заданий'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $tasks,
        ], 200);
    }


    public function store(Request $request, $id_category)
    {
        $validate = $this->validate($request, [
            'name' => 'required',
            'text' => 'required',
            'completed' => 'required',
        ]);

        if(!$validate){
            return response()->json([
                'success' => false,
                'message' => 'Валидация не пройдена'
            ], 500);
        }

        $task = auth()->user()->categories()->find($id_category)->tasks()->create($validate)->get();

        if($task){
            return response()->json([
                'success' => true,
                'data' => $task,
                'message' => 'Задание успешно создано',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Задание не может быть создано',
            ], 200);
        }

    }


    public function show($id_category, $id)
    {
        $task = auth()->user()->categories()->find($id_category)->tasks()->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Задания не существует '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $task,
        ], 200);
    }


    public function update(Request $request, $id, $id_category)
    {
//        Временно нет валидации
//        $validate = $request->validate([
//            'name'
//        ]);


        $task = auth()->user()->categories()->find($id_category)->tasks->find($id)->fill($request->all())->save();

        return response()->json([
            'success' => true,
            'data' => $task,
        ], 200);

    }


    public function destroy($id_category, $id)
    {
        $task = auth()->user()->categories()->find($id_category)->tasks->find($id)->delete();

        if ($task->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Задача успешно удалена',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Задача не может быть удалена'
            ], 500);
        }

    }


}
