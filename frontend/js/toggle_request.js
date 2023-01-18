// start work in global variable
// start jtl token
let fetchToken = document.querySelector(".jtl_token").value;

// ==================================== new request using fiber js
const paymentBaseUrl = `${location.protocol}//${location.host}/io.php`;
const fiberForPayment = new Fiber(paymentBaseUrl);
fiberForPayment.set_headers({
  "Content-lang": "en",
  Accept: "application/json",
  "Jtl-Token": fetchToken,
});
