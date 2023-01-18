<script language="JavaScript" type="text/javascript">
    const openColorButton = document.getElementById('open-color-button')
    const closeColorIcon = document.getElementById('close-color-icon')
    const closeColorButton = document.getElementById('close-color-button')
    const colorMessage = document.getElementById('color-message')
    const closeEditColor = document.getElementById('close-edit-color')

    closeColorButton.addEventListener('click', () => {
        location.reload();
    })

    closeColorIcon.addEventListener('click', () => {
        location.reload();
    })

    function handleColor(id, NameEN, NameDE) {
        document.getElementById("coloreditmodal").click();
        document.getElementById("colorId").value = id;
        document.getElementById("color-en").value = NameEN;
        document.getElementById("color-de").value = NameDE;
    }

    async function createColor(event) {
        event.preventDefault()
        const createColor = document.getElementById('create-color')
        const formInputs = createColor.querySelectorAll('[name]')
        sendColRequest(formInputs, '/create-color')
    }

    function updateColor(event) {
        event.preventDefault()
        const updateColor = document.getElementById('update-color')
        const formInputs = updateColor.querySelectorAll('[name]')
        sendColRequest(formInputs, '/update-color')
    }

    async function sendColRequest(elements, url) {
        let formvalues = []

        const requestData = new FormData();
        requestData.set("io", "rental");
        requestData.set("jtl_token", token);
        for (const input of elements) {
            if (!!input.value) {
                requestData.set(input.name, input.value);
                formvalues.push(input)

                if (formvalues.length === elements.length) {
                    try {
                        const data = await fiber.post(url, requestData);
                        if (data.status === 206) {
                            colorMessage.textContent = data.data
                            closeEditColor.click()
                            openColorButton.click()
                        } else if (data.status === 201) {
                            colorMessage.textContent = data.data
                            openColorButton.click()
                        } else if (data.status === 404) {
                            closeEditColor.click()
                            colorMessage.textContent =
                                objLang === "English" ?
                                "this color is exists" :
                                "diese Farbe ist vorhanden";
                            openColorButton.click();
                        }
                    } catch {
                        colorMessage.textContent =
                            objLang === "English" ?
                            "there is an problem try again later" :
                            "es gibt ein Problem Versuchen Sie es später noch einmal";
                        openColorButton.click();
                    }
                }
            }
        }
    }

    async function deleteColor(event, id) {
        event.preventDefault()
        const requestData = new FormData();
        requestData.set("io", "rental");
        requestData.set("jtl_token", token);
        requestData.set("id", id);
        const data = await fiber.post('/destroy-color', requestData);

        if (data.status === 204) {
            colorMessage.textContent = 'Color delete successfully'
            openColorButton.click()
        } else {
            colorMessage.textContent =
                objLang === "English" ?
                "there is an problem try again later" :
                "es gibt ein Problem Versuchen Sie es später noch einmal";
            openColorButton.click();
        }
    }
</script>