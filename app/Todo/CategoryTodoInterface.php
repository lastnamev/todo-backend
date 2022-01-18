<?php

namespace App\Todo;

use Illuminate\Http\Request;

interface CategoryTodoInterface
{
    public function getAllCategory();
    public function addCategory(Request $request);
    public function getOneCategory($id);
    public function updateCategory(Request $request, $id);
    public function deleteCategory($id);
}
