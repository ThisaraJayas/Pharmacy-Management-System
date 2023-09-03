function checkDetails(ev) {
    const firstName = ev.target.elements['firstName'].value;
    if (firstName.length < 2) {
        alert("Invalid First Name");
        ev.preventDefault();
        return;
    }

    const lastName = ev.target.elements['lastName'].value;
    if (lastName.length < 2) {
        alert("Invalid Last Name");
        ev.preventDefault();
        return;
    }

    const email = ev.target.elements['Email'].value;
    if (!(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))) {
        alert("Invalid Email");
        ev.preventDefault();
        return;
    }

    const phone = ev.target.elements['telephoneNo'].value;
    if (!(/^\d{10}$/g.test(phone))) {
        alert("Invalid Phone Number");
        ev.preventDefault();
        return;
    }
}
