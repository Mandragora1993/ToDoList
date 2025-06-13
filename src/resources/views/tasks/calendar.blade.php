@extends('app')

@section('title', 'Kalendarz zadań')

@section('content')
<div class="d-flex mb-3 justify-content-between align-items-center">
    <h1 class="mb-0">Kalendarz zadań</h1>
    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Lista zadań</a>
</div>

<div id="calendar"></div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.css" rel="stylesheet">
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pl',
            events: [
                @foreach($tasks as $task)
                {
                    title: '{{ addslashes($task->name) }}',
                    start: '{{ $task->due_date->format('Y-m-d') }}',
                    url: '{{ route('tasks.show', $task) }}',
                    color: 
                        @if($task->priority == 'high')
                            '#dc3545'
                        @elseif($task->priority == 'medium')
                            '#ffc107'
                        @else
                            '#28a745'
                        @endif
                },
                @endforeach
            ],
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.url) {
                    window.location.href = info.event.url;
                }
            }
        });
        calendar.render();
    });
</script>
@endpush