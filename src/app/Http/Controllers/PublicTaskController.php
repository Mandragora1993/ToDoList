<?php

namespace App\Http\Controllers;

use App\Models\TaskToken;
use Illuminate\Http\Request;

class PublicTaskController extends Controller
{
    public function show($token)
    {
        $taskToken = TaskToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $task = $taskToken->task;

        return view('tasks.public', compact('task'));
    }
}