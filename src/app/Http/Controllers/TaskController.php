<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        if ($request->priority) {
            $query->where('priority', $request->priority);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->due_date) {
            $query->where('due_date', $request->due_date);
        }

        $tasks = $query->orderBy('due_date')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(TaskRequest $request)
    {
        $task = Task::create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);
        // (Opcjonalnie zapisz historię)
        return redirect()->route('tasks.index');
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $task->update($request->validated());
        // (Opcjonalnie zapisz historię)
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function generatePublicLink(Task $task)
{
    $this->authorize('view', $task);
    $token = bin2hex(random_bytes(32));
    $expiresAt = now()->addHours(24); // lub dowolny czas

    $link = $task->publicLinks()->create([
        'token' => $token,
        'expires_at' => $expiresAt,
    ]);
    return url("/task/public/{$token}");
}
}