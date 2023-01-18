// start filters

// start some variables
let noResaultsForRent = document.querySelector(".no-resaults-for-rent");
let titleAndResultsContainer = document.querySelector(".messaga-and-car-boxes");

// for price filter with all filters
let filterParmetarsWithSort = {};
let filterFlag = false;
// end some variables

// start price order filter
let expensiveFilter = document.getElementById("expensive-price-filter");
let cheapFilter = document.getElementById("cheap-price-filter");
let priceFilterUrlForFetch = `/arrange-objects`;

cheapFilter?.addEventListener("click", async () => {
  if (filterFlag === false) {
    const data = new FormData();
    data.set("io", "rental");
    data.set("jtl_token", fetchToken);
    data.set("filter", "DESC");

    allObjectsData.forEach((obj, index) => {
      data.set(`obj[${index}]`, obj.id);
    });

    try {
      const response = await fiberForPayment.post(
        `${priceFilterUrlForFetch}`,
        data
      );

      let sendData = response.data;
      makeHtmlElement(sendData, true);
      carPick(response);
    } catch (error) {}
  } else if (filterFlag === true) {
    const data = new FormData();
    data.set("io", "rental");
    data.set("jtl_token", fetchToken);
    // data.set("jtl_token", fetchToken);

    allObjectsData.forEach((obj, index) => {
      data.set(`obj[${index}]`, obj.id);
    });
    data.set("filter", "DESC");

    try {
      const response = await fiberForPayment.post(
        `${priceFilterAndObgUrlForFetch}`,
        data
      );

      let sendData = response.data;
      makeHtmlElement(sendData, true);
      carPick(data);
    } catch (error) {}
  }
});

// end price order filter

// ===============================================================

// start main filter
let mainFilterUrlForFetch = `/filter-by-price`;
let checkboxContainer = document.querySelectorAll(
  ".container-for-checkbox .checkbox-child-container"
);
let fetchOnApply = document.getElementById("fetch-on-apply");
let filterArrayParams = [];
let filterObjectParams = {};

checkboxContainer.forEach((e) => {
  let filterParams = e.querySelectorAll("input[name]");

  filterParams.forEach((e) => {
    e.addEventListener("click", () => {
      if (
        e.parentElement.parentElement.parentElement.querySelector("span")
          .textContent == "Price Range" ||
        e.parentElement.parentElement.parentElement.querySelector("span")
          .textContent == "Preislage"
      ) {
        e.classList.toggle("price-range-selected");

        if (document.querySelectorAll(".price-range-selected").length > 0) {
          let smallArray = [];

          document.querySelectorAll(".price-range-selected").forEach((e) => {
            if (e.value.includes("+")) {
              smallArray.push(
                e.value.replaceAll(" $", "").replaceAll(" +", "").split(" - ")
              );
            } else {
              smallArray.push(...e.value.replaceAll(" $", "").split(" - "));
            }
          });
          let twoValue = [];
          twoValue.push(Math.min(...smallArray));
          twoValue.push(Math.max(...smallArray));
          filterObjectParams["price_per_day"] = twoValue;

          smallArray = [];
          twoValue = [];
        } else {
          delete filterObjectParams["price_per_day"];
        }
      } else {
        filterObjectParams[
          e.parentElement.parentElement.parentElement
            .querySelector("span")
            .getAttribute("data-filter-title")
            .replaceAll(" ", "_")
            .toLowerCase()
        ] = e.value;
      }
    });
  });
});

//  =============
fetchOnApply?.addEventListener("click", async (el) => {
  el.preventDefault();

  if (Object.keys(filterObjectParams).length > 0) {
    filterArrayParams.push(filterObjectParams);
    filterFlag = true;
    filterParmetarsWithSort = filterObjectParams;

    const data = new FormData();
    data.set("io", "rental");
    data.set("jtl_token", fetchToken);

    if (!!filterObjectParams["duration"]) {
      data.set(
        "duration",
        filterObjectParams["duration"] === "day"
          ? 1
          : filterObjectParams["duration"] === "week"
          ? 7
          : filterObjectParams["duration"] === "month"
          ? 30
          : 60
      );
    }

    if (!!filterObjectParams["price_per_day"]) {
      data.set("price", filterObjectParams["price_per_day"]);
    }

    if (!!searchDataObjLocal["category"]) {
      data.set("category_id", searchDataObjLocal["category"]);
    }

    if (!!searchDataObjLocal["pick-up-country"]) {
      data.set("country_id", searchDataObjLocal["pick-up-country"]);
    }

    if (!!searchDataObjLocal["drop-off-date"]) {
      data.set("drop_off_date", `${searchDataObjLocal["drop-off-date"]}:00:00`);
    }

    if (!!searchDataObjLocal["pick-up-date"]) {
      data.set("pick_up_date", `${searchDataObjLocal["pick-up-date"]}:00:00`);
    }

    if (!!searchDataObjLocal["pick-up-gouvernement"]) {
      data.set("governorate_id", searchDataObjLocal["pick-up-gouvernement"]);
    }

    if (!!searchDataObjLocal["pick-up-city"]) {
      data.set("city_id", searchDataObjLocal["pick-up-city"]);
    }

    try {
      const response = await fiberForPayment.post(
        `${mainFilterUrlForFetch}`,
        data
      );

      let sendData = response.data;

      allObjectsData = response.data;

      filterArrayParams = [];

      if (response.status === 200 && response.data.length > 0) {
        makeHtmlElement(sendData, true);
        carPick(response);
      } else if (response.status === 200 && response.data.length === 0) {
        titleAndResultsContainer.classList.add("none");
        noResaultsForRent.classList.add("active");
      }
    } catch (error) {}
  }
});

let resetRentFilters = document.getElementById("reset-rent-filters");

resetRentFilters?.addEventListener("click", async () => {
  const data = new FormData();
  data.set("io", "rental");
  data.set("jtl_token", fetchToken);

  try {
    const response = await fiberForPayment.post(`${allDealsUrlForFetch}`, data);

    resultsContainer.classList.add("active");
    let getData = response.data;
    makeHtmlElement(getData, true);
    carPick(response);
  } catch (error) {}

  filterObjectParams = {};

  document.querySelectorAll(".price-range-selected").forEach((e) => {
    e.classList.remove("price-range-selected");
  });

  filterFlag = false;
});

// ===============================================================

// start work in table and list view
let tableView = document.getElementById("table-view");
let listView = document.getElementById("list-view");
let resultsContainerView = document.getElementById("results-container");

if (!!tableView) {
  tableView?.addEventListener("click", () => {
    listView.classList.remove("active");
    tableView.classList.add("active");
    resultsContainerView.classList.add("table-view");
  });
}

if (!!listView) {
  listView?.addEventListener("click", () => {
    tableView.classList.remove("active");
    listView.classList.add("active");
    resultsContainerView.classList.remove("table-view");
  });
}
// end work in table and list view

// end filters
