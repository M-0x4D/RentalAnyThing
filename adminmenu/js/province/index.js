const openProvinceButton = document.getElementById("open-province-button");
const closeProvinceIcon = document.getElementById("close-province-icon");
const closeProvinceButton = document.getElementById("close-province-button");
const provinceMessage = document.getElementById("province-message");
const closeEditProvince = document.getElementById("close-edit-province");
let provFlag = true;

closeProvinceButton.addEventListener("click", () => {
  if (provFlag) {
    location.reload();
  }
});

closeProvinceIcon.addEventListener("click", () => {
  if (provFlag) {
    location.reload();
  }
});

function handleProvince(id, nameEN, nameDE, countryId) {
  document.getElementById("provinceeditmodal").click();
  document.getElementById("provinceId").value = id;
  document.getElementById("province-en").value = nameEN;
  document.getElementById("province-de").value = nameDE;
  document.getElementById("select-countries-for-province-update").value =
    countryId;
}

async function createProvince(event) {
  event.preventDefault();
  const createProvince = document.getElementById("create-province");
  const formInputs = createProvince.querySelectorAll("[name]");
  sendLocRequest(formInputs, "/create-governrate");
}

function updateProvince(event) {
  event.preventDefault();
  const updateProvince = document.getElementById("update-province");
  const formInputs = updateProvince.querySelectorAll("[name]");
  sendLocRequest(formInputs, "/update-governrate");
}

async function sendLocRequest(elements, url) {
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
            provinceMessage.textContent =
              objLang === "English"
                ? "this governorate is exists"
                : "dieses Gouvernement existiert";
            openProvinceButton.click();
          } else {
            provinceMessage.textContent = data.data;
            closeEditProvince.click();
            openProvinceButton.click();
          }
        } catch (error) {
          provinceMessage.textContent =
            objLang === "English"
              ? "there is an problem try again later"
              : "es gibt ein Problem Versuchen Sie es später noch einmal";
          openProvinceButton.click();
        }
      }
    }
  }
}

function deleteProvince(event, id) {
  event.preventDefault();
  provFlag = false;
  openProvinceButton.click();

  const deleteProvinceButton = document.getElementById(
    "delete-province-button"
  );
  deleteProvinceButton.style.display = "initial";
  deleteProvinceButton.addEventListener("click", () => {
    sendDeleteProvinceRequest(id, deleteProvinceButton);
  });
}

async function sendDeleteProvinceRequest(id, button) {
  provFlag = true;
  button.style.display = "none";

  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  requestData.set("id", id);

  try {
    const data = await fiber.post("/destroy-governrate", requestData);
    provinceMessage.textContent =
      objLang === "English"
        ? "Province delete successfully"
        : "Provinz erfolgreich löschen";
    openProvinceButton.click();
  } catch (error) {
    provinceMessage.textContent =
      objLang === "English"
        ? "there is an problem try again later"
        : "es gibt ein Problem Versuchen Sie es später noch einmal";
    openProvinceButton.click();
  }
}
