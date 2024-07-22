<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
class TaskController extends Controller
{
   
    public function index()
    {
        $tasks = Task::with('category')->get();
        return response()->json($tasks);
    }
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(TaskRequest $request)
    {
        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->all());
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}