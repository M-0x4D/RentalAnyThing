// start work in rent car
// start car variables
let dumData = {};
// end car variables

// checkFlag === 6 ||

// start work in car pick
function carPick() {
  let customerIdNumber = document
    .getElementById("results-container")
    .getAttribute("data-customerId");

  let rentCarButton = document.querySelectorAll(".car-rent-on-click");

  let searchInputArray = 0;

  searchParameters.forEach((e) => {
    if (e.value != "") {
      searchInputArray += 1;
    }
  });

  rentCarButton.forEach((e, i) => {
    e.addEventListener("click", async () => {
      if (
        customerIdNumber !== "no-login" &&
        (searchInputArray === 6 || searchInputArray === 4)
      ) {
        dumData.cDumData = e.getAttribute("id") + "#dum";
        dumData.cuDumData = customerIdNumber + "#dum";

        localStorage.setItem("dumData", JSON.stringify(dumData));
        localStorage.setItem("searchData", JSON.stringify(searchDataObj));

        location.href = `${
          location.href.includes("/vermietung")
            ? "/produkt-details"
            : "/product-details"
        }?redirect=pick-object&objectId=${dumData.cDumData.split("#")[0]}`;

        searchInputArray = 0;
      } else if (searchInputArray < 4) {
        event.preventDefault();
        pOnPopUp.innerHTML = location.href.includes("rental")
          ? `<span>these search is only for guiding</span> <br>
        <span>Please full all input filed</span>`
          : `<span>diese Suche dient nur der Orientierung</span> <br>
        <span>Bitte alle Eingaben vollständig ausfüllen</span>`;
        popUpContainer.classList.add("active");
        closePopUpScreen();
      } else {
        pOnPopUp.textContent = location.href.includes("rental")
          ? "please login first to be able to book"
          : "Bitte loggen Sie sich erst ein, um buchen zu können";

        popUpContainer.classList.add("active");
        closePopUpScreen();
      }
    });
  });
}
// end work in car pick
// end work in rent car

// ===================================================

// start work in car link
function carLinkValidation() {
  let carDetailsLink = document.querySelectorAll(".car-details-link");

  let searchInputArray = 0;

  searchParameters.forEach((e) => {
    if (e.value != "") {
      searchInputArray += 1;
    }
  });

  carDetailsLink.forEach((e) => {
    e.addEventListener("click", (event) => {
      let customerIdNumber = document
        .getElementById("results-container")
        .getAttribute("data-customerId");

      let carIdForLink = e.getAttribute("id");

      if (
        customerIdNumber !== "no-login" &&
        (searchInputArray === 6 || searchInputArray === 4)
      ) {
        carPickObject.carId = carIdForLink;
        carPickObject.customerId = customerIdNumber;

        localStorage.setItem("dumData", JSON.stringify(dumData));
        localStorage.setItem("searchData", JSON.stringify(searchDataObj));

        location.href = `${
          location.href.includes("/rental")
            ? "/product-details"
            : "/produkt-details"
        }?redirect=pick-object&objectId=${dumData.cDumData.split("#")[0]}`;

        searchInputArray = 0;
      } else if (searchInputArray < 4) {
        event.preventDefault();
        pOnPopUp.innerHTML = location.href.includes("rental")
          ? `<span>these search is only for guiding</span> <br>
        <span>Please full all input filed</span>`
          : `<span>diese Suche dient nur der Orientierung</span> <br>
        <span>Bitte alle Eingaben vollständig ausfüllen</span>`;
        popUpContainer.classList.add("active");
        closePopUpScreen();
      } else {
        event.preventDefault();
        pOnPopUp.textContent = location.href.includes("rental")
          ? "please login first to be able be to book"
          : "Bitte loggen Sie sich erst ein, um buchen zu können";
        popUpContainer.classList.add("active");
        closePopUpScreen();
      }
    });

    e.addEventListener("contextmenu", (event) => {
      let customerIdNumber = document
        .getElementById("results-container")
        .getAttribute("data-customerId");

      let carIdForLink = e.getAttribute("id");

      if (
        customerIdNumber !== "no-login" &&
        (searchInputArray === 6 || searchInputArray === 4)
      ) {
        carPickObject.carId = carIdForLink;
        carPickObject.customerId = customerIdNumber;

        localStorage.setItem("dumData", JSON.stringify(dumData));
        localStorage.setItem("searchData", JSON.stringify(searchDataObj));

        location.href = `${
          location.href.includes("/rental")
            ? "/product-details"
            : "/produkt-details"
        }?redirect=pick-object&objectId=${dumData.cDumData.split("#")[0]}`;

        searchInputArray = 0;
      } else if (searchInputArray < 4) {
        event.preventDefault();
        pOnPopUp.innerHTML = location.href.includes("rental")
          ? `<span>these search is only for guiding</span> <br>
        <span>Please full all input filed</span>`
          : `<span>diese Suche dient nur der Orientierung</span> <br>
        <span>Bitte alle Eingaben vollständig ausfüllen</span>`;
        popUpContainer.classList.add("active");
        closePopUpScreen();
      } else {
        event.preventDefault();
        pOnPopUp.textContent = location.href.includes("rental")
          ? "Please login first to be able be to book"
          : "Bitte loggen Sie sich erst ein, um buchen zu können";
        popUpContainer.classList.add("active");
        closePopUpScreen();
      }
    });
  });
}

// end work in car link

// ================================ start change lang
if (
  location.href.includes("/produkt-details") ||
  location.href.includes("/product-details")
) {
  let search = location.search;

  let changeLangButton = document.querySelectorAll(
    "#shop-nav li.language-dropdown div.dropdown-menu a"
  );

  changeLangButton.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();

      if (button.getAttribute("data-iso") === "ger") {
        location.href = `produkt-details${search}`;
      } else if (button.getAttribute("data-iso") === "eng") {
        location.href = `product-details${search}`;
      }
    });
  });
}

let changeLang = document.querySelector(
  "#shop-nav li.language-dropdown div.dropdown-menu a.active"
);

if (
  document.referrer === "" &&
  (location.href.includes("/produkt-details") ||
    location.href.includes("/product-details"))
) {
  if (changeLang.getAttribute("data-iso") === "ger") {
    location.href = `vermietung`;
  } else if (changeLang.getAttribute("data-iso") === "eng") {
    location.href = `rental`;
  }
}
// ================================ start change lang
