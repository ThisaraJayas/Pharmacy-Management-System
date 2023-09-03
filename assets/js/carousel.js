
function initCarousel(carouselElem, displayItems, options) {
    console.assert(typeof (displayItems) === "number" && displayItems > 0, "invalid value for displayItems")

    let contents = carouselElem.querySelector(".carousel-contents");

    for (let i = 0; i < displayItems && i < contents.children.length; i++) {
        contents.children[i].classList.add("visible");
    }

    if (contents.childElementCount <= displayItems) {
        console.log(`Skipping animation for carousel with ${displayItems} displayItems and ${contents.length} items`);
        return;
    }

    let isHovering = false;

    carouselElem.addEventListener("mouseover", (e) => {
        isHovering = true;
    });

    carouselElem.addEventListener("mouseleave", (e) => {
        isHovering = false;
    });


    const forwards = () => {
        let first = contents.children[0];
        first.classList.remove("visible");
        first.remove();

        contents.children[displayItems - 1].classList.add("visible");

        contents.appendChild(first);
    }

    const backwards = () => {
        let last = contents.children[contents.children.length - 1];
        last.remove();

        contents.children[displayItems - 1].classList.remove("visible");
        last.classList.add("visible");
        contents.prepend(last);
    }

    if (options && options.hasControls) {
        const makeButton = (className, name, src) => {
            const button = document.createElement("img");
            button.src = src;
            button.alt = name;
            button.classList.add(className);
            button.style.height = "40px";
            return button;
        };

        let nextButton = carouselElem.querySelector(".carousel-next");
        if (!nextButton) {
            nextButton = makeButton("carousel-next", "Next Button", "/assets/images/icons/arrow-circle-right.svg");
            carouselElem.appendChild(nextButton);
        }

        let prevButton = carouselElem.querySelector(".carousel-prev");
        if (!prevButton) {
            prevButton = makeButton("carousel-prev", "Previous Button", "/assets/images/icons/arrow-circle-left.svg");
            carouselElem.prepend(prevButton);
        }

        prevButton.addEventListener("click", () => backwards());
        nextButton.addEventListener("click", () => forwards());
    }


    if (options && options.center) {
        let spacer = document.createElement("span");
        spacer.classList.add("carousel-spacer");
        carouselElem.prepend(spacer.cloneNode());
        carouselElem.appendChild(spacer);
    }

    const speed = options && options.speed > 0 ? options.speed : 2000;

    setInterval(() => {
        if (!isHovering) {
            forwards();
        }
    }, speed)

}