const userDetailForm = document.querySelector("#user-details");
const editDetail = userDetailForm.querySelector(".edit-button");
const userDetailCancel = userDetailForm.querySelector(".cancel-button");

const userPasswordForm = document.querySelector("#user-password");

editDetail.addEventListener("click", () => {
    userDetailForm.classList.add("edit");
});

userDetailCancel.addEventListener("click", () => {
    userDetailForm.classList.remove("edit");
})

userDetailForm.addEventListener("submit", (ev) => {
    const firstName = userDetailForm.querySelector("input[name='firstName']").value;
    if (firstName.length < 2) {
        alert("Invalid First Name");
        ev.preventDefault();
        return;
    }

    const lastName = userDetailForm.querySelector("input[name='lastName']").value;
    if (lastName.length < 2) {
        alert("Invalid Last Name");
        ev.preventDefault();
        return;
    }

    const email = userDetailForm.querySelector("input[name='email']").value;
    if (!(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))) {
        alert("Invalid Email");
        ev.preventDefault();
        return;
    }

    const phone = userDetailForm.querySelector("input[name='phone']").value;
    if (!(/^\d{10}$/g.test(phone))) {
        alert("Invalid Phone Number");
        ev.preventDefault();
        return;
    }
});

userPasswordForm.addEventListener("submit", (ev) => {
    const password = userPasswordForm.querySelector("input[name='password']").value;
    if (password.length < 8) {
        alert("Password must be at least 8 characters.");
        ev.preventDefault();
        return;
    }

    const passwordConf = userPasswordForm.querySelector("input[name='passwordConfirm']").value;
    if (password !== passwordConf) {
        alert("Passwords do not match");
        ev.preventDefault();
        return;
    }
});