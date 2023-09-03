function val(ev) {
  var password = document.forms["myform2"]["psw"].value;

  if (password == "") {
    alert("Enter password");
    document.forms["myform2"]["psw"].focus();
    ev.preventDefault();
    return false;
  }

  if (password.length < 8) {
    alert("Password must include 8 or more characters");
    document.forms["myform2"]["psw"].focus();
    ev.preventDefault();
    return false;
  }

  let email = document.forms["myform2"]["email"].value;
  if (!(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))) {
    alert("Invalid email address");
    document.forms["myform2"]["psw"].focus();
    ev.preventDefault();
    return false;
  }

}
