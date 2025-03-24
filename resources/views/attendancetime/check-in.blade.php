{{-- @php
    dd($scheduleOfEmployee);
@endphp --}}

@extends('master')

@section('title', 'Điểm danh')

@section('content')
    <h2>Lịch Điểm Danh</h2>
    <h3 class="text-dark" id="current-date"></h3>
    <h6 class="text-dark font-italic mb-2">(Vui lòng tiến hành điểm danh trước 15 phút so với giờ làm việc thực tế, nếu không sẽ bị tính là trễ giờ)</h6>
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
        let scheduleOfEmployee = @json($scheduleOfEmployee);
        let employeeId = @json(Auth::guard('web')->id() - 1);
        console.log(scheduleOfEmployee, employeeId);
        // Kiểm tra thời gian thực có thuộc ca làm việc không
        function isWithinShiftTime(shift) {
            let now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();

            if (shift === "morning") {
                return (hours > 7 || (hours === 7 && minutes >= 30)) && (hours < 12);
            } else if (shift === "afternoon") {
                return (hours > 13 || (hours === 13 && minutes >= 30)) && (hours < 19);
            }
            return false;
        }

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

                // ✅ Tự động tick vào ca làm việc đã có
                scheduleOfEmployee.forEach((shift) => {
                    let attendanceDate = new Date(shift.attendance_date + " " + shift.attendance_time);
                    let shiftDay = attendanceDate.getDate();
                    let shiftHour = attendanceDate.getHours();

                    if (shiftDay === day && shift.type == 1) {
                        if (shiftHour < 12) {
                            morningCheckbox.checked = true;
                            morningCheckbox.disabled = true;
                            morningCheckbox.parentElement?.classList.add("checked");
                        } else {
                            afternoonCheckbox.checked = true;
                            afternoonCheckbox.disabled = true;
                            afternoonCheckbox.parentElement?.classList.add("checked");
                        }
                    }
                });

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
                // document.querySelectorAll("input[type='checkbox']").forEach((checkbox) => {
                //     checkbox.disabled = true;
                // });
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
                // Kiểm tra xem có đang trong ca làm việc không
                if (!isWithinShiftTime(shift)) {
                    alert("Hiện không phải thời gian điểm danh của ca này!");
                    checkbox.checked = false; // Hủy tick
                    return;
                }

                // Nếu hợp lệ, hiển thị modal xác nhận
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

                const currentYear = today.getFullYear();
                const currentMonth = String(today.getMonth() + 1).padStart(2, '0'); // Tháng (01-12)
                const currentDay = String(today.getDate()).padStart(2, '0'); // Ngày (01-31)
                const hours = String(today.getHours()).padStart(2, '0'); // Giờ (00-23)
                const minutes = String(today.getMinutes()).padStart(2, '0'); // Phút (00-59)
                const seconds = String(today.getSeconds()).padStart(2, '0'); // Giây (00-59)

                const formattedDate = `${currentYear}-${currentMonth}-${currentDay}`;
                const formattedTime = `${hours}:${minutes}:${seconds}`;

                console.log(formattedDate, formattedTime, scheduleOfEmployee);

                $.ajax({
                    url: "{{ route('attendance-time.store') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        employee_id: employeeId,
                        attendance_date: formattedDate,
                        attendance_time: formattedTime
                    },
                    success: function(response) {
                        alert("Điểm danh thành công!");
                        console.log(response);
                        selectedCheckbox.classList.add("checked-current");

                        selectedCheckbox.checked = true;
                        selectedCheckbox.disabled = true;
                        selectedCheckbox.parentElement?.classList.add("checked");

                        localStorage.setItem(key, "true");

                        $('#confirmModal').modal('hide');
                        // selectedCheckbox.parentElement?.classList.add("checked-current");
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi:", xhr.responseText);
                        alert("Không thể điểm danh, vui lòng thử lại! Lỗi: " + xhr.status + " - " +
                            error);
                    }
                });

                // // Lưu trạng thái điểm danh vào localStorage
                // localStorage.setItem(key, "true");

                // // Cập nhật giao diện
                // selectedCheckbox.checked = true;
                // selectedCheckbox.parentElement?.classList.add("checked");

                // const checkedCurrent = document.querySelector(".checked-current");
                // if (checkedCurrent) {
                //     checkedCurrent.disabled = true;
                // }

                // $('#confirmModal').modal('hide');
            }
        });


        generateCalendar();
    </script>
@endsection
