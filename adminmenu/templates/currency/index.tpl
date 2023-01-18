{include file="../layout/tecsee_styles.tpl"}


<form class="tecSee-form" onsubmit='createCurrency(event)' id="create-currency">
    {$jtl_token}
    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Währung Name
            {else}
                Currency Name
            {/if}
        </label>
        <input type="text" name="currency_name"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Währung Name{else}Currency Name{/if}"
            required>
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Währung Code
            {else}
                Currency Code
            {/if}
        </label>
        <input type="text" name="currency_code"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Währung Code{else}Currency Code{/if}"
            required>
    </div>

    <input type="submit" value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
</form>
<hr />

{if (isset($currencies))}
    <div class="tecSee-table-parent">
        <div class='tecSee-table-container'>
            <div class="tecSee-remove-padding">
                <table class="tecSee-table">
                    <thead>
                        <tr>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                <th>Auswahl</th>
                                <th>id</th>
                                <th>Währungsname</th>
                                <th>Währungscode</th>
                                <th>Löschen</th>
                            {else}
                                <th>select</th>
                                <th>id</th>
                                <th>currency name</th>
                                <th>currency code</th>
                                <th>delete</th>
                            {/if}
                        <tr>
                    </thead>
                    {if $currencies|count > 0}
                        {foreach from=$currencies item=currency}
                            <tr>
                                <td>
                                    <button class="fas fa-edit text-dark"
                                        onclick="handleCurrency('{$currency->id}','{$currency->name}','{$currency->currency_code}');"></button>
                                </td>
                                <td>{$currency->id}</td>
                                <td>{$currency->name}</td>
                                <td>{$currency->currency_code}</td>
                                <td>
                                    <button onclick="deleteCurrency({$currency->id})" type="submit"
                                        class="btn btn-danger tecSee-button-delete" style="font-weight: bold;">
                                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                                            Löschen
                                        {else}
                                            delete
                                        {/if}
                                    </button>
                                </td>
                            </tr>
                        {/foreach}
                    {else}
                        <tr>
                            <td colspan="5" class="text-center">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    es liegen keine Daten vor
                                {else}
                                    there is no data
                                {/if}
                            </td>
                        </tr>
                    {/if}
                </table>
            </div>
        </div>
    </div>
{/if}


<button type="button" hidden class="btn btn-info btn-lg" id="currencyeditmodal" data-toggle="modal"
    data-target="#currencyModal"></button>

<!--  Edit modal -->

<div class="modal fade" id="currencyModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i id="close-edit-currency" class="fas fa-xmark close" data-dismiss="modal">X</i>
                <h4>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        bearbeiten
                    {else}
                        Edit
                    {/if}
                </h4>
            </div>

            <div class="modal-body">
                <form class="tecSee-form" onsubmit='updateCurrency(event)' id="update-currency">
                    {$jtl_token}

                    <input type="hidden" id="currencyId" name="currency_id">
                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Währung Name
                            {else}
                                Currency Name
                            {/if}
                        </label>
                        <input type="text" id="currency-en" name="currency_name"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Geben Sie den Namen der Währung ein{else}Type the currency name{/if}"
                            required>
                    </div>

                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Währungscode
                            {else}
                                Currency code
                            {/if}
                        </label>
                        <input type="text" id="currency-code" name="currency_code"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Geben Sie den Währungscode ein{else}Type the currency code{/if}"
                            required>
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
<button style="display: none;" id="open-currency-button" type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#modalForCurrencyTab">
</button>

<!-- Modal -->
<div class="modal fade" id="modalForCurrencyTab" tabindex="-1" role="dialog" aria-labelledby="modalForCurrencyTabTitle"
    aria-hidden="true">
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
                <button id="close-currency-icon" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="currency-message">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Wenn Sie diese Währung löschen, werden alle von ihr abhängigen Produkte gelöscht.
                    {else}
                        when you delete this currency you will delete all products depend on it
                    {/if}
                </p>
            </div>
            <div class="modal-footer">
                <button id="close-currency-button" type="button" class="btn btn-secondary" data-dismiss="modal">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Schließen Sie
                    {else}
                        Close
                    {/if}
                </button>

                <button id="delete-currency-button" style="display: none;" type="button" class="btn btn-secondary"
                    data-dismiss="modal">ok</button>
            </div>
        </div>
    </div>
</div>

<script src="{$pluginPath}js/currency/index.js"></script>