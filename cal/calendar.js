let currentDate = new Date();

function generateCalendar(year, month) {
    document.getElementById("month-year").textContent = new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' }).format(new Date(year, month));
    let firstDay = new Date(year, month, 1).getDay();
    firstDay = (firstDay === 0) ? 6 : firstDay - 1; // Ajuste para empezar en lunes
    let daysInMonth = new Date(year, month + 1, 0).getDate();
    let calendarBody = document.getElementById("calendar-body");
    calendarBody.innerHTML = "";
    let row = document.createElement("tr");
    for (let i = 0; i < firstDay; i++) row.appendChild(document.createElement("td"));
    for (let day = 1; day <= daysInMonth; day++) {
        if (row.children.length === 7) {
            calendarBody.appendChild(row);
            row = document.createElement("tr");
        }
        let cell = document.createElement("td");
        let link = document.createElement("a");
        link.href = `dia.php?f=${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
        link.textContent = day;
        cell.appendChild(link);
        row.appendChild(cell);
    }
    while (row.children.length < 7) row.appendChild(document.createElement("td"));
    calendarBody.appendChild(row);
}

function changeMonth(step) {
    currentDate.setMonth(currentDate.getMonth() + step);
    generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
}

generateCalendar(currentDate.getFullYear(), currentDate.getMonth());