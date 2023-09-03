function updatePrescription(id, approved) {
    if (!approved) {
        window.location = `./prescription.php?action=reject&id=${id}`;
    } else {
        let priceStr = prompt("Enter price for prescription");
        let price = Number.parseInt(priceStr);
        if (price < 0 || isNaN(price)) {
            alert("Invalid price");
            return;
        }
        window.location = `./prescription.php?action=accept&id=${id}&price=${price}`;
    }
}