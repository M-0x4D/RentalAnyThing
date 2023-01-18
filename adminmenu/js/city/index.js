const openCityButton = document.getElementById("open-city-button");
const closeCityIcon = document.getElementById("close-city-icon");
const closeCityButton = document.getElementById("close-city-button");
const cityMessage = document.getElementById("city-message");
const closeEditCity = document.getElementById("close-edit-city");
let cityFlag = true;

closeCityButton.addEventListener("click", () => {
  if (cityFlag) {
    location.reload();
  }
});
closeCityIcon.addEventListener("click", () => {
  if (cityFlag) {
    location.reload();
  }
});

let selectCountries = document.getElementById("select-countries-for-city");
let selectGovernratesForCityParent = document.getElementById(
  "select-governrates-for-city-parent"
);
let governratesForCitySelect = document.getElementById(
  "select-governrates-for-city"
);

let cityNameEn = document.getElementById("city-name-en");
let cityNameDe = document.getElementById("city-name-de");

selectCountries.addEventListener("change", async () => {
  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  requestData.set("id", selectCountries.value);

  let lang = document
    .querySelector(".backend-main ul.nav li.nav-item a.nav-link.parent")
    .textContent.trim();

  try {
    governratesForCitySelect.innerHTML = "";
    const data = await fiber.post("/governrates", requestData);

    let defaultOption = document.createElement("option");
    defaultOption.setAttribute("value", "");
    defaultOption.setAttribute("selected", "selected");
    defaultOption.setAttribute("disabled", "disabled");

    if (data.data.length > 0) {
      defaultOption.textContent =
        lang === "English"
          ? "Choose Governorate"
          : "Wählen Sie ein Gouvernement";
    } else {
      defaultOption.textContent =
        lang === "English"
          ? "Choose there is no governorate"
          : "es gibt kein Gouvernement";
    }

    governratesForCitySelect.appendChild(defaultOption);

    for (const governorate of data.data) {
      let option = document.createElement("option");
      option.setAttribute("value", governorate.id);
      option.textContent =
        lang === "English"
          ? governorate.governrateName.en
          : governorate.governrateName.de;
      governratesForCitySelect.appendChild(option);
    }

    selectGovernratesForCityParent.style.display = "flex";

    governratesForCitySelect.addEventListener("change", () => {
      cityNameEn.style.display = "flex";
      cityNameDe.style.display = "flex";
    });
  } catch (error) {
    cityMessage.textContent =
      lang === "English"
        ? "there is an problem try again later"
        : "es gibt ein Problem Versuchen Sie es später noch einmal";
    openCityButton.click();
  }
});

let updateSelectGovernratesParent = document.getElementById(
  "update-select-governrates-for-city-parent"
);
let updateSelectGovernratesForCity = document.getElementById(
  "update-select-governrates-for-city"
);

let updateCityNameEn = document.getElementById("update_city_name_en");
let updateCityNameDe = document.getElementById("update_city_name_de");

let updateCityElement = document.getElementById(
  "update-select-countries-for-city"
);

// updateCityElement.addEventListener("change", async () => {
//   const requestData = new FormData();
//   requestData.set("io", "rental");
//   requestData.set("jtl_token", token);
//   requestData.set("id", updateCityElement.value);

//   let lang = document
//     .querySelector(".backend-main ul.nav li.nav-item a.nav-link.parent")
//     .textContent.trim();

//   try {
//     updateSelectGovernratesForCity.innerHTML = "";

//     const data = await fiber.post("/governrates", requestData);

//     let defaultOption = document.createElement("option");
//     defaultOption.setAttribute("value", "");
//     defaultOption.setAttribute("selected", "selected");
//     defaultOption.setAttribute("disabled", "disabled");
//     defaultOption.textContent = "Choose Governorate";
//     updateSelectGovernratesForCity.appendChild(defaultOption);

//     for (const governorate of data.data) {
//       let option = document.createElement("option");
//       option.setAttribute("value", governorate.id);
//       option.textContent =
//         lang === "English"
//           ? governorate.governrateName.en
//           : governorate.governrateName.de;
//       updateSelectGovernratesForCity.appendChild(option);
//     }

//     updateSelectGovernratesParent.style.display = "flex";

//     updateSelectGovernratesForCity.addEventListener("change", () => {
//       updateCityNameEn.style.display = "flex";
//       updateCityNameDe.style.display = "flex";
//     });
//   } catch (error) {
//     cityMessage.textContent =
//       lang === "English"
//         ? "there is an problem try again later"
//         : "es gibt ein Problem Versuchen Sie es später noch einmal";
//     openCityButton.click();
//   }
// });

async function handleCity(id, NameEN, NameDE, country_id, governrate_id) {
  updateCityElement.value = country_id;

  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  requestData.set("id", country_id);

  let lang = document
    .querySelector(".backend-main ul.nav li.nav-item a.nav-link.parent")
    .textContent.trim();

  try {
    updateSelectGovernratesForCity.innerHTML = "";

    const data = await fiber.post("/governrates", requestData);

    let defaultOption = document.createElement("option");
    defaultOption.setAttribute("value", "");
    defaultOption.setAttribute("selected", "selected");
    defaultOption.setAttribute("disabled", "disabled");
    defaultOption.textContent = "Choose Governorate";
    updateSelectGovernratesForCity.appendChild(defaultOption);

    for (const governorate of data.data) {
      let option = document.createElement("option");
      option.setAttribute("value", governorate.id);
      option.textContent =
        lang === "English"
          ? governorate.governrateName.en
          : governorate.governrateName.de;
      updateSelectGovernratesForCity.appendChild(option);
    }

    updateSelectGovernratesForCity.value = governrate_id;
  } catch (error) {
    cityMessage.textContent =
      lang === "English"
        ? "there is an problem try again later"
        : "es gibt ein Problem Versuchen Sie es später noch einmal";
    openCityButton.click();
  }

  document.getElementById("cityId").value = id;
  document.getElementById("city-en").value = NameEN;
  document.getElementById("city-de").value = NameDE;
  document.getElementById("cityeditmodal").click();
}

async function createCity(event) {
  event.preventDefault();
  const createCity = document.getElementById("create-city");
  const formInputs = createCity.querySelectorAll("[name]");
  sendCitRequest(formInputs, "/create-city");
}

function updateCityFun() {
  event.preventDefault();
  const updateCityForm = document.getElementById("update-city");
  const formInputs = updateCityForm.querySelectorAll("[name]");
  sendCitRequest(formInputs, "/update-city");
}

async function sendCitRequest(elements, url) {
  let formvalues = [];

  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  for (const input of elements) {
    if (!!input.value) {
      requestData.set(input.name, input.value);
      formvalues.push(input);

      if (formvalues.length === elements.length) {
        try {
          const data = await fiber.post(url, requestData);

          if (data.status === 404) {
            closeEditCity.click();
            cityMessage.textContent =
              objLang === "English"
                ? "this city is exists"
                : "diese Stadt existiert";
            openCityButton.click();
          } else {
            cityMessage.textContent = data.data;
            closeEditCity.click();
            openCityButton.click();
          }
        } catch (error) {
          cityMessage.textContent =
            objLang === "English"
              ? "there is an problem try again later"
              : "es gibt ein Problem Versuchen Sie es später noch einmal";
          openCityButton.click();
        }
      }
    }
  }
}

function deleteCity(id) {
  event.preventDefault();
  cityFlag = false;
  openCityButton.click();

  const deleteCityButton = document.getElementById("delete-city-button");
  deleteCityButton.style.display = "initial";
  deleteCityButton.addEventListener("click", () => {
    sendDeleteCityRequest(id, deleteCityButton);
  });
}

async function sendDeleteCityRequest(id, button) {
  cityFlag = true;
  button.style.display = "none";

  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  requestData.set("id", id);

  try {
    const data = await fiber.post("/destroy-city", requestData);
    cityMessage.textContent =
      objLang === "English"
        ? "City delete successfully"
        : "Stadt erfolgreich löschen";
    openCityButton.click();
  } catch (error) {
    cityMessage.textContent =
      objLang === "English"
        ? "there is an problem try again later"
        : "es gibt ein Problem Versuchen Sie es später noch einmal";
    openCityButton.click();
  }
}
