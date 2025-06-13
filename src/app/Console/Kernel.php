protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $tomorrow = now()->addDay()->toDateString();
        $tasks = \App\Models\Task::where('due_date', $tomorrow)->get();
        foreach ($tasks as $task) {
            $task->user->notify(new \App\Notifications\TaskDueTomorrow($task));
        }
    })->dailyAt('08:00');
}