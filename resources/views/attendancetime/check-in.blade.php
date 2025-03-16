@extends('master')

@section('title', 'Điểm danh')

@section('content')
    <h2>Lịch Điểm Danh</h2>
    <h3 id="current-date"></h3>
    <div class="calendar" id="calendar"></div>

    <!-- Modal Xác Nhận -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận điểm danh</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn điểm danh cho ngày hôm nay không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="confirmCheckIn">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/check-in.css') }}">
@endsection

@section('js')
    <script>
        let selectedCheckbox = null;

        function generateCalendar() {
            let today = new Date();
            let year = today.getFullYear();
            let month = today.getMonth() + 1;
            let currentDay = today.getDate();
            let daysInMonth = new Date(year, month, 0).getDate();
            let calendar = document.getElementById("calendar");
            calendar.innerHTML = "";

            document.getElementById("current-date").textContent = `Hôm nay: ${currentDay}/${month}/${year}`;

            for (let day = 1; day <= daysInMonth; day++) {
                let dayDiv = document.createElement("div");
                dayDiv.classList.add("day");

                let label = document.createElement("label");
                label.textContent = day;

                // Checkbox điểm danh ca sáng
                let morningLabel = document.createElement("span");
                morningLabel.classList.add("shift-label");
                morningLabel.textContent = "Sáng";

                let morningCheckbox = document.createElement("input");
                morningCheckbox.type = "checkbox";
                morningCheckbox.dataset.day = day;
                morningCheckbox.dataset.shift = "morning";

                // Checkbox điểm danh ca chiều
                let afternoonLabel = document.createElement("span");
                afternoonLabel.classList.add("shift-label");
                afternoonLabel.textContent = "Chiều";

                let afternoonCheckbox = document.createElement("input");
                afternoonCheckbox.type = "checkbox";
                afternoonCheckbox.dataset.day = day;
                afternoonCheckbox.dataset.shift = "afternoon";

                // Kiểm tra trạng thái điểm danh từ localStorage
                morningCheckbox.checked = localStorage.getItem(`attendance_${year}_${month}_${day}_morning`) === "true";
                afternoonCheckbox.checked = localStorage.getItem(`attendance_${year}_${month}_${day}_afternoon`) === "true";

                if (morningCheckbox.checked) morningCheckbox.parentElement?.classList.add("checked");
                if (afternoonCheckbox.checked) afternoonCheckbox.parentElement?.classList.add("checked");

                // Chỉ cho phép điểm danh ngày hiện tại
                if (day !== currentDay) {
                    morningCheckbox.disabled = true;
                    afternoonCheckbox.disabled = true;
                    dayDiv.classList.add("disabled");
                }

                // Thêm sự kiện khi click vào checkbox
                morningCheckbox.addEventListener("change", handleCheckIn);
                afternoonCheckbox.addEventListener("change", handleCheckIn);

                dayDiv.appendChild(label);
                dayDiv.appendChild(morningLabel);
                dayDiv.appendChild(morningCheckbox);
                dayDiv.appendChild(afternoonLabel);
                dayDiv.appendChild(afternoonCheckbox);
                calendar.appendChild(dayDiv);
            }
        }

        function handleCheckIn(event) {
            event.preventDefault();
            let checkbox = event.target;
            let shift = checkbox.dataset.shift;
            let day = checkbox.dataset.day;
            let today = new Date();
            let year = today.getFullYear();
            let month = today.getMonth() + 1;
            let key = `attendance_${year}_${month}_${day}_${shift}`;

            if (checkbox.checked) {
                // Nếu đang tick vào, hiển thị modal
                selectedCheckbox = checkbox;
                $('#confirmModal').modal('show');
            } else {
                // Nếu bỏ tick, xóa trạng thái điểm danh
                localStorage.removeItem(key);
                checkbox.parentElement?.classList.remove("checked");
            }
        }

        // Xác nhận điểm danh
        document.getElementById("confirmCheckIn").addEventListener("click", function() {
            if (selectedCheckbox) {
                let shift = selectedCheckbox.dataset.shift;
                let day = selectedCheckbox.dataset.day;
                let today = new Date();
                let year = today.getFullYear();
                let month = today.getMonth() + 1;
                let key = `attendance_${year}_${month}_${day}_${shift}`;

                // Lưu trạng thái điểm danh vào localStorage
                localStorage.setItem(key, "true");

                // Cập nhật giao diện
                selectedCheckbox.checked = true;
                selectedCheckbox.parentElement?.classList.add("checked");
                $('#confirmModal').modal('hide');
            }
        });

        generateCalendar();
    </script>
@endsection
