@extends('master')

@section('title', 'Lịch làm việc')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-center">Lịch Làm Việc</h2>
        <div id="calendar"></div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales-all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'vi',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: '/api/schedule/events',
                selectable: true,
                editable: false,
                eventClick: function(info) {
                    alert('Sự kiện: ' + info.event.title +
                          '\nBắt đầu: ' + info.event.start.toLocaleString() +
                          '\nKết thúc: ' + (info.event.end ? info.event.end.toLocaleString() : 'Chưa xác định'));
                }
            });
            calendar.render();
        });
    </script>
@endsection
