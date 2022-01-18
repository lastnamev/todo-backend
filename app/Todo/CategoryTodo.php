<?php

namespace App\Todo;

use Illuminate\Http\Request;

class CategoryTodo implements CategoryTodoInterface
{
    public function getAllCategory()
    {
        $categories = auth()->user()->categories;

        return response()->json([
            'success' => true,
            'data' => $categories,
        ], 200);
    }

    public function addCategory(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);

        $category = auth()->user()->categories()->create($validate);

        if($category){
            return response()->json([
                'success' => true,
                'message' => 'Категория успешно создана',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Категория не может быть создана',
            ], 200);
        }
    }

    public function getOneCategory($id)
    {
        $categories = auth()->user()->categories()->find($id);

        if (!$categories) {
            return response()->json([
                'success' => false,
                'message' => 'Категории не существует '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $categories,
        ], 200);
    }

    public function updateCategory(Request $request, $id)
    {
//        Временно нет валидации

        $categories = auth()->user()->categories()->find($id);

        if (!$categories) {
            return response()->json([
                'success' => false,
                'message' => 'Такой категории не существует'
            ], 400);
        }

        $updated = $categories->fill($request->all())->save();

        if ($updated)
            return response([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Категория не может быть обновлена'
            ], 500);

    }

    public function deleteCategory($id)
    {
        $category = auth()->user()->categories()->find($id)->delete();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Такой категории не существует'
            ], 400);
        }

        if ($category->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Категория успешно удалена',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Категория не может быть удалена'
            ], 500);
        }
    }
}
