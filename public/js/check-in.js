let selectedCheckbox = null;

function generateCalendar() {
    let today = new Date();
    let year = today.getFullYear();
    let month = today.getMonth() + 1;
    let currentDay = today.getDate();
    let daysInMonth = new Date(year, month, 0).getDate();
    let calendar = document.getElementById("calendar");
    calendar.innerHTML = "";

    document.getElementById(
        "current-date"
    ).textContent = `Hôm nay: ${currentDay}/${month}/${year}`;

    for (let day = 1; day <= daysInMonth; day++) {
        let dayDiv = document.createElement("div");
        dayDiv.classList.add("day");

        let label = document.createElement("label");
        label.textContent = day;

        let checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.dataset.day = day;

        // Kiểm tra trạng thái điểm danh từ localStorage
        checkbox.checked =
            localStorage.getItem(`attendance_${year}_${month}_${day}`) ===
            "true";
        if (checkbox.checked) dayDiv.classList.add("checked");

        // Chỉ cho phép điểm danh ngày hiện tại
        if (day !== currentDay) {
            checkbox.disabled = true;
            dayDiv.classList.add("disabled");
        }

        // Thêm sự kiện khi click vào checkbox
        checkbox.addEventListener("change", function (event) {
            event.preventDefault();
            if (this.checked) return; // Nếu đã tick rồi, không hiện modal nữa
            selectedCheckbox = this;
            $("#confirmModal").modal("show");
        });

        dayDiv.appendChild(label);
        dayDiv.appendChild(checkbox);
        calendar.appendChild(dayDiv);
    }
}

// Xác nhận điểm danh
document.getElementById("confirmCheckIn").addEventListener("click", function () {
    if (selectedCheckbox) {
        let day = selectedCheckbox.dataset.day;
        let today = new Date();
        let year = today.getFullYear();
        let month = today.getMonth() + 1;

        // Lưu trạng thái điểm danh vào localStorage
        localStorage.setItem(`attendance_${year}_${month}_${day}`, "true");

        // Cập nhật giao diện
        selectedCheckbox.checked = true;
        selectedCheckbox.parentElement.classList.add("checked");
        $("#confirmModal").modal("hide");
    }
});

generateCalendar();
