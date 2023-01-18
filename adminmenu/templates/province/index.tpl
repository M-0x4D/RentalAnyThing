{include file="../layout/tecsee_styles.tpl"}

<form class="tecSee-form" onsubmit='createProvince(event)' id="create-province" method="POST" autocomplete="off"
    enctype="multipart/form-data">
    {$jtl_token}

    {if (isset($countries))}
        <div class="full-width">
            <label for="select-countries-for-province">Country/Land</label>
            <select id="select-countries-for-province" name="country_id" required>
                {if $countries|@count > 0}
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        <option value="" selected disabled>Land wählen</option>
                    {else}
                        <option value="" selected disabled>Choose country</option>
                    {/if}
                    {foreach from=$countries item=country}
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <option value="{$country->id}">{$country->countryName->en}</option>
                        {else}
                            <option value="{$country->id}">{$country->countryName->de}</option>
                        {/if}
                    {/foreach}
                {else}
                    <option value="" selected disabled>
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            Land zuerst hinzufügen
                        {else}
                            Add Country First
                        {/if}
                    </option>
                {/if}
            </select>
        </div>
    {/if}

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Gouvernement Name Englisch
            {else}
                Governorate Name English
            {/if}
        </label>
        <input type="text" name="province_name_en"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Gouvernement Name Englisch{else}Governorate Name English{/if}"
            required>
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Gouvernement Name Deutsch
            {else}
                Governorate Name German
            {/if}
        </label>
        <input type="text" name="province_name_de"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Gouvernement Name Deutsch{else}Governorate Name German{/if}"
            required>
    </div>

    <input type="submit" value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
</form>

<hr />

{* <pre>
    {$smarty.session.kSprache}
</pre> *}

{if (isset($governrates)) && (count($governrates) > 0)}
    <div class="tecSee-table-parent">
        <div class='tecSee-table-container'>
            <div class="tecSee-remove-padding">
                <table class="tecSee-table">
                    <tr>
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <th>Auswahl</th>
                            <th>id</th>
                            <th>Gouvernement Name Englisch</th>
                            <th>Gouvernement Name Deutsch</th>
                            <th>Löschen</th>
                        {else}
                            <th>select</th>
                            <th>id</th>
                            <th>Governorate Name English</th>
                            <th>Governorate Name German</th>
                            <th>delete</th>
                        {/if}
                    <tr>
                        {foreach from=$governrates item=governorate}
                        <tr>
                            <td>
                                <button class="fas fa-edit text-dark"
                                    onclick="handleProvince('{$governorate->id}','{$governorate->governrateName->en}','{$governorate->governrateName->de}','{$governorate->country_id}');">
                                </button>
                            </td>
                            <td>{$governorate->id}</td>
                            <td>
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    {$governorate->countryName->de}
                                {else}
                                    {$governorate->countryName->en}
                                {/if}
                            </td>

                            <td>
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    {$governorate->governrateName->de}
                                {else}
                                    {$governorate->governrateName->en}
                                {/if}
                            </td>
                            <td>
                                <form onsubmit="deleteProvince(event,{$governorate->id})" action="" method="get">
                                    <input type="hidden" name="kPlugin" value="{$pluginId}">
                                    <input type="hidden" name="fetch" value="governrates">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="governorateId" value="{$governorate->id}">
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

<button type="button" hidden class="btn btn-info btn-lg" id="provinceeditmodal" data-toggle="modal"
    data-target="#provinceModal"></button>

<!--  Edit modal -->
<div class="modal fade" id="provinceModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i id="close-edit-province" class="fas fa-xmark close" data-dismiss="modal">X</i>
                <h4>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        bearbeiten
                    {else}
                        Edit
                    {/if}
                </h4>
            </div>

            <div class="modal-body">
                <form class="tecSee-form" onsubmit='updateProvince(event)' id="update-province" method="POST"
                    autocomplete="off" enctype="multipart/form-data">
                    {$jtl_token}

                    <input type="hidden" id="provinceId" name="provinceId">

                    {if (isset($countries))}
                        <div class="full-width">
                            <label for="select-countries-for-province-update">Country/Land</label>
                            <select disabled id="select-countries-for-province-update" name="country_id" required>
                                <option value="" selected disabled>Choose country</option>
                                {foreach from=$countries item=country}
                                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                                        <option value="{$country->id}">{$country->countryName->en}</option>
                                    {else}
                                        <option value="{$country->id}">{$country->countryName->de}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>
                    {/if}

                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Gouvernement Name Englisch
                            {else}
                                Governorate Name English
                            {/if}
                        </label>
                        <input type="text" name="province_name_en" id="province-en"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Gouvernement Name Englisch{else}Governorate Name English{/if}"
                            required>
                    </div>

                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Gouvernement Name Deutsch
                            {else}
                                Governorate Name German
                            {/if}
                        </label>
                        <input type="text" name="province_name_de" id="province-de"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Gouvernement Name Deutsch{else}Governorate Name German{/if}"
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
<button style="display: none;" id="open-province-button" type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#modalForProvinceTab">
</button>

<!-- Modal -->
<div class="modal fade" id="modalForProvinceTab" tabindex="-1" role="dialog" aria-labelledby="modalForProvinceTabTitle"
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
                <button id="close-province-icon" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="province-message">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Wenn Sie dieses Gouvernement löschen, werden alle von ihm abhängigen Produkte gelöscht.
                    {else}
                        when you delete this governorate you will delete all products depend on it
                    {/if}
                </p>
            </div>
            <div class="modal-footer">
                <button id="close-province-button" type="button" class="btn btn-secondary" data-dismiss="modal">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Schließen Sie
                    {else}
                        Close
                    {/if}
                </button>

                <button id="delete-province-button" style="display: none;" type="button" class="btn btn-secondary"
                    data-dismiss="modal">ok</button>
            </div>
        </div>
    </div>
</div>

<script src="{$pluginPath}js/province/index.js"></script>