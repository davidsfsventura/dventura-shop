function filter() {
    allHidden = false;
    const bodyCheckboxes = document.getElementsByClassName("bodyFilter");
    const clothesCheckboxes = document.getElementsByClassName("clothesFilter");
    const minPrice = document.getElementById("price-min").value;
    const maxPrice = document.getElementById("price-max").value;
    const searchInput = document
        .querySelector(".searchInput")
        .value.toUpperCase(); // Added

    const clothesTypeFilter = Array.from(clothesCheckboxes)
        .filter((checkbox) => checkbox.checked)
        .map((checkbox) => checkbox.id);

    const bodyTypeFilter = Array.from(bodyCheckboxes)
        .filter((checkbox) => checkbox.checked)
        .map((checkbox) => checkbox.id);

    filterClothes(
        bodyTypeFilter,
        clothesTypeFilter,
        minPrice,
        maxPrice,
        searchInput
    ); // Updated
}

function filterClothes(
    bodyTypeFilter,
    clothesTypeFilter,
    minPrice,
    maxPrice,
    searchInput
) {
    // Updated
    const clothesItems = document.querySelectorAll(".cardContainer");
    let allHidden = true;
    clothesItems.forEach((item) => {
        const itemBodyType = item.getAttribute("data-body_type");
        const itemType = item.getAttribute("data-type");
        const itemPrice = parseFloat(item.dataset["price"]);
        const itemName = item.querySelector("h2").textContent.toUpperCase(); // Added
        const itemDescription = item
            .querySelector("p")
            .textContent.toUpperCase(); // Added

        const bodyTypeMatch =
            bodyTypeFilter.length === 0 ||
            bodyTypeFilter.includes(itemBodyType);
        const typeMatch =
            clothesTypeFilter.length === 0 ||
            clothesTypeFilter.includes(itemType);
        const priceMatch = itemPrice >= minPrice && itemPrice <= maxPrice;
        const searchMatch =
            itemName.includes(searchInput) ||
            itemDescription.includes(searchInput); // Added

        if (bodyTypeMatch && typeMatch && priceMatch && searchMatch) {
            // Updated
            item.style.display = "inline-block";
            allHidden = false;
        } else {
            item.style.display = "none";
        }
    });

    if (allHidden) {
        document.getElementById("noAvailable").style.display = "block";
    } else {
        document.getElementById("noAvailable").style.display = "none";
    }
}

function showSideMenu() {
    const sidemenu = document.getElementById("sidemenu");
    const isHidden = window.getComputedStyle(sidemenu).visibility === "hidden";

    if (isHidden) {
        sidemenu.classList.add("openMenu");
        sidemenu.classList.remove("closeMenu");
        sidemenu.classList.remove("animate__backOutLeft");
        sidemenu.classList.add("animate__backInLeft");
        sidemenu.addEventListener("animationend", () => {
            sidemenu.classList.remove("closeMenu");
            sidemenu.classList.add("openMenu");
        });
    } else {
        sidemenu.classList.remove("animate__backInLeft");
        sidemenu.classList.add("animate__backOutLeft");
        sidemenu.addEventListener("animationend", () => {
            sidemenu.classList.add("closeMenu");
            sidemenu.classList.remove("openMenu");
        });
    }
}

function Card(SVGID, mainDivID, cardName) {
    const card = document.getElementById(SVGID);

    if (!TimerForCard.includes(card)) {
        TimerForCard.push(card);

        $(card).addClass("load");
        var mainDiv = document.getElementById(mainDivID);
        if (mainDiv) {
            addToCart(mainDivID, cardName);
        }

        setTimeout(() => {
            $(card).addClass("done");
        }, 1000);

        setTimeout(() => {
            $(card).removeClass("load done");

            const index = TimerForCard.indexOf(card);
            if (index > -1) {
                TimerForCard.splice(index, 1);
            }
        }, 3500);
    }
}

function addToCart(mainDivId, cardName) {
    card = document.getElementById(mainDivId);
    $.ajax({
        url: "shop/add_to_cart",
        type: "post",
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            prodID: mainDivId,
            quantity: 1,
            prodName: card.getAttribute("data-name"),
            prodDescription: card.getAttribute("data-description"),
            prodPrice: card.getAttribute("data-price"),
            prodImgSrc: card.getElementsByTagName("img")[0].getAttribute("src"),
        },
        success: function (response) {
            $("#cart-quantity").text(response.quantity);
            cardIMG = document
                .getElementById(mainDivId)
                .getElementsByTagName("img")[0]
                .getAttribute("src");

            const parentAlertsDiv = document.getElementById("alerts");
            const newAlert = document.createElement("div");
            newAlert.classList.add("alert");
            newAlert.id = `alert-${mainDivId}`;
            newAlert.innerHTML = `
        <span class="closebtn" onclick="closeAlert(event.target.parentElement.id);">&times;</span>
        <img src="${cardIMG}"/><p style="display:inline; margin-left:1rem;margin-top:1rem !important"> Added <strong>${cardName}</strong> to cart.</p>
    `;
            parentAlertsDiv.appendChild(newAlert);

            setTimeout(() => {
                closeAlert(newAlert.id);
            }, 4000);
        },
    });
}

function closeAlert(element) {
    document.getElementById(element).remove();
}
