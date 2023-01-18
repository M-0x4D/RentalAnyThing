// price variable duration
let dayRentalPrice = 0;
let priceFeatures = 0;

// price variable duration

// start description button
const categorizesButton = document.querySelectorAll(
  ".all-details-categorize .cate"
);
const categorizesContainer = document.querySelectorAll(
  ".all-description-boxes .description-box-container"
);

categorizesButton.forEach((e) => {
  e.addEventListener("click", () => {
    document
      .querySelector(".all-details-categorize .cate.active")
      .classList.remove("active");
    document
      .querySelector(".all-description-boxes .description-box-container.active")
      .classList.remove("active");
    e.classList.add("active");

    let categorizesButtonAttribute = e.getAttribute("data-cate-up");

    categorizesContainer.forEach((e) => {
      let categorizesContainerAttribute = e.getAttribute("data-categorize");

      if (categorizesButtonAttribute === categorizesContainerAttribute) {
        e.classList.add("active");
      }
    });
  });
});
// end description button
