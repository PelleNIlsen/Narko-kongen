function callPingUser() {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log("yes " + xhr.responseText);
            var onlineUserList = document.getElementById("onlineUsers");
            onlineUserList.innerHTML = "";
            var usernames = JSON.parse(xhr.responseText);

            for (var i = 0; i < usernames.length; i++) {
                var li = document.createElement("li");
                li.appendChild(document.createTextNode(usernames[i]));
                onlineUserList.appendChild(li);
            }
        }
    };

    xhr.open("POST", "assetts/AJAX/ping.php", true);

    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.send(JSON.stringify({
        "functionName": "pingUser"
    }));
}

setInterval(callPingUser, 5000);