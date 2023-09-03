const uploadButton = document.getElementById("prescription-upload-button");
const uploadModal = document.getElementsByClassName("modal-container")[0];
const uploadForm = uploadModal.querySelector("form");
const uploadDropZone = uploadForm.querySelector("#pres-img-upload");
const uploadFileSelector = uploadDropZone.querySelector("input[type='file']");
const uploadFormSubmit = uploadForm.querySelector("button[type='submit']");
const uploadSelectTextButton = uploadForm.querySelector("#pres-upload-button");
const uploadSelectedFile = uploadForm.querySelector("#pres-upload-selected");

let formFile;
const supportedTypes = ['image/jpeg', 'image/png', 'application/pdf'];


/** closes the upload prescription modal */
function closeModal() {
    pageDimmer(false);
    uploadModal.classList.remove("visible");
    uploadForm.reset();
    uploadFormSubmit.disabled = true;
    uploadFileSelector.value = "";
    uploadSelectedFile.innerText = "";
}


/**
 * handles selecting the file to upload
 * @param {FileList} files: the file 
 */
function selectFile(files) {
    if (files.length === 1) {
        const file = files[0];

        if (file.size > 2 << 20) {
            alert("Max file size is 2MB");
            uploadFormSubmit.disabled = true;
            uploadFileSelector.value = "";
            return;
        }

        if (supportedTypes.indexOf(file.type) === -1) {
            alert("Only JPG, PNG and PDF files are supported");
            uploadFormSubmit.disabled = true;
            uploadFileSelector.value = "";
            return;
        }

        formFile = file;
        uploadSelectedFile.innerText = formFile.name;
        uploadFormSubmit.disabled = false;
    }
}

uploadSelectTextButton.addEventListener("click", () => { uploadFileSelector.click(); })

uploadButton.addEventListener("click", () => {
    pageDimmer(true);
    uploadModal.classList.add("visible")
});

document.querySelectorAll(".modal-close").forEach(e => e.addEventListener("click", closeModal));

uploadDropZone.addEventListener("dragover", (event) => event.preventDefault());

uploadDropZone.addEventListener("drop", (event) => {
    event.preventDefault();
    event.stopImmediatePropagation();

    if (event.dataTransfer.items) {
        selectFile(event.dataTransfer.files);
    }
});


uploadFileSelector.addEventListener("change", (ev) => {
    selectFile(uploadFileSelector.files)
});


let formDataEventFired = false;

uploadForm.addEventListener("formdata", (event) => {
    formDataEventFired = true;

    event.formData.set("pres-image", formFile, formFile.name);
    event.formData.set("action", "upload");
})

uploadForm.addEventListener("submit", (event) => {
    let formData = new FormData(uploadForm);

    // check if the formdata event was called.
    // if it was called, the above event listener injects the image and action correctly and 
    // we can let the browser submit the form.
    // Otherwise, the form needs to be submitted using js.
    if (formDataEventFired) {
        return;
    }

    formData.set("pres-image", formFile, formFile.name);
    formData.set("action", "upload");

    fetch(window.location.toString(), { method: "post", body: formData }).then(() => {
    }).catch(() => {
        alert("An error occurred while submitting the prescription. Please try again later");
    }).finally(() => {
        closeModal();
        window.location = "./prescriptions.php"
    });


    event.preventDefault();
});

// remove query from url to prevent user reload causing the same action multiple times.
if (window.location.search !== "") {
    history.replaceState({}, "", window.location.pathname);
}