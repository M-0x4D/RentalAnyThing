let priceFilterAndObgUrlForFetch = `/arrange-objects`;

expensiveFilter?.addEventListener("click", async () => {
  if (filterFlag === false) {
    const data = new FormData();
    data.set("io", "rental");
    data.set("jtl_token", fetchToken);
    data.set("filter", "ASC");

    allObjectsData.forEach((obj, index) => {
      data.set(`obj[${index}]`, obj.id);
    });

    try {
      const response = await fiberForPayment.post(
        `${priceFilterUrlForFetch}`,
        data
      );

      if (response.status === 200) {
        let sendData = response.data;
        makeHtmlElement(sendData, true);
        carPick(response);
      }
    } catch (error) {}
  } else if (filterFlag === true) {
    const data = new FormData();
    data.set("io", "rental");
    data.set("jtl_token", fetchToken);
    data.set("filter", "ASC");

    allObjectsData.forEach((obj, index) => {
      data.set(`obj[${index}]`, obj.id);
    });

    try {
      const response = await fiberForPayment.post(
        `${priceFilterAndObgUrlForFetch}`,
        data
      );

      if (response.status === 200) {
        let sendData = response.data;
        makeHtmlElement(sendData, true);
        carPick(response);
      }
    } catch (error) {}
  }
});
