<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Todo\CategoryTodoInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $todo;

    public function __construct(CategoryTodoInterface $todo)
    {
        $this->todo = $todo;
    }

    public function index()
    {
        $tasks = $this->todo->getAllCategory();

        return $tasks;
    }

    public function store(Request $request)
    {
        $task = $this->todo->addCategory($request);

        return $task;
    }

    public function show($id)
    {
        $task = $this->todo->getOneCategory($id);

        return $task;
    }


    public function update(Request $request, $id)
    {
        $task = $this->todo->updateCategory($request, $id);

        return $task;
    }


    public function destroy($id)
    {
        $task = $this->todo->deleteCategory($id);

        return $task;
    }
}
