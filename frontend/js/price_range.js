// start define pop-up
let errorMessagePopUpContainer = document.getElementById(
  "error-message-pop-up-container"
);
let errorMessagePopUpContent = document.getElementById(
  "error-message-pop-up-content"
);
let closeErrorMessagePopUpIcon = document.getElementById(
  "error-message-pop-up-icon"
);
let closeErrorMessagePopUpButton = document.getElementById(
  "error-message-pop-up-button"
);
let popUpErrorMessage = document.getElementById("error-message-message");

closeErrorMessagePopUpIcon?.addEventListener("click", () => {
  errorMessagePopUpContainer.classList.remove("active");
  errorMessagePopUpContent.classList.remove("active");
});

closeErrorMessagePopUpButton?.addEventListener("click", () => {
  errorMessagePopUpContainer.classList.remove("active");
  errorMessagePopUpContent.classList.remove("active");
});

// end define pop-up

let rentDurationDay;

// start work in price
let popUpContentChildContent;
let carObjDataSmarty = {};

let currency = document
  .getElementById("reservation-total")
  ?.getAttribute("data-cur");

let duration = document
  .getElementById("reservation-total")
  ?.getAttribute("data-dur");

let obgLocationId = document
  .getElementById("reservation-total")
  ?.getAttribute("data-loc");

let currencyName = document
  .getElementById("reservation-total")
  ?.getAttribute("data-nam");

let totalPrice;
let totalQuantity = 1;
let startDateValue;
let endDateValue;
let oldData;

if (
  location.href.includes("product-details") ||
  location.href.includes("produkt-details")
) {
  window.onload = () => {
    // ====================================================================================== new
    let startDateInput = document.getElementById("obj_pickup_date");
    let endDateInput = document.getElementById("obj_dropoff_date");
    oldData = JSON.parse(localStorage.getItem("searchData"));

    startDateValue = oldData["pick-up-date"];
    endDateValue = oldData["drop-off-date"];

    if (!!startDateInput) {
      startDateInput.value = oldData["pick-up-date"];
    }

    if (!!endDateInput) {
      endDateInput.value = oldData["drop-off-date"];
    }

    let rentToDate = document.querySelectorAll(".rent-to-date");
    let rentFromDate = document.getElementById("rent-from-date");

    if (!!rentFromDate) {
      rentFromDate.textContent = `${startDateInput.value}:00:00`;
    }

    if (!!rentToDate) {
      rentToDate.forEach((e) => {
        e.textContent = `${endDateInput.value}:00:00`;
      });
    }

    calcPrice(oldData["pick-up-date"], oldData["drop-off-date"], totalQuantity);

    let changeLang = document.querySelector(
      "#shop-nav li.language-dropdown div.dropdown-menu a.active"
    );

    $(document)
      .ready(function () {
        $("#obj_pickup_date").datetimepicker({
          language: location.href.includes("/rental") ? "en" : "de",
          dateFormat: "d-m-yy",
          timeFormat: "HH",
          minDate: new Date(),
          pickSeconds: true,
          pick12HourFormat: false,
        });
      })
      .on("change", function () {
        rentFromDate.textContent = startDateInput.value;

        carObjDataSmarty["pick-up-date"] = startDateInput.value;
        startDateValue = startDateInput.value;
        endDateValue = endDateInput.value;
        calcPrice(startDateInput.value, endDateInput.value, totalQuantity);
      });

    $(document)
      .ready(function () {
        $("#obj_dropoff_date").datetimepicker({
          language: location.href.includes("/rental") ? "en" : "de",
          dateFormat: "d-m-yy",
          timeFormat: "HH",
          minDate: new Date(),
          pickSeconds: true,
          pick12HourFormat: false,
        });
      })
      .on("change", function () {
        carObjDataSmarty["drop-off-date"] = endDateInput.value;

        rentToDate.forEach((e) => {
          e.textContent = endDateInput.value;
        });
        startDateValue = startDateInput.value;
        endDateValue = endDateInput.value;
        calcPrice(startDateInput.value, endDateInput.value, totalQuantity);
      });

    // ===================================================================

    let rentExtraItems = document.querySelectorAll(".extra-items");

    rentExtraItems.forEach((e, i, arr) => {
      if (e.value == 0) {
        extraCombonentRentPrice.forEach((e) => {
          e.querySelector("span.care").textContent =
            changeLang.getAttribute("data-iso") === "ger"
              ? "Keine zusätzlichen Elemente"
              : "No extra items";
        });
      }

      e.addEventListener("click", () => {
        // defaultPopupElement();

        let t = 0;
        let m = 0;

        for (let num = 0; num < arr.length; num++) {
          extra +=
            +document.querySelectorAll(".extra-items")[num].value *
            +document
              .querySelectorAll(".extra-items")
              [num].getAttribute("data-need");

          t +=
            +document.querySelectorAll(".extra-items")[num].value *
            +document
              .querySelectorAll(".extra-items")
              [num].getAttribute("data-need");

          m++;

          if (m === arr.length) {
            m = 0;
            priceFeatures = t;
          }
        }

        extraCombonentRentPrice.forEach((e) => {
          e.querySelector("span.amou").innerHTML = t;
        });

        extraCombonentRentPrice.forEach((e) => {
          e.querySelector("span.care").textContent = "EUR";
        });
      });
    });

    let resetExtraItem = document.getElementById("reset-all-extra-item");

    resetExtraItem?.addEventListener("click", () => {
      totalQuantity = 1;
      document.getElementById("rental-product-quantity").value = 1;
      calcPrice(startDateValue, endDateValue, totalQuantity);

      dayRentalPrice = null;
    });
  };
}

function calcPrice(startTime, endTime, quantity) {
  const productData = document?.getElementById("calc-product-price");
  const duration = +productData?.getAttribute("data-dur");
  const currency = productData?.getAttribute("data-nam");
  const allPrice = +productData?.getAttribute("data-pri");
  let price = 0;
  let numberOfIterable = 0;

  const end = new Date(
    `${endTime.split(" ")[0].split("-").reverse().join("/")} ${
      endTime.split(" ")[1]
    }:00:00`
  );

  const start = new Date(
    `${startTime.split(" ")[0].split("-").reverse().join("/")} ${
      startTime.split(" ")[1]
    }:00:00`
  );

  const numberOfHours = (end - start) / (1000 * 60 * 60);

  if (duration === 1) {
    price = allPrice / 24;
    numberOfIterable = +((end - start) / (1000 * 60 * 60 * 24)).toFixed(3);
  } else if (duration === 7) {
    price = allPrice / 168;
    numberOfIterable = +((end - start) / (1000 * 60 * 60 * 24 * 7)).toFixed(3);
  } else if (duration === 30) {
    price = allPrice / 720;
    numberOfIterable = +((end - start) / (1000 * 60 * 60 * 24 * 30)).toFixed(3);
  } else if (duration === 60) {
    price = allPrice;
    numberOfIterable = +((end - start) / (1000 * 60 * 60)).toFixed(3);
  }

  totalPrice = +numberOfHours * +price * +quantity;

  let firstPrice = document.getElementById("reservation-total");
  if (!!firstPrice) {
    firstPrice.textContent = `${totalPrice.toFixed(3)} ${currency}`;
  }
  let allRentPrice = document.querySelector(".all-total-rent-price");
  if (!!allRentPrice) {
    allRentPrice.textContent = `${totalPrice.toFixed(3)} ${currency}`;
  }

  // ========================= price details
  let rentTd = document.getElementById("all-days-descriptions");

  if (!!rentTd) {
    rentTd.innerHTML = "";
  }

  if (numberOfIterable > 0) {
    for (let i = 0; i < numberOfIterable; i++) {
      let tr = document.createElement("tr");
      let td1 = document.createElement("td");

      if (+duration === 60) {
        let time = new Date(start.getTime() + i * 60 * 60 * 1000)
          .toString()
          .split(" ");
        td1.textContent = `${time[0]} ${time[1]} ${time[2]} ${time[3]} ${time[4]}`;
      } else if (+duration === 1 || +duration === 7 || +duration === 30) {
        if (
          !Number.isInteger(numberOfIterable) &&
          +Math.ceil(numberOfIterable) === +i + 1
        ) {
          td1.textContent =
            changeLang.getAttribute("data-iso") === "ger"
              ? "Verbleibende Stunden"
              : "Remaining Hours";
        } else {
          let time = new Date(start.getTime() + i * 60 * 60 * 1000 * 24)
            .toString()
            .split(" ");
          td1.textContent = `${time[0]} ${time[1]} ${time[2]} ${time[3]} ${time[4]}`;
        }
      }

      tr.appendChild(td1);

      let td2 = document.createElement("td");
      let remainingHours = 1;
      if (
        !Number.isInteger(numberOfIterable) &&
        +Math.ceil(numberOfIterable) === +i + 1
      ) {
        remainingHours = +(numberOfIterable % 1).toFixed(3);
      }
      if (duration === 1) {
        td2.textContent = `${(price * 24 * quantity * remainingHours).toFixed(
          3
        )} ${currency}`;
      } else if (duration === 7) {
        td2.textContent = `${(price * 168 * quantity * remainingHours).toFixed(
          3
        )} ${currency}`;
      } else if (duration === 30) {
        td2.textContent = `${(price * 720 * quantity * remainingHours).toFixed(
          3
        )} ${currency}`;
      } else if (duration === 60) {
        td2.textContent = `${(price * quantity * remainingHours).toFixed(
          3
        )} ${currency}`;
      }

      tr.appendChild(td2);
      rentTd.appendChild(tr);
    }
  } else {
    popUpErrorMessage.textContent = `${
      changeLang.getAttribute("data-iso") === "ger"
        ? "Bitte wählen Sie ein Abgabedatum größer als das Abholdatum"
        : "Please choose drop of date greater than pick up date"
    }`;
    errorMessagePopUpContainer.classList.add("active");
    errorMessagePopUpContent.classList.add("active");

    calcPrice(oldData["pick-up-date"], oldData["drop-off-date"], totalQuantity);

    let startDateInput = document.getElementById("obj_pickup_date");
    let endDateInput = document.getElementById("obj_dropoff_date");

    if (!!startDateInput) {
      startDateInput.value = oldData["pick-up-date"];
    }

    if (!!endDateInput) {
      endDateInput.value = oldData["drop-off-date"];
    }

    dayRentalPrice = null;
  }

  let x = document.createElement("tr");
  x.setAttribute("class", "font-table-price");

  xtd = document.createElement("td");

  xtd.textContent =
    changeLang.getAttribute("data-iso") === "ger"
      ? "Gesamtpreis"
      : "Total price";
  x.appendChild(xtd);

  xtd2 = document.createElement("td");
  xtd2.setAttribute(
    "class",
    "item-combonent-rent-price font-table-price total-rent-price"
  );
  xtd2.innerHTML = `${totalPrice.toFixed(3)} ${currency}`;
  x.appendChild(xtd2);

  rentTd?.appendChild(x);
}
// end work in price

// =====================================================

// start work in rental-proceed button
if (
  location.href.includes("product-details") ||
  location.href.includes("produkt-details")
) {
  let rentalProceed = document.getElementById("rental-proceed");
  let popUpIcon = document.getElementById("pop-up-icon");
  let confirmButton = document.getElementById("confirm-pop-up-screen");
  const productQuantity = document.getElementById("rental-product-quantity");

  rentalProceed?.addEventListener("click", async () => {
    const objectData = JSON.parse(localStorage.getItem("dumData"));
    const searchData = JSON.parse(localStorage.getItem("searchData"));

    let pickDateOldData =
      carObjDataSmarty["pick-up-date"]?.split(" ") ||
      searchData["pick-up-date"].split(" ");

    let dropDateOldData =
      carObjDataSmarty["drop-off-date"]?.split(" ") ||
      searchData["drop-off-date"].split(" ");

    let pickDate = `${pickDateOldData[0].split("-").reverse().join("/")} ${
      pickDateOldData[1]
    }:00:00`;
    let dropDate = `${dropDateOldData[0].split("-").reverse().join("/")} ${
      dropDateOldData[1]
    }:00:00`;

    const data = new FormData();
    data.set("io", "rental");
    data.set("jtl_token", fetchToken);
    data.set("quantity", productQuantity.value);
    data.set("object_id", objectData.cDumData.replace("#dum", ""));
    data.set("pick_up_date", pickDate.replaceAll("/", "-"));
    data.set("pick_of_date", dropDate.replaceAll("/", "-"));

    if (
      new Date(dropDate) >= new Date(pickDate) &&
      +productQuantity.value > 0 &&
      +productQuantity.value <= +productQuantity.getAttribute("max")
    ) {
      try {
        const response = await fiberForPayment.post("/add-to-cart", data);

        if (response.status === 404) {
          popUpErrorMessage.textContent = `${
            changeLang.getAttribute("data-iso") === "ger"
              ? "Es ist ein Fehler aufgetreten, bitte versuchen Sie es später noch einmal"
              : "there is an error please try again later"
          }`;
          errorMessagePopUpContainer.classList.add("active");
          errorMessagePopUpContent.classList.add("active");
        } else {
          if (changeLang.getAttribute("data-iso") === "ger") {
            location.href = `${location.origin}/Warenkorb`;
          } else {
            location.href = `${location.origin}/Cart`;
          }
        }
      } catch (error) {
        popUpErrorMessage.textContent = `${
          changeLang.getAttribute("data-iso") === "ger"
            ? "Es ist ein Fehler aufgetreten, bitte versuchen Sie es später noch einmal"
            : "there is an error please try again later"
        }`;
        errorMessagePopUpContainer.classList.add("active");
        errorMessagePopUpContent.classList.add("active");
      }
    } else if (new Date(dropDate) < new Date(pickDate)) {
      popUpErrorMessage.textContent = `${
        changeLang.getAttribute("data-iso") === "ger"
          ? "Bitte wählen Sie das Rückgabedatum größer als das Startdatum"
          : "Please choose return date bigger than start date"
      }`;
      errorMessagePopUpContainer.classList.add("active");
      errorMessagePopUpContent.classList.add("active");
    } else if (
      +productQuantity.value <= 0 ||
      +productQuantity.value > +productQuantity.getAttribute("max")
    ) {
      popUpErrorMessage.textContent = `${
        changeLang.getAttribute("data-iso") === "ger"
          ? `Bitte wählen Sie eine Menge zwischen 1 und ${productQuantity.getAttribute(
              "max"
            )}`
          : `Please choose quantity between 1 and ${productQuantity.getAttribute(
              "max"
            )}`
      }`;
      errorMessagePopUpContainer.classList.add("active");
      errorMessagePopUpContent.classList.add("active");
    } else {
      popUpErrorMessage.textContent = `${
        changeLang.getAttribute("data-iso") === "ger"
          ? "Bitte wählen Sie zuerst das Datum"
          : "Please choose date first"
      }`;
      errorMessagePopUpContainer.classList.add("active");
      errorMessagePopUpContent.classList.add("active");
    }
  });

  productQuantity.addEventListener("input", () => {
    totalQuantity = productQuantity.value;

    calcPrice(startDateValue, endDateValue, totalQuantity);
  });
}
// end work in rental-proceed button

// ==================================================================
// start work in sort by date in my rentals
if (
  location.href.includes("my-rentals") ||
  location.href.includes("meine-vermietungen")
) {
  let sortRentByDate = document.querySelectorAll(".sort-rent-by-date");

  let rentalUrlFetch = `/filter-rentals-by-date`;

  let customerId = document
    .getElementById("container-for-features-and-search-my-rental")
    .getAttribute("data-u-i");

  let filterTypeData = {};
  filterTypeData.customerId = customerId;

  sortRentByDate.forEach((e) => {
    e.addEventListener("click", async () => {
      let dateAtt = e.getAttribute("date-rent-filter");

      if (dateAtt === "ASC") {
        filterTypeData.filter = "ASC";
      } else if (dateAtt === "DESC") {
        filterTypeData.filter = "DESC";
      }

      const data = new FormData();
      data.set("io", "rental");
      data.set("jtl_token", fetchToken);

      for (const [key, value] of Object.entries(filterTypeData)) {
        data.set(key, value);
      }

      try {
        const response = await fiberForPayment.post(`${rentalUrlFetch}`, data);
        if (response.status === 200) {
          let da = response.data;
          makeHtmlElement(da, false);
        }
      } catch (error) {}
    });
  });
}
// end work in sort by date in my rentals

// ========================= for clear old data
// function removeDataBeforeGo() {
//   localStorage.removeItem("dumData");
// }
if (
  !localStorage.getItem("dumData") &&
  (location.href.includes("product-details") ||
    location.href.includes("produkt-details"))
) {
  if (changeLang.getAttribute("data-iso") === "ger") {
    location.href = `vermietung`;
  } else if (changeLang.getAttribute("data-iso") === "eng") {
    location.href = `rental`;
  }
}
// ========================= for clear old data
