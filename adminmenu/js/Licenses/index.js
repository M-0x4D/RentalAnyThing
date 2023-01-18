


window.addEventListener("load", () => {
  const homeBtn = document.querySelector(".home"),
    form = document.querySelector(".tecSee-licenses-container"),
    overLay = document.querySelector(".tecSee-overlay-licenses");
  if (homeBtn !== null) {
    homeBtn.addEventListener("click", (event) => {
      event.preventDefault();
      const baseUrl = `${location.protocol}//${location.hostname}/admin`;
      location.href = baseUrl;
    });
  }
  if (form !== null) {
    form.addEventListener("submit", async (event) => {
      event.preventDefault();

      const baseUrl = `${location.protocol}//${location.host}`;
      const fiber = new Fiber(baseUrl);
      const token = document.querySelector(".jtl_token").value;

      let selectedLang =
        document.querySelector(".fa-language").nextSibling.nextSibling
          .innerHTML;
      selectedLang = selectedLang === "English" ? "en" : "de";
      fiber.set_headers({
        "Content-lang": selectedLang,
        Accept: "application/json",
        "Jtl-Token": token,
      });
      const data = new FormData();
      data.set("io", "rental");
      data.set("jtl_token", token);

      for (index = 0; index < form.elements.length; index++) {
        if (form.elements[index].type !== "submit") {
          if (!!form.elements[index].value.trim() !== false) {
            data.set(form.elements[index].name, form.elements[index].value);
            form.elements[index].classList.remove("tecSee-invalid");
            form.elements[index].value = "";
          } else {
            form.elements[index].classList.add("tecSee-invalid");
          }
        }
      }

      const response = await fiber.post("/admin/io.php/licensekey", data);
      if (response.status === 201) {
        overLay.classList.add("hidden");
      }
      if (response.status === 422) {
        form.children[0].children[1].innerHTML = `<h1>${response.errors.message}</h1>`;
      }
    });
  }
});
