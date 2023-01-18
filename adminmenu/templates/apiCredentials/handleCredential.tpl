<script language="JavaScript" type="text/javascript">
    const openCredentialsButton = document.getElementById('open-credentials-button')
    const closeCredentialsIcon = document.getElementById('close-credentials-icon')
    const closeCredentialsButton = document.getElementById('close-credentials-button')
    const credentialsMessage = document.getElementById('credentials-message')
    const closeEditCredentials = document.getElementById('close-edit-credentials')
    let flag = true

    closeCredentialsButton.addEventListener('click', () => {
        if (flag) {
            location.reload();
        }
    })

    closeCredentialsIcon.addEventListener('click', () => {
        if (flag) {
            location.reload();
        }
    })

    function handleCredential(credential) {
        document.getElementById("credentialmodeledit").click();
        document.getElementById("businessAccount").value = credential.business_account;
        document.getElementById("clientId").value = credential.client_id;
        document.getElementById("secretKey").value = credential.secret_key;
        document.getElementById("credentialId").value = credential.id;
    }

    async function createCredentials(event) {
        event.preventDefault()
        const createCredential = document.getElementById('add-credential')
        const formInputs = createCredential.querySelectorAll('[name]')
        sendRequest(formInputs, '/create-api-credentials')
    }

    function updateCredentials(event) {
        event.preventDefault()
        const updateCredentials = document.getElementById('update-credentials')
        const formInputs = updateCredentials.querySelectorAll('[name]')
        sendRequest(formInputs, '/update-api-credentials')
    }

    async function sendRequest(elements, url) {
        let formvalues = []

        const requestData = new FormData();
        requestData.set("io", "rental");
        requestData.set("jtl_token", token);
        for (const input of elements) {
            if (!!input.value) {
                requestData.set(input.name, input.value.trim());

                if (url === '/create-api-credentials') {
                    requestData.set('mode', document.querySelector('.paypal-mode:checked').value);
                }
                formvalues.push(input)

                if (formvalues.length === elements.length) {
                    try {
                        const data = await fiber.post(url, requestData);
                        credentialsMessage.textContent = data.data || data.errors.message
                        closeEditCredentials.click()
                        openCredentialsButton.click()
                        flag = true
                    } catch (error) {
                        credentialsMessage.textContent = error.data.message
                        openCredentialsButton.click()
                        flag = true
                    }
                }
            }
        }
    }

    let getActiveLang = document.querySelector(
            '.backend-main .backend-navbar ul.nav li.nav-item.dropdown a.nav-link.dropdown-toggle.parent.btn-toggle span'
        )
        .textContent

    async function sendMode(value) {
        const requestData = new FormData();
        requestData.set("io", "rental");
        requestData.set("jtl_token", token);
        requestData.set('mode', value);
        const data = await fiber.post('/paypal-mode', requestData);

        console.log(data.data[0])

        if (Object.keys(data.data[0]).length > 0) {
            handleCredential(data.data[0]);
        }
    }

    async function deleteCredentials(event, id) {
        event.preventDefault()
        const requestData = new FormData();
        requestData.set("io", "rental");
        requestData.set("jtl_token", token);
        requestData.set("id", id);

        try {
            const data = await fiber.post('/destroy-api-credentials', requestData);

            credentialsMessage.textContent = 'Credentials delete successfully'
            openCredentialsButton.click()
        } catch (error) {
            credentialsMessage.textContent = 'error while deleting data'
            openCredentialsButton.click()
        }
    }
</script>