if (location.pathname === "/Cart" || location.pathname === "/Warenkorb") {
  // const removeSessionProduct = document.querySelectorAll(
  //   ".basket-items .session-remove-product"
  // );

  const removeSessionProduct = document.querySelectorAll(
    ".session-remove-product"
  );

  removeSessionProduct.forEach((button) => {
    button.addEventListener("click", async (event) => {
      // event.preventDefault();
      const data = new FormData();
      data.set("io", "rental");
      data.set("jtl_token", document.querySelector(".jtl_token").value);
      data.set("id", button.getAttribute("data-id"));
      data.set("quantity", button.getAttribute("data-quantity"));

      try {
        const response = await fiberForPayment.post("/remove-product", data);
      } catch (error) {}
    });
  });

  // const cashOnDeliver = document.querySelectorAll(
  //   ".basket-items .cash-on-deliver-button"
  // );

  const cashOnDeliver = document.querySelectorAll(".cash-on-deliver-button");

  cashOnDeliver.forEach((button) => {
    button.addEventListener("click", async (event) => {
      event.preventDefault();
      const data = new FormData();
      data.set("io", "rental");
      data.set("jtl_token", document.querySelector(".jtl_token").value);
      data.set("id", button.getAttribute("data-id"));

      try {
        const response = await fiberForPayment.post("/cash-on-deliver", data);

        if (
          +response.status === 302 &&
          changeLang.getAttribute("data-iso") === "ger"
        ) {
          location.href = `meine-vermietungen`;
        } else if (
          +response.status === 302 &&
          changeLang.getAttribute("data-iso") === "eng"
        ) {
          location.href = `my-rentals`;
        }
      } catch (error) {}
    });
  });
}
