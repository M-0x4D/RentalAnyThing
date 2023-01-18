{include file="../layout/tecsee_styles.tpl"}


{* <pre>
{$smarty.session.AdminAccount->language|print_r}
</pre> *}

<form class="tecSee-form" onsubmit='createCity(event)' id="create-city" method="POST" autocomplete="off"
    enctype="multipart/form-data">
    {$jtl_token}

    {if (isset($countries))}
        <div class="full-width">
            <label for="select-countries-for-city">Country/Land</label>
            <select id="select-countries-for-city" name="country_id" required>
                {if $countries|@count > 0}
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        <option value="" selected disabled>Land wählen</option>
                    {else}
                        <option value="" selected disabled>Choose country</option>
                    {/if}
                    {foreach from=$countries item=country}
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <option value="{$country->id}">{$country->countryName->de}</option>
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

    {if (isset($governrates))}
        <div class="full-width" id="select-governrates-for-city-parent" style="display: none;">
            <label for="select-governrates-for-city">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Wählen Sie ein Gouvernement
                {else}
                    Choose Governorate
                {/if}
            </label>
            <select id="select-governrates-for-city" name="governrate_id" required>

            </select>
        </div>
    {/if}

    <div id="city-name-en" style="display: none;">
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Stadt Name Englisch
            {else}
                City Name English
            {/if}
        </label>
        <input type="text" name="city_name_en"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Stadt Name Englisch{else}City Name English{/if}"
            required>
    </div>

    <div id="city-name-de" style="display: none;">
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Stadt Name Deutsch
            {else}
                City Name German
            {/if}
        </label>
        <input type="text" name="city_name_de"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Stadt Name Deutsch{else}City Name German{/if}"
            required>
    </div>

    <input type="submit" value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
</form>

<hr />

{if (isset($cities)) && (count($cities) > 0)}
    <div class="tecSee-table-parent">
        <div class='tecSee-table-container'>
            <div class="tecSee-remove-padding">
                <table class="tecSee-table">
                    <tr>
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <th>Auswahl</th>
                            <th>id</th>
                            <th>Stadt Name Englisch</th>
                            <th>Stadt Name Deutsch</th>
                            <th>Löschen</th>
                        {else}
                            <th>select</th>
                            <th>id</th>
                            <th>City Name English</th>
                            <th>City Name German</th>
                            <th>delete</th>
                        {/if}
                    <tr>
                        {foreach from=$cities item=city}
                        <tr>
                            <td>
                                <button class="fas fa-edit text-dark"
                                    onclick="handleCity('{$city->id}',
                                    '{$city->cityName->en}','{$city->cityName->de}','{$city->country_id}' ,'{$city->governrate_id}');">
                                </button>
                            </td>
                            <td>{$city->id}</td>
                            <td>
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    {$city->cityName->de}
                                {else}
                                    {$city->cityName->en}
                                {/if}
                            </td>
                            <td>
                                <form onsubmit="deleteCity({$city->id})" action="" method="get">
                                    <input type="hidden" name="kPlugin" value="{$pluginId}">
                                    <input type="hidden" name="fetch" value="cities">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="cityId" value="{$city->id}">
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


<button type="button" hidden class="btn btn-info btn-lg" id="cityeditmodal" data-toggle="modal"
    data-target="#cityModal"></button>

<!--  Edit modal -->
<div class="modal fade" id="cityModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i id="close-edit-city" class="fas fa-xmark close" data-dismiss="modal">X</i>
                <h4>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        bearbeiten
                    {else}
                        Edit
                    {/if}
                </h4>
            </div>

            <div class="modal-body">
                <form class="tecSee-form" onsubmit='updateCityFun(event)' id="update-city" method="POST"
                    autocomplete="off" enctype="multipart/form-data">
                    {$jtl_token}

                    {if (isset($countries))}
                        <div class="full-width">
                            <label for="update-select-countries-for-city">Country/Land</label>
                            <select disabled id="update-select-countries-for-city" name="country_id" required>
                                <option value="" selected disabled>Choose country</option>
                                {foreach from=$countries item=country}
                                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                                        <option value="{$country->id}">{$country->countryName->de}</option>
                                    {else}
                                        <option value="{$country->id}">{$country->countryName->de}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>
                    {/if}

                    {if (isset($governrates))}
                        {* <div class="full-width" id="update-select-governrates-for-city-parent" style="display: none;"> *}
                        <div class="full-width" id="update-select-governrates-for-city-parent">
                            <label for="select-governrates-for-city">Governrate/Gouverneursrat</label>
                            <select disabled id="update-select-governrates-for-city" name="governrate_id" required>

                            </select>
                        </div>
                    {/if}

                    <input type="hidden" id="cityId" name="cityId">
                    {* <div id="update_city_name_en" style="display:none"> *}
                    <div id="update_city_name_en">
                        <label>City</label>
                        <input type="text" name="city_name_en" id="city-en" placeholder="Update City" required>
                    </div>

                    {* <div id="update_city_name_de" style="display:none"> *}
                    <div id="update_city_name_de">
                        <label>Standort</label>
                        <input type="text" name="city_name_de" id="city-de" placeholder="Update Stadt" required>
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
<button style="display: none;" id="open-city-button" type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#modalForCityTab">
</button>

<!-- Modal -->
<div class="modal fade" id="modalForCityTab" tabindex="-1" role="dialog" aria-labelledby="modalForCityTabTitle"
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
                <button id="close-city-icon" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="city-message">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Wenn Sie diese Stadt löschen, löschen Sie auch alle Produkte, die von ihr abhängen.
                    {else}
                        when you delete this city you will delete all products depend on it
                    {/if}
                </p>
            </div>
            <div class="modal-footer">
                <button id="close-city-button" type="button" class="btn btn-secondary" data-dismiss="modal">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Schließen Sie
                    {else}
                        Close
                    {/if}
                </button>

                <button id="delete-city-button" style="display: none;" type="button" class="btn btn-secondary"
                    data-dismiss="modal">ok</button>
            </div>
        </div>
    </div>
</div>

<script src="{$pluginPath}js/city/index.js"></script>