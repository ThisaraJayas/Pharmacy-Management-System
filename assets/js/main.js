/** Creates the menu displayed to mobile users */
function buildMobileMenu() {
    let menuElements = document.querySelectorAll(".main-menu > .menu-item:not(.mobile):not(.spacer)");
    let mobileMenu = document.createElement("div");
    mobileMenu.classList.add("dropdown-menu");
    mobileMenu.id = "mobile-menu";

    let buttonRow = document.createElement("span");
    buttonRow.classList.add("menu-item", "button-row");


    menuElements.forEach((e) => {
        // if the menu item is a button append it to the button row
        let buttonElem = e.querySelector(":scope > .button");
        if (buttonElem) {
            buttonRow.appendChild(buttonElem.cloneNode(true));
            return;
        }
        href = "#"
        mobileMenu.appendChild(e.cloneNode(true));
    });


    mobileMenu.appendChild(buttonRow);


    document.body.appendChild(mobileMenu);


    return mobileMenu;
}

/** Changes the state of the page dimmer.
 *  @param {Boolean} show - If the page dimmer should be shown
 *  @param {HTMLElement} [dimmerElem] - the page dimmer element to use. If this is not set, the global dimmer is used 
 */
function pageDimmer(show, dimmerElem) {

    let dimmer;
    if (dimmerElem) {
        dimmer = dimmerElem;
    } else {
        dimmer = document.querySelector(".page-dimmer");
        if (!dimmer) {
            dimmer = document.createElement("div");
            dimmer.classList.add("page-dimmer");
            document.body.append(dimmer);
        }
    }

    if (show) {
        dimmer.classList.add("visible");
    } else {
        dimmer.classList.remove("visible");
    }

    document.body.style.overflow = show ? "hidden" : "scroll";

}
/** creates a dropdown menu
 * @param {HTMLElement} opener - the element that opens the dropdown menu
 * @param {HTMLElement} content - the content of the dropdown menu
 * @param {Object} [options] - options for the dropdown 
 * @param {Boolean} options.opened - If the dropdown menu should be created in the open state.
 * @param {Boolean} options.showDimmer - If the page should be dimmed when opening the dropdown.
 */
function dropdown(opener, content, options) {
    let dimmer;

    const showDropdown = () => {
        let firstClick = true;
        content.classList.add("visible");
        if (dimmer) {
            pageDimmer(true, dimmer);
        }

        let menuClickHandler = (event) => {
            if (!content.contains(event.target)) {
                if (opener.contains(event.target) && firstClick) {
                    firstClick = false;
                    return;
                }

                // close the menu if the click is outside the menu
                content.classList.remove("visible");
                if (dimmer) {
                    pageDimmer(false, dimmer);
                }
                document.body.removeEventListener("click", menuClickHandler)
            }
        }


        document.body.addEventListener("click", menuClickHandler);
    }


    opener.addEventListener("click", (ev) => {
        if (content.classList.contains("visible")) {
            // the menu is already open, ignore the click.
            return;
        }

        showDropdown();
    });

    if (!content.classList.contains("dropdown-menu")) {
        content.classList.add("dropdown-menu");
    }



    if (options) {
        if (options.showDimmer) {
            dimmer = document.createElement("div");
            dimmer.classList.add("page-dimmer");
            content.after(dimmer);
        }

        if (options.shown) {
            showDropdown()
        }
    }
}



let mobileMenuOpener = document.getElementById("menu-opener");

mobileMenuOpener.addEventListener("click", () => {
    buildMobileMenu();
    dropdown(
        mobileMenuOpener,
        document.getElementById("mobile-menu"),
        { showDimmer: true, shown: true });

}, { once: true })



dropdown(
    document.getElementById("user-menu-opener"),
    document.getElementById("user-menu"));
