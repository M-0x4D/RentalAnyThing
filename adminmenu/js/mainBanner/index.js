async function createBanner(event) {
  event.preventDefault();
  const createBanner = document.getElementById("create-main-banner");
  const formInputs = createBanner.querySelectorAll("[name]");
  sendBanRequest(formInputs, "/create-banar");
}

function updateBanner(event) {
  event.preventDefault();
  const updateBanner = document.getElementById("update-banner");
  const formInputs = updateBanner.querySelectorAll("[name]");
  sendBanRequest(formInputs, "/update-banar");
}

const bannerEditModal = document.getElementById("bannerEditModalButton");
const closeBannerUpdate = document.getElementById("close-banner-icon");

const bannerMessage = document.getElementById("banner-message");
const openBannerButton = document.getElementById("open-banner-button");

const closeBannerIcon = document.getElementById("close-message-banner-icon");
const closeBannerButton = document.getElementById("close-banner-button");

let bannerId;
let reloadFlag = false;

function handleBannerImage(id) {
  bannerEditModal.click();
  bannerId = id;
}

async function sendBanRequest(elements, url) {
  let formValues = [];

  const requestData = new FormData();
  requestData.set("io", "rental");

  if (url === "/update-banar") {
    requestData.set("id", bannerId);
  }

  for (const input of elements) {
    if (!!input.value) {
      if (input.name === "banner") {
        requestData.set(input.name, input.files[0]);
      } else {
        requestData.set(input.name, input.value);
      }
      formValues.push(input);

      if (formValues.length === elements.length) {
        try {
          const data = await fiber.post(url, requestData);

          if (data.status === 404) {
            bannerMessage.textContent = data.errors;
            closeBannerUpdate.click();
            openBannerButton.click();
          } else {
            if (url === "/update-banar") {
              bannerMessage.textContent =
                objLang === "English"
                  ? "banner update successful"
                  : "Banner-Aktualisierung erfolgreich";
            } else {
              bannerMessage.textContent =
                objLang === "English"
                  ? "banner add successful"
                  : "banner hinzufügen erfolgreich";
            }
            closeBannerUpdate.click();
            openBannerButton.click();
          }

          reloadFlag = false;
        } catch (error) {
          bannerMessage.textContent =
            objLang === "English"
              ? "there is an problem try again later"
              : "es gibt ein Problem Versuchen Sie es später noch einmal";
          closeBannerUpdate.click();
          openBannerButton.click();

          reloadFlag = true;
        }
      }
    }
  }
}

closeBannerIcon.addEventListener("click", () => {
  location.reload();
});
closeBannerButton.addEventListener("click", () => {
  location.reload();
});

async function deleteBannerImage(id) {
  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  requestData.set("id", id);

  try {
    const data = await fiber.post("/destroy-banner", requestData);
    bannerMessage.textContent =
      objLang === "English"
        ? "Banner delete successfully"
        : "Banner erfolgreich gelöscht";
    openBannerButton.click();
  } catch (error) {
    bannerMessage.textContent =
      objLang === "English"
        ? "there is an problem try again later"
        : "es gibt ein Problem Versuchen Sie es später noch einmal";
    openBannerButton.click();
  }
}
