const openCountryButton = document.getElementById("open-country-button");
const closeCountryIcon = document.getElementById("close-country-icon");
const closeCountryButton = document.getElementById("close-country-button");
const countryMessage = document.getElementById("country-message");
const closeEditCountry = document.getElementById("close-edit-country");
let couFlag = true;

closeCountryButton.addEventListener("click", () => {
  if (couFlag) {
    location.reload();
  }
});

closeCountryIcon.addEventListener("click", () => {
  if (couFlag) {
    location.reload();
  }
});

function handleCountry(id, NameEN, NameDE) {
  document.getElementById("countryeditmodal").click();
  document.getElementById("countryId").value = id;
  document.getElementById("country-en").value = NameEN;
  document.getElementById("country-de").value = NameDE;
}

async function createCountry(event) {
  event.preventDefault();
  const createCountry = document.getElementById("create-country");
  const formInputs = createCountry.querySelectorAll("[name]");
  sendCouRequest(formInputs, "/create-country");
}

function updateCountry(event) {
  event.preventDefault();
  const updateCountry = document.getElementById("update-country");
  const formInputs = updateCountry.querySelectorAll("[name]");
  sendCouRequest(formInputs, "/update-country");
}

async function sendCouRequest(elements, url) {
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
          if (data.status !== 404) {
            countryMessage.textContent = data.data;
            closeEditCountry.click();
            openCountryButton.click();
          } else if (data.status === 404) {
            closeEditCountry.click();
            countryMessage.textContent =
              objLang === "English"
                ? "this country is exists"
                : "dieses Land existiert";
            openCountryButton.click();
          }
        } catch (error) {
          countryMessage.textContent =
            objLang === "English"
              ? "there is an problem try again later"
              : "es gibt ein Problem Versuchen Sie es später noch einmal";
          openCountryButton.click();
        }
      }
    }
  }
}

function deleteCountry(event, id) {
  event.preventDefault();
  couFlag = false;
  openCountryButton.click();

  const deleteCountryButton = document.getElementById("delete-country-button");
  deleteCountryButton.style.display = "initial";
  deleteCountryButton.addEventListener("click", () => {
    sendDeleteCountryRequest(id, deleteCountryButton);
  });
}

async function sendDeleteCountryRequest(id, button) {
  couFlag = true;
  button.style.display = "none";

  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  requestData.set("id", id);

  try {
    const data = await fiber.post("/destroy-country", requestData);
    countryMessage.textContent =
      objLang === "English"
        ? "Country delete successfully"
        : "Land erfolgreich löschen";
    openCountryButton.click();
  } catch (error) {
    countryMessage.textContent =
      objLang === "English"
        ? "there is an problem try again later"
        : "es gibt ein Problem Versuchen Sie es später noch einmal";
    openCountryButton.click();
  }
}
