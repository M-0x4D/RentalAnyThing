// start include js datepicker from bootstrap-datepicker
$(document).ready(function () {
  $(".input-group.date .date-search").datetimepicker({
    language: location.href.includes("/rental") ? "en" : "de",
    dateFormat: "d-m-yy",
    timeFormat: "HH",
    minDate: new Date(),
    pickSeconds: true,
    pick12HourFormat: false,
  });
});
// end include js datepicker from bootstrap-datepicker

// ==========================================================

// start define pop-up
let popUpContainer = document.getElementById("pop-up-container");
let closePopUpScreenButton = document.getElementById("close-pop-up-screen");
let pOnPopUp = document.getElementById("error-message-v2");
let popUpContentParent = document.querySelector(".pop-up-content-parent");
let popUpContent = document.getElementById("pop-up-content");
let popUpContentChild = document.getElementById("pop-up-content-child");
let closeRentalPopup = document.getElementById("close-rental-car-popup");
// end define pop-up

// start define search components
let sendingSearchParameters = document.getElementById("send-se-par");
let searchParameters = document.querySelectorAll(".send-se-par");
// end define search components

// start work in result components
let containerForSearch = document.getElementById(
  "container-for-search-results"
);
let resultsContainer = document.getElementById(
  "parent-for-container-search-results"
);
let noResultsMessage = document.getElementById("no-results-found-for-rental");
let errorFoundMessage = document.getElementById("error-found-for-rental");
// end work in result components

// start work in url
let searchUrlForFetch = `/search-available-objects`;
// end work in url

// end define some variables
let allObjectsData = [];

const pickUpCountry = document.getElementById("pick-up-country");
const pickUpGovernorate = document.getElementById("pick-up-governorate");
const pickUpCity = document.getElementById("pick-up-city");

if (!!pickUpCountry) {
  pickUpCountry.onchange = async () => {
    const data = new FormData();
    data.set("io", "rental");
    data.set("jtl_token", fetchToken);
    data.set("country_id", pickUpCountry.value);

    try {
      pickUpGovernorate.innerHTML = "";
      pickUpCity.innerHTML = `
        <option value="" selected="selected" disabled="disabled">
          ${
            changeLang.getAttribute("data-iso") === "ger"
              ? "Wählen Sie zuerst Land und Gouvernement"
              : "Choose Country And governorate First"
          }
        </option>
      `;

      const response = await fiberForPayment.post("/return-governrates", data);

      let defaultOption = document.createElement("option");
      defaultOption.setAttribute("value", "");
      defaultOption.setAttribute("selected", "selected");
      defaultOption.setAttribute("disabled", "disabled");
      if (response.data.length > 0) {
        defaultOption.textContent =
          changeLang.getAttribute("data-iso") === "ger"
            ? "Wählen Sie ein Gouvernement"
            : "Choose Governorate";
        pickUpGovernorate.appendChild(defaultOption);

        for (const governorate of response.data) {
          let option = document.createElement("option");
          option.setAttribute("value", governorate.id);
          option.textContent =
            changeLang.getAttribute("data-iso") === "ger"
              ? governorate.name.de
              : governorate.name.en;
          pickUpGovernorate.appendChild(option);
        }

        pickUpGovernorate.onchange = async () => {
          const data = new FormData();
          data.set("io", "rental");
          data.set("jtl_token", fetchToken);
          data.set("country_id", pickUpCountry.value);
          data.set("governorate_id", pickUpGovernorate.value);

          try {
            pickUpCity.innerHTML = "";
            const response = await fiberForPayment.post("/return-cities", data);

            let defaultOption = document.createElement("option");
            defaultOption.setAttribute("value", "");
            defaultOption.setAttribute("selected", "selected");
            defaultOption.setAttribute("disabled", "disabled");

            if (response.data.length > 0) {
              defaultOption.textContent =
                changeLang.getAttribute("data-iso") === "ger"
                  ? "Stadt wählen"
                  : "Choose City";
              pickUpCity.appendChild(defaultOption);

              for (const governorate of response.data) {
                let option = document.createElement("option");
                option.setAttribute("value", governorate.id);
                option.textContent =
                  changeLang.getAttribute("data-iso") === "ger"
                    ? governorate.name.de
                    : governorate.name.en;
                pickUpCity.appendChild(option);
              }
            } else {
              defaultOption.textContent =
                changeLang.getAttribute("data-iso") === "ger"
                  ? "Es gibt keine Stadt Wählen Sie ein anderes Gouvernement"
                  : "There Is No City Choose Another Governorate";
              pickUpCity.appendChild(defaultOption);
            }
          } catch (error) {}
        };
      } else {
        defaultOption.textContent =
          changeLang.getAttribute("data-iso") === "ger"
            ? "Es gibt kein Gouvernement Wählen Sie ein anderes Land"
            : "There Is No Governorate Choose Another Country";
        pickUpGovernorate.appendChild(defaultOption);
      }
    } catch (error) {}
  };
}
// =============================================

// start main function
let checkFlag = 0;
let searchDataArr = [];
let searchDataObj = {};
let searchDataObjLocal = {};

sendingSearchParameters?.addEventListener("click", (event) => {
  event.preventDefault();
  searchParameters.forEach(async (e, i) => {
    let objectKey = e.parentElement.parentElement
      .querySelector("label")
      .getAttribute("for");

    if (e.value != "") {
      if (objectKey.includes("location")) {
        checkFlag = checkFlag + 1;
        searchDataObj[objectKey] = e.value;
        searchDataObjLocal[objectKey] = e.value;
      } else {
        checkFlag = checkFlag + 1;
        searchDataObj[objectKey] = e.value;
        searchDataObjLocal[objectKey] = e.value;
      }

      //   sending request

      if (
        checkFlag === 6 ||
        (checkFlag === 4 &&
          !!searchDataObj["category"] &&
          !!searchDataObj["pick-up-date"] &&
          !!searchDataObj["drop-off-date"] &&
          !!searchDataObj["pick-up-country"])
      ) {
        let dropOff = searchDataObj["drop-off-date"]?.split(" ");
        let pickUp = searchDataObj["pick-up-date"]?.split(" ");

        if (
          new Date(
            `${pickUp[0].split("-")[1]}/${pickUp[0].split("-")[0]}/${
              pickUp[0].split("-")[2]
            } ${pickUp[1]}:00:00`
          ) <
          new Date(
            `${dropOff[0].split("-")[1]}/${dropOff[0].split("-")[0]}/${
              dropOff[0].split("-")[2]
            } ${dropOff[1]}:00:00`
          )
        ) {
          searchDataArr.push(searchDataObj);

          popUpContainer.classList.remove("active");

          let sendPickUpDate = `${pickUp[0].split("-")[2]}-${
            pickUp[0].split("-")[1]
          }-${pickUp[0].split("-")[0]} ${pickUp[1]}`;
          let sendDropOff = `${dropOff[0].split("-")[2]}-${
            dropOff[0].split("-")[1]
          }-${dropOff[0].split("-")[0]} ${dropOff[1]}`;

          const data = new FormData();
          data.set("io", "rental");
          data.set("jtl_token", fetchToken);
          data.set("country_id", searchDataObj["pick-up-country"]);

          if (!!searchDataObj["pick-up-gouvernement"]) {
            data.set("governorate_id", searchDataObj["pick-up-gouvernement"]);
          }

          if (!!searchDataObj["pick-up-city"]) {
            data.set("city_id", searchDataObj["pick-up-city"]);
          }

          if (!!searchDataObj["category"]) {
            data.set("category_id", searchDataObj["category"]);
          }

          data.set("pick_up_date", `${sendPickUpDate}:00:00`);
          data.set("drop_of_date", `${sendDropOff}:00:00`);

          try {
            const response = await fiberForPayment.post(
              `${searchUrlForFetch}`,
              data
            );

            response.data.forEach((obj) => {
              allObjectsData.push(obj);
            });

            if (response.status === 200) {
              // main work
              insideFetch(response);
              carPick(response);
              searchDataArr = [];
              // searchDataObj = {};
            }
          } catch (error) {}
        } else {
          pOnPopUp.textContent = `${
            location.href.includes("/rental")
              ? "please choose drop off date greater than pick up date"
              : "Bitte wählen Sie ein Abgabedatum, das größer ist als das Abholdatum"
          }`;
          resultsContainer.classList.remove("active");
          popUpContainer.classList.add("active");
          closePopUpScreen();
        }
      } else {
        // work in alert
        resultsContainer.classList.remove("active");
        popUpContainer.classList.add("active");
        closePopUpScreen();
      }
    }
  });
  checkFlag = 0;
});
