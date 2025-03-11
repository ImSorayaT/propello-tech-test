<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = auth()->user()?->tasks ?? [];
        $tags = auth()->user()?->tags ?? [];

        return view('index', compact('tasks', 'tags'));
    }

    public function create(): View
    {

        return view('tasks.create');
    }

    public function edit(Task $task): View
    {
        $this->authorize('update', $task);
        $get_tags = auth()->user()?->tags ?? [];

        $task_tags = $task->tags->map( function($tag){
            return $tag->id;
        })->toArray();


        $tags = $get_tags->map(function ($tag) use ($task_tags){
            
            $result = [
                'id' => $tag->id,
                'name' => $tag->name,
                'selected' => false 
            ];
            
            if(in_array( $tag->id, $task_tags, false)){
                $result['selected'] = true;                
            }
            
            return $result;

            
        });

        return view('tasks.edit', compact('task', 'tags'));
    }

    public function store(CreateTaskRequest $request): RedirectResponse
    {
        Task::query()->create(
            array_merge(
                $request->validated(),
                ['user_id' => auth()->user()->id]
            )
        );

        return redirect()->to(route('tasks.home'));
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $task->update($request->validated());
        $task->tags()->sync($request->input('tags'));

        return redirect()->to(route('tasks.home'));
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->to(route('tasks.home'));
    }

    public function complete(Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $task->complete = !$task->complete;
        $task->save();

        return redirect()->to(route('tasks.home'));
    }
}
