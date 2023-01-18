const openCurrencyButton = document.getElementById("open-currency-button");
const closeCurrencyIcon = document.getElementById("close-currency-icon");
const closeCurrencyButton = document.getElementById("close-currency-button");
const currencyMessage = document.getElementById("currency-message");
const closeEditCurrency = document.getElementById("close-edit-currency");
let cureFlag = true;

closeCurrencyButton.addEventListener("click", () => {
  if (cureFlag) {
    location.reload();
  }
});

closeCurrencyIcon.addEventListener("click", () => {
  if (cureFlag) {
    location.reload();
  }
});

function handleCurrency(id, NameEN, currency_code) {
  document.getElementById("currencyeditmodal").click();
  document.getElementById("currencyId").value = id;
  document.getElementById("currency-en").value = NameEN;
  document.getElementById("currency-code").value = currency_code;
}

async function createCurrency(event) {
  event.preventDefault();
  const createCurrency = document.getElementById("create-currency");
  const formInputs = createCurrency.querySelectorAll("[name]");
  sendCurRequest(formInputs, "/create-currency");
}

function updateCurrency(event) {
  event.preventDefault();
  const updateCurrency = document.getElementById("update-currency");
  const formInputs = updateCurrency.querySelectorAll("[name]");
  sendCurRequest(formInputs, "/update-currency");
}

async function sendCurRequest(elements, url) {
  let formValues = [];

  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  for (const input of elements) {
    if (!!input.value) {
      requestData.set(input.name, input.value);
      formValues.push(input);

      if (formValues.length === elements.length) {
        try {
          const data = await fiber.post(url, requestData);

          if (data.status === 206) {
            currencyMessage.textContent = data.data;
            closeEditCurrency.click();
            openCurrencyButton.click();
          } else if (data.status === 201) {
            closeEditCurrency.click();
            currencyMessage.textContent = data.data;
            openCurrencyButton.click();
          } else if (data.status === 404) {
            closeEditCurrency.click()
            currencyMessage.textContent =
              objLang === "English"
                ? "this currency is exists"
                : "diese Währung existiert";
            openCurrencyButton.click();
          }
        } catch (error) {
          currencyMessage.textContent =
            objLang === "English"
              ? "there is an problem try again later"
              : "es gibt ein Problem Versuchen Sie es später noch einmal";
          openCurrencyButton.click();
        }
      }
    }
  }
}

function deleteCurrency(id) {
  event.preventDefault();
  cureFlag = false;
  openCurrencyButton.click();

  const deleteCurrencyButton = document.getElementById(
    "delete-currency-button"
  );
  deleteCurrencyButton.style.display = "initial";
  deleteCurrencyButton.addEventListener("click", () => {
    sendDeleteCurrencyRequest(id, deleteCurrencyButton);
  });
}

async function sendDeleteCurrencyRequest(id, button) {
  cureFlag = true;
  button.style.display = "none";

  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  requestData.set("currency_id", id);

  try {
    const data = await fiber.post("/destroy-currency", requestData);

    currencyMessage.textContent =
      objLang === "English"
        ? "currency delete successfully"
        : "Währung erfolgreich löschen";
    openCurrencyButton.click();
  } catch (error) {
    currencyMessage.textContent =
      objLang === "English"
        ? "there is an problem try again later"
        : "es gibt ein Problem Versuchen Sie es später noch einmal";
    openCurrencyButton.click();
  }
}
