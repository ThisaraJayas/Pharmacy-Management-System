function val() {
    var password = document.forms["myform"]["psw"].value;

    if (password == "") {
        alert("Enter password");
        document.forms["myform"]["psw"].focus();
        return false;
    }

    if (password.length < 8) {
        alert("Password must include 8 or more characters");
        document.forms["myform"]["psw"].focus();
        return false;
    }

}

