{include file="../layout/tecsee_styles.tpl"}

<form class="tecSee-form" onsubmit='createCountry(event)' id="create-country" method="POST" autocomplete="off"
    enctype="multipart/form-data">
    {$jtl_token}
    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Land Name Englisch
            {else}
                Country Name English
            {/if}
        </label>
        <input type="text" name="country_name_en"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Land Name Englisch{else}Country Name English{/if}"
            required>
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Land Name Deutsch
            {else}
                Country Name German
            {/if}
        </label>
        <input type="text" name="country_name_de"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Land Name Deutsch{else}Country Name German{/if}"
            required>
    </div>

    <input type="submit" value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
</form>

<hr />

{if (isset($countries)) && (count($countries) > 0)}

    <div class="tecSee-table-parent">
        <div class='tecSee-table-container'>
            <div class="tecSee-remove-padding">
                <table class="tecSee-table">
                    <tr>
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <th>Auswahl</th>
                            <th>id</th>
                            <th>Land Name Englisch</th>
                            <th>Land Name Deutsch</th>
                            <th>Löschen</th>
                        {else}
                            <th>select</th>
                            <th>id</th>
                            <th>Country Name English</th>
                            <th>Country Name German</th>
                            <th>delete</th>
                        {/if}
                    <tr>
                        {foreach from=$countries item=country}
                        <tr>
                            <td>
                                <button class="fas fa-edit text-dark" onclick="handleCountry('{$country->id}',
                                    '{$country->countryName->en}','{$country->countryName->de}');">
                                </button>
                            </td>
                            <td>{$country->id}</td>
                            <td>{$country->countryName->en}</td>
                            <td>{$country->countryName->de}</td>
                            <td>
                                <form onsubmit="deleteCountry(event,{$country->id})" action="" method="get">
                                    <input type="hidden" name="kPlugin" value="{$pluginId}">
                                    <input type="hidden" name="fetch" value="countries">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="countryId" value="{$country->id}">
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
                        </tr>
                    {/foreach}
                </table>
            </div>
        </div>
    </div>

{/if}


<button type="button" hidden class="btn btn-info btn-lg" id="countryeditmodal" data-toggle="modal"
    data-target="#countryModal"></button>

<!--  Edit modal -->
<div class="modal fade" id="countryModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i id="close-edit-country" class="fas fa-xmark close" data-dismiss="modal">X</i>
                <h4>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        bearbeiten
                    {else}
                        Edit
                    {/if}
                </h4>
            </div>

            <div class="modal-body">
                <form class="tecSee-form" onsubmit='updateCountry(event)' id="update-country" method="POST"
                    autocomplete="off" enctype="multipart/form-data">
                    {$jtl_token}

                    <input type="hidden" id="countryId" name="countryId">
                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Land Name Englisch
                            {else}
                                Country Name English
                            {/if}
                        </label>
                        <input type="text" name="country_name_en" id="country-en"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Land Name Englisch{else}Country Name English{/if}"
                            required>
                    </div>

                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Land Name Deutsch
                            {else}
                                Country Name German
                            {/if}
                        </label>
                        <input type="text" name="country_name_de" id="country-de"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Land Name Deutsch{else}Country Name German{/if}"
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
<button style="display: none;" id="open-country-button" type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#modalForCountryTab">
</button>

<!-- Modal -->
<div class="modal fade" id="modalForCountryTab" tabindex="-1" role="dialog" aria-labelledby="modalForCountryTabTitle"
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
                <button id="close-country-icon" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="country-message">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Wenn Sie dieses Land löschen, werden alle Produkte, die von diesem Land abhängen, gelöscht.
                    {else}
                        when you delete this country you will delete all products depend on it
                    {/if}
                </p>
            </div>
            <div class="modal-footer">
                <button id="close-country-button" type="button" class="btn btn-secondary" data-dismiss="modal">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Schließen Sie
                    {else}
                        Close
                    {/if}
                </button>

                <button id="delete-country-button" style="display: none;" type="button" class="btn btn-secondary"
                    data-dismiss="modal">ok</button>
            </div>
        </div>
    </div>
</div>

<script src="{$pluginPath}js/country/index.js"></script>