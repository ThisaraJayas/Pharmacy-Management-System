async function addToCartProduct(type, product_id, amount) {
    const reqData = new FormData();
    reqData.set("type", type);
    reqData.set("id", product_id);
    reqData.set("amount", amount);

    let itemAmount = 0;
    try {
        const resp = await fetch("./cartadd.php", { method: "post", body: reqData });
        const respData = await resp.json();

        if (!respData.success) {

            if (resp.status === 401) {
                window.location = "./login.php?redirect=" + window.location.pathname + "?" + window.location.search;
                return false;
            }

            console.error(respData.error);
            alert("Failed to Add Item to cart");
            return false;
        }

        itemAmount = respData.cart_items;
    } catch (e) {
        console.error(e);
        alert("Failed to Add Item to cart");
        return false;
    }


    let shoppingCartAmount = document.querySelectorAll(".menu-item.shopping-cart .item-amount");
    shoppingCartAmount.forEach((e) => {
        if (itemAmount > 0) {
            e.innerText = itemAmount;
            e.classList.remove("hidden");
        } else {
            e.classList.add("hidden");
        }
    });

    return true;
}


function initProductView(id) {
    const itemView = document.querySelector(".mainview");
    const addButton = itemView.querySelector(".addcartbutton");
    const amountInput = itemView.querySelector(".itemnum");

    addButton.addEventListener("click", () => {
        const amount = Number.parseInt(amountInput.value, 10);
        if (amount < 0 || amount > 1000 || isNaN(amount)) {
            alert("Invalid amount entered");
            return;
        }

        addButton.disabled = true;
        addToCartProduct("product", id, amount).then((success) => {
            addButton.disabled = false;
            if (success) {
                alert("Added Item to Cart");
            }
        })

    });
}

function addPrescriptionToCart(id) {
    addToCartProduct("prescription", id, 1).then((success) => {
        if (success) {
            alert("Added Prescription to Cart");
        }
    });
}