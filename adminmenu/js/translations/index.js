const openTranslationsButton = document.getElementById(
  "open-translations-button"
);
const closeTranslationsIcon = document.getElementById(
  "close-translations-icon"
);
const closeTranslationsButton = document.getElementById(
  "close-translations-button"
);
const translationsMessage = document.getElementById("translations-message");

const data = new FormData();
data.set("io", "rental");
data.set("jtl_token", token);

let setKeyObject = new FormData();
setKeyObject.set("io", "rental");
setKeyObject.set("jtl_token", token);

const translationForm = document.getElementById("translation-key");
const chooseLanguage = document.getElementById("chooseLanguage");

chooseLanguage.addEventListener("change", async () => {
  if (chooseLanguage.value !== "") {
    removeDomElement("langChild");

    data.set("language", chooseLanguage.value);
    setKeyObject.set("language", chooseLanguage.value);

    try {
      const response = await fiber.post("/translate", data);

      if (response.status === 200) {
        let keys = response.data.translate;

        drawSelect(keys, "drawCategories");
      } else {
        translationsMessage.textContent = response.data.message;
        openTranslationsButton.click();
      }
    } catch (error) {
      translationsMessage.textContent = response.data.message;
      openTranslationsButton.click();
    }
  }
});

function drawSelect(keys, target) {
  let div = document.createElement("div");

  if (target === "drawCategories") {
    div.setAttribute("id", "chooseCategoriesDiv");
  } else if (target === "drawKey") {
    div.setAttribute("id", "chooseKeyDiv");
  }

  let label = document.createElement("label");
  label.textContent =
    target === "drawCategories" ? "Choose Categories" : "Choose Key";
  div.appendChild(label);

  let select = document.createElement("select");
  select.setAttribute(
    "id",
    target === "drawCategories" ? "chooseCategories" : "chooseKey"
  );
  select.setAttribute("name", "key");
  let firstOption = document.createElement("option");
  firstOption.setAttribute("value", "");
  firstOption.setAttribute("selected", "true");
  firstOption.setAttribute("disabled", "true");
  firstOption.textContent =
    target === "drawCategories" ? "choose Categories" : "Choose Key";
  select.appendChild(firstOption);

  for (const key in keys) {
    let option = document.createElement("option");
    option.setAttribute("value", key);
    option.textContent = key;
    select.appendChild(option);
  }

  div.appendChild(select);
  translationForm.appendChild(div);

  if (target === "drawCategories") {
    let chooseCategories = document.getElementById("chooseCategories");
    chooseCategories.addEventListener("change", () => {
      if (chooseCategories.value !== "") {
        removeDomElement("categoriesChild");

        setKeyObject.set("categories", chooseCategories.value);

        drawSelect(keys[chooseCategories.value], "drawKey");
      }
    });
  } else if (target === "drawKey") {
    let chooseKey = document.getElementById("chooseKey");
    chooseKey.addEventListener("change", () => {
      if (chooseKey.value !== "") {
        removeDomElement("keyChild");

        setKeyObject.set("key", chooseKey.value);

        drawInput(keys[chooseKey.value]);
      }
    });
  }
}

function drawInput(value) {
  let div = document.createElement("div");
  div.setAttribute("id", "keyValue");

  let label = document.createElement("label");
  label.textContent = "Set Key Value";
  div.appendChild(label);

  let input = document.createElement("input");
  input.setAttribute("id", "newkeyValue");
  input.setAttribute("value", value);
  input.setAttribute("required", true);
  input.setAttribute("placeholder", "Set Key Value");
  input.setAttribute("type", "text");

  div.appendChild(input);
  translationForm.appendChild(div);

  let submit = document.createElement("input");
  submit.setAttribute("id", "submit");
  submit.setAttribute("type", "submit");
  submit.setAttribute("value", "Set New Value");
  translationForm.appendChild(submit);
}

translationForm.addEventListener("submit", async (event) => {
  event.preventDefault();

  let newkeyValue = document.getElementById("newkeyValue");

  if (newkeyValue.value.length > 0) {
    setKeyObject.set("value", newkeyValue.value);

    try {
      const response = await fiber.post("/set-translation", setKeyObject);

      translationsMessage.textContent = response.data.message;
      openTranslationsButton.click();
    } catch (error) {
      translationsMessage.textContent = response.data.message;
      openTranslationsButton.click();
    }
  }
});

function removeDomElement(child) {
  if (child === "keyChild") {
  } else if (child === "categoriesChild") {
    let chooseKeyDiv = document.getElementById("chooseKeyDiv");
    chooseKeyDiv?.remove();
  } else if (child === "langChild") {
    const chooseCategoriesDiv = document.getElementById("chooseCategoriesDiv");
    chooseCategoriesDiv?.remove();

    let chooseKeyDiv = document.getElementById("chooseKeyDiv");
    chooseKeyDiv?.remove();
  }

  let keyValue = document.getElementById("keyValue");
  keyValue?.remove();

  let submit = document.getElementById("submit");
  submit?.remove();
}
