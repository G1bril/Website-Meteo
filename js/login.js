function login() {
    const username = document.getElementById("username").value.toLowerCase().trim();
    const password = document.getElementById("password").value;

    if (username === "") {
        alert("Aucun nom d'utilisateur saisi");
    } else if (password === "") {
        alert("Aucun mot de passe saisi");
    } else {
        sendLoginDetails(username, password);
    }
}

function sendLoginDetails(username, password) {
    const xmlhttp = new XMLHttpRequest();
    const url = "checkLogin.php?username=" + username + "&password=" + password;
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText.trim() !== "") {
                let response = this.responseText;
                alert(response);
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}


