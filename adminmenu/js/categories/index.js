let token = document.querySelector(".jtl_token").value;
let locationProtocol = location.protocol;
let locationHost = location.host;
const defaultBaseUrl = locationProtocol + "//" + locationHost + "/admin/io.php";

let objLang = document
  .querySelector(".backend-main ul.nav li.nav-item a.nav-link.parent")
  .textContent.trim();

const fiber = new Fiber(defaultBaseUrl);
fiber.set_headers({
  "Content-lang": "en",
  Accept: "application/json",
  "Jtl-Token": token,
});

const openCategoryButton = document.getElementById("open-category-button");
const closeCategoryIcon = document.getElementById("close-category-icon");
const closeCategoryButton = document.getElementById("close-category-button");
const categoryMessage = document.getElementById("category-message");
const closeEditCategory = document.getElementById("close-edit-category");

closeCategoryButton.addEventListener("click", () => {
  location.reload();
});

closeCategoryIcon.addEventListener("click", () => {
  location.reload();
});

function handleCategory(id, NameEN, NameDE) {
  document.getElementById("categoryeditmodal").click();
  document.getElementById("categoryId").value = id;
  document.getElementById("category-en").value = NameEN;
  document.getElementById("category-de").value = NameDE;
}

async function createCategory(event) {
  event.preventDefault();
  const createCategory = document.getElementById("create-category");
  const formInputs = createCategory.querySelectorAll("[name]");
  sendCategoryRequest(formInputs, "/create-category");
}

function updateCategory(event) {
  event.preventDefault();
  const updateCategory = document.getElementById("update-category");
  const formInputs = updateCategory.querySelectorAll("[name]");
  sendCategoryRequest(formInputs, "/update-category");
}

async function sendCategoryRequest(elements, url) {
  let formvalues = [];

  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  for (const input of elements) {
    if (!!input.value) {
      requestData.set(input.name, input.value);
      formvalues.push(input);

      if (formvalues.length === elements.length) {
        const data = await fiber.post(url, requestData);

        try {
          if (data.status === 206) {
            categoryMessage.textContent = data.data;
            closeEditCategory.click();
            openCategoryButton.click();
          } else if (data.status === 201) {
            categoryMessage.textContent = data.data;
            openCategoryButton.click();
          } else if (data.status === 404) {
            closeEditCategory.click();
            categoryMessage.textContent =
              objLang === "English"
                ? "this category is exists"
                : "diese Kategorie ist vorhanden";
            openCategoryButton.click();
          }
        } catch (error) {
          closeEditCategory.click();
          categoryMessage.textContent =
            objLang === "English"
              ? "there is an problem try again later"
              : "es gibt ein Problem Versuchen Sie es später noch einmal";
          openCategoryButton.click();
        }
      }
    }
  }
}

async function deleteCategory(event, id) {
  event.preventDefault();
  const requestData = new FormData();
  requestData.set("io", "rental");
  requestData.set("jtl_token", token);
  requestData.set("id", id);

  try {
    const data = await fiber.post("/destroy-category", requestData);

    categoryMessage.textContent =
      objLang === "English"
        ? "category delete successfully"
        : "Kategorie erfolgreich gelöscht";
    openCategoryButton.click();
  } catch (error) {
    categoryMessage.textContent =
      objLang === "English"
        ? "there is an problem try again later"
        : "es gibt ein Problem Versuchen Sie es später noch einmal";
    openCategoryButton.click();
  }
}
