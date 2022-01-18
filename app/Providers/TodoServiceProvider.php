<?php

namespace App\Providers;

use App\Models\Category;
use App\Todo\CategoryTodo;
use App\Todo\CategoryTodoInterface;
use App\Todo\TaskTodo;
use App\Todo\TaskTodoInterface;
use Illuminate\Support\ServiceProvider;

class TodoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryTodoInterface::class, CategoryTodo::class);
        $this->app->bind(TaskTodoInterface::class, TaskTodo::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
