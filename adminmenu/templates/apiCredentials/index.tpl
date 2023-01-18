{include file="../layout/tecsee_styles.tpl"}

<h2 class="trainer-name">
    {if $smarty.session.AdminAccount->language === 'de-DE'}
        Plugin-Modus
    {else}
        Plugin Mode
    {/if}
</h2>
<hr />

<div class="tecSee-padding">
    <input form="add-credential" class="paypal-mode" required type="radio" id="PAYPAL_LIVE" name="paypal-mode"
        value="PAYPAL_LIVE" onchange="sendMode('PAYPAL_LIVE')">
    <label for="PAYPAL_LIVE">
        {if $smarty.session.AdminAccount->language === 'de-DE'}
            Live-Modus
        {else}
            live Mode
        {/if}
    </label>
    <br>
    <input form="add-credential" class="paypal-mode" required type="radio" id="PAYPAL_SAND_BOX" name="paypal-mode"
        value="PAYPAL_SAND_BOX" onchange="sendMode('PAYPAL_SAND_BOX')">
    <label for="PAYPAL_SAND_BOX">
        {if $smarty.session.AdminAccount->language === 'de-DE'}
            Sandkasten-Modus
        {else}
            Sand Box Mode
        {/if}
    </label>
</div>

<h2 class="trainer-name">
    {if $smarty.session.AdminAccount->language === 'de-DE'}
        Diese Daten werden für Geschäftskonten verwendet
    {else}
        This data is used for business account
    {/if}
</h2>
<hr />

<form id="add-credential" class="tecSee-form" onsubmit="createCredentials(event)" method="POST" autocomplete="off"
    enctype="multipart/form-data">
    {$jtl_token}
    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Business-Konto
            {else}
                Business account
            {/if}
        </label>
        <input type="text" name="business_account"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}{else}Write your business account{/if}"
            required>
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Kunden-ID
            {else}
                Client Id
            {/if}
        </label>
        <input type="text" name="client_id"
            placeholder=" {if $smarty.session.AdminAccount->language === 'de-DE'}Schreiben Sie Ihre Kunden-ID{else}Write your client id{/if}"
            required>
    </div>

    <div class="full-width">
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Geheimcode
            {else}
                Secret Key
            {/if}
        </label>
        <input type="text" name="secret_key"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}{else}Write your secret key{/if}"
            required>
    </div>

    <input type="submit" value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
</form>

<hr />

<form class="tecSee-form">
    <h2 class="trainer-name">
        {if $smarty.session.AdminAccount->language === 'de-DE'}
            Der Zahlungsvorgang wird auf diese Links umgeleitet:
        {else}
            Payment process will be redirected to these links:
        {/if}
    </h2>
    <div class="full-width">
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Erfolg Zahlung
            {else}
                Success Payment
            {/if}
        </label>
        <input type="text" value="{$successUrl}" style="background: lightgrey;" readonly>
    </div>

    <div class="full-width">
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Stornierte Zahlung
            {else}
                Canceled Payment
            {/if}
        </label>
        <input type="text" value="{$cancelUrl}" style="background: lightgrey;" readonly>
    </div>
</form>

<hr />

<div class="tecSee-table-parent">
    <div class='tecSee-table-container'>
        <div class="tecSee-remove-padding">
            <table class="tecSee-table">
                <thead>
                    <tr>
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <th>Auswahl</th>
                            <th>id</th>
                            <th>Business-Konto</th>
                            <th>Kunden-ID</th>
                            <th>Geheimcode</th>
                            <th>Löschen</th>
                        {else}
                            <th>select</th>
                            <th>id</th>
                            <th>Business account</th>
                            <th>Client Id</th>
                            <th>Secret Key</th>
                            <th>delete</th>
                        {/if}
                    <tr>
                </thead>
                <tbody>
                    <tr>
                        {if (isset($credentials)) && $credentials|@count > 0}
                            {foreach from=$credentials item=credential}
                                <td id="api-credentials-td">
                                    <button class="fas fa-edit text-dark" onclick='handleCredential({$credential})'></button>
                                </td>
                                <td>{$credential->id}</td>
                                <td>{$credential->business_account}</td>
                                <td>{$credential->client_id}</td>
                                <td>{$credential->secret_key}</td>
                                <td>
                                    <form onsubmit="deleteCredentials(event,{$credential->id})" action="" method="get">
                                        <input type="hidden" name="kPlugin" value="{$pluginId}">
                                        <input type="hidden" name="fetch" value="api-credentials">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="credentialId" value="{$credential->id}">
                                        {$jtl_token}
                                        <button type="submit" class="btn btn-danger tecSee-button-delete"
                                            style="font-weight: bold;">
                                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                                Löschen
                                            {else}
                                                delete
                                            {/if}
                                        </button>
                                    </form>
                                </td>
                            {/foreach}
                        {else}
                            <td class='text-center' id='npApiMessage' colspan="6">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    es liegen keine Daten vor
                                {else}
                                    there is no data
                                {/if}
                            </td>
                        {/if}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



<button type="button" hidden class="btn btn-info btn-lg" id="credentialmodeledit" data-toggle="modal"
    data-target="#credentialModal"></button>

<!--  Edit modal -->

<div class="modal fade" id="credentialModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i id="close-edit-credentials" class="fas fa-xmark close" data-dismiss="modal">X</i>
                <h4>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        bearbeiten
                    {else}
                        Edit
                    {/if}
                </h4>
            </div>

            <div class="modal-body">
                <form class="tecSee-form" onsubmit='updateCredentials(event)' id="update-credentials" method="POST"
                    autocomplete="off" enctype="multipart/form-data">
                    {$jtl_token}

                    <input type="hidden" id="credentialId" name="credentialId" value="">

                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Business-Konto
                            {else}
                                Business account
                            {/if}
                        </label>
                        <input type="text" name="business_account" id="businessAccount" placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}
                                Schreiben sie ihre Business-Konto{else}Write your business account{/if}" required>
                    </div>

                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Kunden-ID
                            {else}
                                Client Id
                            {/if}
                        </label>
                        <input type="text" name="client_id" id="clientId"
                            placeholder=" {if $smarty.session.AdminAccount->language === 'de-DE'}{else}Write your client id{/if}"
                            required>
                    </div>

                    <div class="full-width">
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Geheimcode
                            {else}
                                Secret Key
                            {/if}
                        </label>
                        <input type="text" name="secret_key" id="secretKey"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Schreiben Sie Ihren Geheimcode{else}Write your secret key{/if}"
                            required>
                    </div>

                    <div>
                        <label for="paypal-mode">Paypal Mode
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Paypal-Modus
                            {else}
                                Paypal Mode
                            {/if}
                        </label>
                        <select name="paypal-mode" id="paypal-mode" required>
                            <option disabled selected value="">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Wählen Sie den Paypal-Modus
                                {else}
                                    Chose Paypal Mode
                                {/if}
                            </option>
                            <option value="PAYPAL_LIVE">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Live-Modus
                                {else}
                                    live Mode
                                {/if}
                            </option>
                            <option value="PAYPAL_SAND_BOX">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Sandkasten-Modus
                                {else}
                                    Sand Box Mode
                                {/if}
                            </option>
                        </select>
                    </div>

                    <input type="submit"
                        value="{if $smarty.session.AdminAccount->language === 'de-DE'}bearbeiten{else}Edit{/if}">
                </form>
            </div>
        </div>

    </div>
</div>



<!-- Modal -->
<!--  Edit modal -->

<!-- Button trigger modal -->
<button style="display: none;" id="open-credentials-button" type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#modalForCredentialsTab">
</button>

<!-- Modal -->
<div class="modal fade" id="modalForCredentialsTab" tabindex="-1" role="dialog"
    aria-labelledby="modalForCredentialsTabTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Status der Operationen
                    {else}
                        Operations Status
                    {/if}
                </h5>
                <button id="close-credentials-icon" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="credentials-message"></p>
            </div>
            <div class="modal-footer">
                <button id="close-credentials-button" type="button" class="btn btn-secondary" data-dismiss="modal">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Schließen Sie
                    {else}
                        Close
                    {/if}
                </button>
            </div>
        </div>
    </div>
</div>


{include file="./handleCredential.tpl"}