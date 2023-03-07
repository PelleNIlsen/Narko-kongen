function callPingUser() {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("yes " + xhr.responseText);
        }
    };

    xhr.open("POST", "assetts/AJAX/ping.php", true);

    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.send(JSON.stringify({
        "functionName": "pingUser"
    }));
}

setInterval(callPingUser, 60000);