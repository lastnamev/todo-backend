<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = auth()->user()->categories;

        return response()->json([
            'success' => true,
            'data' => $categories,
        ], 200);
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
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

    public function show($id)
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


    public function update(Request $request, $id)
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


    public function destroy($id)
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
