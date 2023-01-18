// start helper functions

// in case of fetch
function insideFetch(data) {
  // start validation
  if (data.status === 200 && data.data.length == 0) {
    resultsContainer.classList.remove("active");
    noResultsMessage.classList.add("active");
    errorFoundMessage.classList.remove("active");

    noResultsMessage.scrollIntoView(false);
  } else if (data.status === 200 && data.data.length > 0) {
    resultsContainer.classList.add("active");
    noResultsMessage.classList.remove("active");
    errorFoundMessage.classList.remove("active");

    resultsContainer.scrollIntoView(false);

    makeHtmlElement(data.data, true);
  } else {
    resultsContainer.classList.remove("active");
    noResultsMessage.classList.remove("active");
    errorFoundMessage.classList.add("active");

    errorFoundMessage.scrollIntoView(false);
  }
}

// =====================

let selectedLang = document
  .querySelector(".language-dropdown .dropdown-menu a.active")
  .getAttribute("data-iso");

// start make html element
function makeHtmlElement(data, flag) {
  if (flag === true) {
    titleAndResultsContainer.classList.remove("none");
    noResaultsForRent.classList.remove("active");
  }

  let resultsContainerBox = document.getElementById("results-container");
  resultsContainerBox.innerHTML = "";

  for (let num = 0; num < data.length; num++) {
    // start parent
    let boxContainer = document.createElement("div");
    boxContainer.setAttribute("class", "result-box d-flex");

    // ======
    let imgContainer = document.createElement("div");
    imgContainer.setAttribute("class", "img-box");

    let img = document.createElement("img");
    img.setAttribute("src", data[num].imagePath);
    img.setAttribute("alt", "car-image");

    imgContainer.appendChild(img);
    boxContainer.appendChild(imgContainer);
    // ======

    // ======
    let carDetailsContainer = document.createElement("div");
    carDetailsContainer.setAttribute("class", "car-details d-flex");
    // ===
    let mainDetailsContainer = document.createElement("div");
    mainDetailsContainer.setAttribute(
      "class",
      "main-details d-flex flex-column justify-content-around"
    );
    let oneUp = document.createElement("div");
    oneUp.setAttribute("class", "one-up d-flex flex-column");

    if (flag === true) {
      let a = document.createElement("a");
      a.setAttribute(
        "href",
        `${
          selectedLang === "eng" ? "product-details" : "produkt-details"
        }?redirect=pick-object&objectId=${data[num].id}`
      );
      a.setAttribute("class", "car-details-link");
      a.setAttribute("id", data[num].id);
      a.textContent = `${
        selectedLang === "eng" ? data[num].name.en : data[num].name.de
      }`;
      oneUp.appendChild(a);
      mainDetailsContainer.appendChild(oneUp);
    } else if (flag === false) {
      let a = document.createElement("p");
      a.setAttribute("id", data[num].id);
      a.textContent = `${
        selectedLang === "eng" ? data[num].name.en : data[num].name.de
      }`;
      oneUp.appendChild(a);
      mainDetailsContainer.appendChild(oneUp);
    }

    let iconParent = document.createElement("div");
    let category = document.createElement("i");
    category.setAttribute("class", "fa fa-bars");
    let categoryText =
      selectedLang === "eng"
        ? " " + data[num].categoryName.en + " - "
        : " " + data[num].categoryName.de + " - ";

    iconParent.appendChild(category);

    iconParent.append(categoryText);

    let location = document.createElement("i");
    location.setAttribute("class", "fa fa-map");

    let locationText =
      selectedLang === "eng"
        ? ` ${data[num].countryName.en} - ${data[num].governrateName.en} - ${data[num].cityName.en}`
        : ` ${data[num].countryName.de} - ${data[num].governrateName.de} - ${data[num].cityName.de}`;

    iconParent.appendChild(location);
    iconParent.append(locationText);

    mainDetailsContainer.appendChild(iconParent);

    let shortDescriptionParent = document.createElement("div");
    let description = document.createElement("p");
    description.textContent =
      selectedLang === "eng"
        ? "Description: " + data[num].short_description.en
        : "Beschreibung: " + data[num].short_description.de;
    shortDescriptionParent.appendChild(description);
    mainDetailsContainer.appendChild(shortDescriptionParent);

    let quantityParent = document.createElement("div");
    let quantity = document.createElement("p");
    quantity.textContent =
      selectedLang === "eng"
        ? "Quantity: " + data[num].quantity
        : "Menge: " + data[num].quantity;
    quantityParent.appendChild(quantity);
    mainDetailsContainer.appendChild(quantityParent);

    if (flag === true) {
      let colorParent = document.createElement("div");
      let color = document.createElement("p");
      color.textContent =
        selectedLang === "eng"
          ? "Color: " + data[num]?.colorName.en
          : "Farbe: " + data[num]?.colorName.de;
      colorParent.appendChild(color);
      mainDetailsContainer.appendChild(colorParent);

      let priceInSmallScreen = document.createElement("div");
      priceInSmallScreen.setAttribute("class", "d-flex rant-price-up-on-small");
      priceInSmallScreen.innerHTML =
        selectedLang === "eng"
          ? `Price: <span class="rant-price">${data[num].price} ${data[num].currency.currency_code}</span>`
          : `Preis: <span class="rant-price">${data[num].price} ${data[num].currency.currency_code}</span>`;

      mainDetailsContainer.appendChild(priceInSmallScreen);

      carDetailsContainer.appendChild(mainDetailsContainer);
    } else if (flag === false) {
      let colorParent = document.createElement("div");
      let color = document.createElement("p");
      color.textContent =
        selectedLang === "eng"
          ? `color: ${data[num].colorName.en}`
          : `Farbe: ${data[num].colorName.de}`;
      colorParent.appendChild(color);
      mainDetailsContainer.appendChild(colorParent);

      let priceInSmallScreen = document.createElement("div");
      priceInSmallScreen.setAttribute("class", "d-flex rant-price-up-on-small");

      priceInSmallScreen.innerHTML = `${
        selectedLang === "eng" ? "pick up date:" : "Datum der Abholung:"
      } ${data[num].pickup_date}
      <br>
      ${selectedLang === "eng" ? "drop off date:" : "Abgabetermin:"} ${
        data[num].dropoff_date
      }
      <br>
      ${selectedLang === "eng" ? "duration:" : "Dauer:"}: ${
        data[num].duration
      } days`;

      priceInSmallScreen.innerHTML = `${
        selectedLang === "eng" ? "pick up date:" : "Datum der Abholung:"
      } ${data[num].pickup_date}
      <br>
      ${selectedLang === "eng" ? "drop off date:" : "Abgabetermin:"} ${
        data[num].dropoff_date
      }
      <br>
      ${selectedLang === "eng" ? "duration price:" : "Laufzeit Preis:"} ${
        +data[num].duration === 1
          ? selectedLang === "eng"
            ? "per day"
            : "per tag"
          : +data[num].duration === 7
          ? selectedLang === "eng"
            ? "per week"
            : "per woche"
          : +data[num].duration === 30
          ? selectedLang === "eng"
            ? "per month"
            : "per monat"
          : selectedLang === "eng"
          ? "per hour"
          : "pro Stunde"
      } days`;

      mainDetailsContainer.appendChild(priceInSmallScreen);

      carDetailsContainer.appendChild(mainDetailsContainer);
    }
    // ===
    if (flag === true) {
      let bookPriceContainer = document.createElement("div");
      bookPriceContainer.setAttribute(
        "class",
        "book-price d-flex flex-column align-items-center justify-content-around"
      );

      let priceDiv = document.createElement("div");
      priceDiv.setAttribute("class", "d-flex flex-column rant-price-up");
      priceDiv.innerHTML = selectedLang === "eng" ? "Price" : "Preis";

      let span = document.createElement("span");
      span.setAttribute("class", "rant-price");
      span.innerHTML = `${data[num].price} ${data[num].currency.currency_code}
      / ${
        +data[num].duration === 1
          ? selectedLang === "eng"
            ? "day"
            : "tag"
          : +data[num].duration === 7
          ? selectedLang === "eng"
            ? "week"
            : "woche"
          : +data[num].duration === 30
          ? selectedLang === "eng"
            ? "month"
            : "monat"
          : selectedLang === "eng"
          ? "hour"
          : "Stunde"
      }`;
      priceDiv.appendChild(span);

      bookPriceContainer.appendChild(priceDiv);
      // ==

      let button = document.createElement("button");
      button.setAttribute("class", "car-rent-on-click");
      button.setAttribute("id", data[num].id);
      button.textContent =
        selectedLang === "eng" ? "pick now" : "Jetzt auswählen";

      bookPriceContainer.appendChild(button);
      carDetailsContainer.appendChild(bookPriceContainer);
      boxContainer.appendChild(carDetailsContainer);
    } else if (flag === false) {
      let bookPriceContainer = document.createElement("div");
      bookPriceContainer.setAttribute(
        "class",
        "book-price d-flex flex-column align-items-center justify-content-around"
      );

      let priceDiv = document.createElement("div");
      priceDiv.setAttribute("class", "d-flex flex-column rant-price-up");
      priceDiv.innerHTML =
        selectedLang === "eng" ? "Total Cost:" : "Gesamtkosten:";

      let span = document.createElement("span");
      span.setAttribute("class", "rant-price");
      span.innerHTML = `${data[num].price} ${data[num].currency.currency_code}`;
      priceDiv.appendChild(span);

      bookPriceContainer.appendChild(priceDiv);
      // ==

      if (data[num].rental_status === "Pending") {
        let statusP = document.createElement("p");
        // statusP.setAttribute("class", "statusP");
        statusP.setAttribute(
          "style",
          "margin-bottom: 0; font-size: 18px; font-weight: bold;"
        );
        statusP.textContent = `${data[num].rental_status}`;
        bookPriceContainer.appendChild(statusP);

        let a = document.createElement("a");
        a.setAttribute("class", "car-rent-on-click");
        a.setAttribute("href", data[num].paymentUrl);
        a.setAttribute(
          "style",
          "text-align: center; text-decoration: none; font-size: 12px; margin: 0; width: 130px;"
        );
        a.textContent =
          selectedLang === "eng" ? "complete payment" : "vollständige Zahlung";
        bookPriceContainer.appendChild(a);
      } else {
        let statusP = document.createElement("p");
        statusP.setAttribute("class", "statusP");
        statusP.setAttribute(
          "style",
          "margin-bottom: 0; font-size: 18px; font-weight: bold;"
        );
        statusP.textContent = `${data[num].rental_status}`;
        bookPriceContainer.appendChild(statusP);
      }

      carDetailsContainer.appendChild(bookPriceContainer);
      boxContainer.appendChild(carDetailsContainer);
    }
    // ======
    // append to main up
    resultsContainerBox.appendChild(boxContainer);
  }

  document.getElementById("container-for-search-results").scrollIntoView(true);

  carLinkValidation();
}

// ==================

// start close pop-up
function closePopUpScreen() {
  closePopUpScreenButton.addEventListener("click", () => {
    popUpContainer.classList.remove("active");
  });

  closeRentalPopup.addEventListener("click", () => {
    popUpContainer.classList.remove("active");
  });
}
// end close pop-up

// ============================

// start sit default popup
// function defaultPopupElement() {
//   popUpContainer.classList.remove("active");

//   let y = dayRentalPrice.split(" ")[1];
//   let x = +dayRentalPrice.split("EUR")[0] + +priceFeatures;

//   document.getElementById(
//     "pop-up-content-child"
//   ).innerHTML = `<img src="/mediafiles/Resources/Photos/exclamation-mark.svg" class="pop-up-icon" id="pop-up-icon">

//                   <div class="button-up-up">
//                       <p class="pop-up-message" id="error-message-v2">

//                       ${
//                         selectedLang === "eng"
//                           ? "<span>are yo sure you want to book this car</span><span>rental price is: <span id='rent-price-car'>" +
//                             x +
//                             y +
//                             "</span></span>"
//                           : "<span>Sind Sie Sicher, Dass Sie Den Service Buchen Möchten?  </span><span> Der Mietpreis beträgt: <span id='rent-price-car'>" +
//                             x +
//                             y +
//                             "</span></span>"
//                       }

//                       </p>

//                       <div>
//                           <button class="pop-up-button active" id="confirm-pop-up-screen" style="background-color: #25c6da;">${
//                             selectedLang === "eng" ? "confirm" : "Bestätigen"
//                           }</button>
//                           <button class="pop-up-button" id="close-pop-up-screen">${
//                             selectedLang === "eng" ? "close" : "Schließen"
//                           }</button>
//                       </div>
//                   </div>`;
// }
// end sit default popup
// end helper functions
