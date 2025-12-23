function notifikasiEditSucces() {
    var notificationDiv = document.getElementById("notification-edit");
    notificationDiv.style.display = "block";
}

function notifikasiEditRemove() {
    var notificationDiv = document.getElementById("notification-edit-remove");
    notificationDiv.style.display = "block";
}

function notifikasiEditSuccesBack(id) {
    var notificationDiv = document.getElementById(id);
    notificationDiv.style.display = "none";
}

