function showImages() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("showimage").innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "displayphp.php?method="+document.getElementById("menu_search").value+"&str="+document.getElementById("menu_search_input").value, true);
    // xhttp.open("GET", "display.php", true);
    xhttp.send();
}

function testMethod() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("showimage").innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "test.php", true);
    // xhttp.open("GET", "display.php", true);
    xhttp.send();
}

function loggedIn() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("user").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "loginuser.php", true);
    xmlhttp.send();
}

function manager(str) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("rightside").innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "adminnav.php?method="+str, true);
    xhttp.send();
}

function test() {
    window.alert("hello");
}

function search() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("listings").innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "searchlisting.php?method="+document.getElementById("option1").value+"&id="+document.getElementById("option2").value, true);
    xhttp.send();
}
