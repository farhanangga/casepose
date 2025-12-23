function notifikasiReports() {
    var notificationDiv = document.getElementById("notification-report");
    notificationDiv.style.display = "block";
}
function triggerButtonClick() {
    document.getElementById("btn-trigger-notif").click();
}
function notifikasiSukses() {
    var notificationDiv = document.getElementById("notif-sukses");
    notificationDiv.style.display = "block";
}
function notifikasiBack(id) {
    var notificationDiv = document.getElementById(id);
    notificationDiv.style.display = "none";
}
