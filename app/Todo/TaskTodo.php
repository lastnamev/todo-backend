<?php

namespace App\Todo;
use Illuminate\Http\Request;

class TaskTodo implements TaskTodoInterface
{
    public function getAllTask($id_category)
    {
        $tasks = auth()->user()->categories()->find($id_category)->tasks;

        if (!$tasks) {
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

    public function getOneTask($id, $id_category)
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

    public function addTask(Request $request, $id_category)
    {
        $validate = $request->validate([
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

    public function updateTask(Request $request, $id, $id_category)
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

    public function deleteTask($id_category, $id)
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
