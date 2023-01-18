let briceBreakdownToggler = document.getElementById("brice-breakdown");
let briceBreakdownParent = document.querySelector(".brice-breakdown");

briceBreakdownToggler?.addEventListener("click", () => {
  briceBreakdownParent.classList.toggle("active");
});
