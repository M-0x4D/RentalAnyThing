{include file="../layout/tecsee_styles.tpl"}

<form onsubmit="addNewObject(event);" id="add-new-object-form" class="tecSee-form" method="POST" method="POST"
    autocomplete="off" enctype="multipart/form-data">
    {$jtl_token}

    <div class="full-width">
        <label for="nameEn">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Englischer Name
            {else}
                English Name
            {/if}
        </label>
        <input id="nameEn" type="text" name="object_name_en"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typ Objektname englisch{else}Type object name english{/if}"
            required>
    </div>

    <div class="full-width">
        <label for="nameDe">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Deutscher Name
            {else}
                German Name
            {/if}
        </label>
        <input id="nameDe" type="text" name="object_name_de"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typ Objektname deutsch{else}Type object name german{/if}"
            required>
    </div>

    <div class="full-width">
        <label for="price">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Preis
            {else}
                Price
            {/if}
        </label>
        <input id="price" type="number" name="price"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typ Objektpreis{else}Type object price{/if}"
            min="1" required>
    </div>

    <div class="full-width">
        <label for="quantity">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Menge
            {else}
                quantity
            {/if}
        </label>
        <input id="quantity" type="number" name="quantity"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typ Objektmenge{else}Type object quantity{/if}"
            min="1" required>
    </div>


    {if (isset($currencies))}
        <div class="full-width">
            <label for="color">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Währung
                {else}
                    currency
                {/if}
            </label>
            <select id="color" name="currency_id" required>
                <option value="" selected disabled>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Währung wählen
                    {else}
                        Choose Currency
                    {/if}
                </option>
                {foreach from=$currencies item=currency}
                    <option value="{$currency->id}">{$currency->name}</option>
                {/foreach}
            </select>
        </div>
    {/if}

    <div class="full-width">
        <label for="duration">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Dauer
            {else}
                Duration
            {/if}
        </label>
        <select id="duration" name="duration" required>
            <option value="" selected disabled>
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Dauer wählen
                {else}
                    Choose duration
                {/if}
            </option>
            <option value="60">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Stunde
                {else}
                    Hour
                {/if}
            </option>
            <option value="1">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Tag
                {else}
                    Day
                {/if}
            </option>
            <option value="7">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Woche
                {else}
                    Week
                {/if}
            </option>
            <option value="30">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Monat
                {else}
                    Month
                {/if}
            </option>
        </select>
    </div>

    {if (isset($colors))}
        <div class="full-width">
            <label for="color">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Die Farbe
                {else}
                    Color
                {/if}
            </label>
            <select id="color" name="color_id" required>
                <option value="" selected disabled>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Farbe wählen
                    {else}
                        Choose Color
                    {/if}
                </option>
                {foreach from=$colors item=color}
                    <option value="{$color->id}">
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            {$color->colorNameDE}
                        {else}
                            {$color->colorNameEN}
                        {/if}
                    </option>
                {/foreach}
            </select>
        </div>
    {/if}

    {if (isset($countries))}
        <div class="full-width">
            <label for="countries">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Land
                {else}
                    Country
                {/if}
            </label>
            <select id="countries" name="country_id" required>
                {if $countries|@count > 0}
                    <option value="" selected disabled>
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            Land wählen
                        {else}
                            Choose country
                        {/if}
                    </option>
                    {foreach from=$countries item=country}
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <option value="{$country->id}">{$country->countryName->de}</option>
                        {else}
                            <option value="{$country->id}">{$country->countryName->en}</option>
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
        <div class="full-width" style="display: none;">
            <label for="governrate">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Gouverneursrat
                {else}
                    Governrate
                {/if}
            </label>
            <select id="governrate" name="governrate_id" required>

            </select>
        </div>
    {/if}

    {if (isset($cities))}
        <div class="full-width" style="display: none;">
            <label for="city">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Stadt
                {else}
                    city
                {/if}
            </label>
            <select id="city" name="city_id" required>

            </select>
        </div>
    {/if}

    {if (isset($categories))}
        <div class="full-width">
            <label for="category">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Kategoriebezeichnung
                {else}
                    category name
                {/if}
            </label>
            <select id="category" name="category_id" required>
                <option value="" selected disabled>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Kategorie wählen
                    {else}
                        Choose Category
                    {/if}
                </option>
                {foreach from=$categories item=category}
                    <option value="{$category->id}">
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            {$category->categoryNameDE}
                        {else}
                            {$category->categoryNameEN}
                        {/if}
                    </option>
                {/foreach}
            </select>
        </div>
    {/if}

    <div class="full-width">
        <label for="long_description_en">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                lange Beschreibung Englisch
            {else}
                Long Description English
            {/if}
        </label>
        <textarea required style="resize: none;" id="long_description_en" name="long_description_en" rows="4"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}object long description/Object long description{else}object long description/Objekt lange Beschreibung{/if}"></textarea>
    </div>

    <div class="full-width">
        <label for="long_description_de">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                lange Beschreibung Deutsch
            {else}
                Long Description German
            {/if}
        </label>
        <textarea required style="resize: none;" id="long_description_de" name="long_description_de" rows="4"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Objekt lange Beschreibung{else}object long description{/if}"></textarea>
    </div>

    <div class="full-width">
        <label for="short_description_en">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Kurzbeschreibung Englisch
            {else}
                Short Description English
            {/if}
        </label>
        <textarea required style="resize: none;" id="short_description_en" name="short_description_en" rows="4"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Objekt lange Beschreibung{else}object long description
            {/if}"></textarea>
    </div>

    <div class="full-width">
        <label for="short_description_de">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Kurzbeschreibung Deutsch
            {else}
                Short Description German
            {/if}
        </label>
        <textarea required style="resize: none;" id="short_description_de" name="short_description_de" rows="4"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Objektbeschreibung{else}object description{/if}"></textarea>
    </div>

    <div class="full-width">
        <label for="image">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Hauptbild
            {else}
                Main Image
            {/if}
        </label>
        <input id="image" required type="file" name="image" accept="image/png, image/gif, image/jpeg"
            style="width: 100%;" />
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Preis beinhaltet Englisch
            {else}
                Price Includes English
            {/if}
        </label>
        <textarea type="text" name="price_includes_en" style="resize: none;"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}mit Komma trennen: erster Punkt, zweiter Punkt, dritter Punkt ... usw.{else}separarte with comma: first point, second point, third point ... etc{/if}"
            required></textarea>
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Preis beinhaltet Deutsch
            {else}
                Price Includes German
            {/if}
        </label>
        <textarea type="text" name="price_includes_de" style="resize: none;"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}mit Komma trennen: erster Punkt, zweiter Punkt, dritter Punkt ... usw.{else}separarte with comma: first point, second point, third point ... etc{/if}"
            required></textarea>
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Preis exkl. Englisch
            {else}
                Price Excludes English
            {/if}
        </label>
        <textarea type="text" name="price_excludes_en" style="resize: none;"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}mit Komma trennen: erster Punkt, zweiter Punkt, dritter Punkt ... usw.{else}separarte with comma: first point, second point, third point ... etc{/if}"
            required></textarea>
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Preis exkl. Deutsch
            {else}
                Price Excludes German
            {/if}
        </label>
        <textarea type="text" name="price_excludes_de" style="resize: none;"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}mit Komma trennen: erster Punkt, zweiter Punkt, dritter Punkt ... usw.{else}separarte with comma: first point, second point, third point ... etc{/if}"
            required></textarea>
    </div>

    <hr class="full-width">

    <div id="additional_inputs_controllers" class="full-width" style="padding: 0; margin: 0;">

        <h2 class="text-center">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Zusätzliche Merkmale
            {else}
                Additional Features
            {/if}
        </h2>

        <div>
            <label for="additional-features-name">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Merkmale Name
                {else}
                    Features Name
                {/if}
            </label>
            <input id="additional-features-name" type="text" name="custom_features_input"
                placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typmerkmale Name{else}Type features name{/if}">
        </div>

        <div>
            <label for="additional-features-type">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Merkmale Typ
                {else}
                    Features Type
                {/if}
            </label>
            <select id="additional-features-type" name="custom_features_input">
                <option value="" selected disabled>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Art der Merkmale auswählen
                    {else}
                        Choose features type
                    {/if}
                </option>
                <option value="string">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Text
                    {else}
                        text
                    {/if}
                </option>
                <option value="integer">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Nummer
                    {else}
                        number
                    {/if}
                </option>
                <option value="text">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        textarea
                    {else}
                        textarea
                    {/if}
                </option>
            </select>
        </div>
    </div>

    <div style="height: fit-content; width: 100%;margin: 10px 0 0;padding: 0;" class="full-width tecSee-table-parent">
        <div style="padding:0; margin:0;" class='tecSee-table-container'>
            <div style="padding:0; margin:0;" class="tecSee-remove-padding">
                <table class="tecSee-table mb-3">
                    <thead>
                        <tr>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                <th>Nummer</th>
                                <th>Name</th>
                                <th>Typ</th>
                                <th>Wert</th>
                                <th>Löschen</th>
                            {else}
                                <th>number</th>
                                <th>name</th>
                                <th>type</th>
                                <th>value</th>
                                <th>delete</th>
                            {/if}
                        <tr>
                    </thead>

                    <tbody id="additional_inputs">
                        <tr>
                            <td class="text-center" colspan="5">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    es liegen keine Daten vor
                                {else}
                                    there is no data
                                {/if}
                            </td>
                        <tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <input type="hidden" id="additional-features-array" name="additional_features">

    <hr class="full-width">

    <input type="submit" value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
</form>

<hr />

<div class="tecSee-table-parent">
    <div class="tecSee-table-container">
        <div class="tecSee-remove-padding mb-3" style="overflow: scroll;">
            <table class="table table-striped table-align-top tecSee-table">
                <thead>
                    <tr>
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <th class="text-center">Nummer</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Preis</th>
                            <th class="text-center">Menge</th>
                            <th class="text-center">Dauer</th>
                            <th class="text-center">Farbe</th>
                            <th class="text-center">Land</th>
                            <th class="text-center">Gouvernement</th>
                            <th class="text-center">Stadt</th>
                            <th class="text-center">Kategorie</th>
                            <th class="text-center">Lange Beschreibung</th>
                            <th class="text-center">Kurzbeschreibung</th>
                            <th class="text-center">Im Preis Inbegriffen</th>
                            <th class="text-center">Der Preis Schließt Aus</th>
                            <th class="text-center">Bild</th>
                            <th class="text-center">Aktionen</th>
                        {else}
                            <th class="text-center">Number</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Color</th>
                            <th class="text-center">Country</th>
                            <th class="text-center">Governorate</th>
                            <th class="text-center">City</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Long Description</th>
                            <th class="text-center">Short Description</th>
                            <th class="text-center">Price Includes</th>
                            <th class="text-center">Price Excludes</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Actions</th>
                        {/if}
                    </tr>
                </thead>
                <tbody id="all-promotions-data">
                    {if $objects|@count > 0}
                        {foreach $objects as $object}
                            <tr class="text-center">
                                <td>{$object@iteration}</td>
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    <td>{$object->objectName->de}</td>
                                    <td>{$object->price}</td>
                                    <td>{$object->quantity}</td>
                                    <td>Per
                                        {if +$object->duration === 1}
                                            Tag
                                        {elseif +$object->duration === 7}
                                            Woche
                                        {elseif +$object->duration === 30}
                                            Monat
                                        {elseif +$object->duration === 60}
                                            Stunde
                                        {/if}
                                    </td>
                                    <td>{$object->colorName->de}</td>
                                    <td>{$object->countryName->de}</td>
                                    <td>{$object->governrateName->de}</td>
                                    <td>{$object->cityName->de}</td>
                                    <td>{$object->categoryName->de}</td>
                                    <td class="control-height">
                                        <div>{$object->longDescriptions->de}</div>
                                    </td>
                                    <td class="control-height">
                                        <div>{$object->shortDescriptions->de}</div>
                                    </td>
                                    <td class="control-height">
                                        <div>{$object->priceIncludes->de}</div>
                                    </td>
                                    <td class="control-height">
                                        <div>{$object->priceExcludes->de}</div>
                                    </td>
                                {else}
                                    <td>{$object->objectName->en}</td>
                                    <td>{$object->price}</td>
                                    <td>{$object->quantity}</td>
                                    <td>Per
                                        {if +$object->duration === 1}
                                            Day
                                        {elseif +$object->duration === 7}
                                            Week
                                        {elseif +$object->duration === 30}
                                            Month
                                        {elseif +$object->duration === 60}
                                            Hour
                                        {/if}
                                    </td>
                                    <td>{$object->colorName->en}</td>
                                    <td>{$object->countryName->en}</td>
                                    <td>{$object->governrateName->en}</td>
                                    <td>{$object->cityName->en}</td>
                                    <td>{$object->categoryName->en}</td>
                                    <td class="control-height">
                                        <div>{$object->longDescriptions->en}</div>
                                    </td>
                                    <td class="control-height">
                                        <div>{$object->shortDescriptions->en}</div>
                                    </td>
                                    <td class="control-height">
                                        <div>{$object->priceIncludes->en}</div>
                                    </td>
                                    <td class="control-height">
                                        <div>{$object->priceExcludes->en}</div>
                                    </td>
                                {/if}

                                <td><img src="{$object->image}" alt="picture" width="100px" height="100px"></td>
                                <td class="td-buttons-container">
                                    <div style="display:flex; gap: 10px;">
                                        <button data-object='{$object->id}' class="btn btn-danger w-fit DeleteObject">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        <button onclick='openObjectUpdateModel({$object});'
                                            class="btn btn-primary w-fit update-oject">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        {/foreach}
                    {else}
                        <tr>
                            <td class='text-center' id='npApiMessage' colspan="16">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    es liegen keine Daten vor
                                {else}
                                    there is no data
                                {/if}
                            </td>
                        </tr>
                    {/if}
                </tbody>
            </table>
        </div>
    </div>
</div>

{* ======================== popup modal *}
<button type="button" class="d-none" id="add-new-oject" data-toggle="modal"
    data-target="#add-new-object-operations"></button>

<div class="modal fade" id="add-new-object-operations" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <button id="close-add-object-modal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="add-object-request-messages">

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="close-add-new-oject" class="btn btn-secondary" data-dismiss="modal">
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
{* ======================== popup modal *}

{* ============================================================== *}

{* ======================== update modal *}
<button type="button" hidden class="btn btn-info btn-lg" id="ojectEditModelButton" data-toggle="modal"
    data-target="#ojectEditModal"></button>

<!--  Edit modal -->
<div class="modal fade" id="ojectEditModal" role="dialog" style="min-width: 50%;width: fit-content;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i id="close-promotion-update-modal" class="fas fa-xmark close" data-dismiss="modal">X</i>
                <h4>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        bearbeiten
                    {else}
                        Edit
                    {/if}
                </h4>
            </div>
            <div class="modal-body">
                <form onsubmit="updateObject(event);" id="update-object-form" class="tecSee-form">
                    {$jtl_token}

                    <div class="full-width">
                        <label for="update-nameEn">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Englischer Name
                            {else}
                                English Name
                            {/if}
                        </label>
                        <input id="update-nameEn" type="text" name="object_name_en"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typ Objektname englisch{else}Type object name english{/if}"
                            required>
                    </div>

                    <div class="full-width">
                        <label for="update-nameDe">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Deutscher Name
                            {else}
                                German Name
                            {/if}
                        </label>
                        <input id="update-nameDe" type="text" name="object_name_de"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typ Objektname deutsch{else}Type object name german{/if}"
                            required>
                    </div>

                    <div class="full-width">
                        <label for="update-price">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Preis
                            {else}
                                Price
                            {/if}
                        </label>
                        <input id="update-price" type="number" name="price"
                            placeholder=" {if $smarty.session.AdminAccount->language === 'de-DE'}Typ Objektpreis{else}Type object price{/if}"
                            min="0" required>
                    </div>

                    <div class="full-width">
                        <label for="update-quantity">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Menge
                            {else}
                                quantity
                            {/if}
                        </label>
                        <input id="update-quantity" type="number" name="quantity"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typ Objektmenge{else}Type object quantity{/if}"
                            min="1" required>
                    </div>

                    <div class="full-width">
                        <label for="update-duration-obj">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Dauer
                            {else}
                                Duration
                            {/if}
                        </label>
                        <select id="update-duration-obj" name="duration" required>
                            <option value="" selected disabled>
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Dauer wählen
                                {else}
                                    Choose duration
                                {/if}
                            </option>
                            <option value="60">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Stunde
                                {else}
                                    Hour
                                {/if}
                            </option>
                            <option value="1">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Tag
                                {else}
                                    Day
                                {/if}
                            </option>
                            <option value="7">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Woche
                                {else}
                                    Week
                                {/if}
                            </option>
                            <option value="30">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Monat
                                {else}
                                    Month
                                {/if}
                            </option>
                        </select>
                    </div>

                    {if (isset($colors))}
                        <div class="full-width">
                            <label for="update-color-obj">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Die Farbe
                                {else}
                                    Color
                                {/if}
                            </label>
                            <select id="update-color-obj" name="color_id" required>
                                <option value="" selected disabled>
                                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                                        Farbe wählen
                                    {else}
                                        Choose Color
                                    {/if}
                                </option>
                                {foreach from=$colors item=color}
                                    <option value="{$color->id}">
                                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                                            {$color->colorNameDE}
                                        {else}
                                            {$color->colorNameEN}
                                        {/if}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                    {/if}

                    {if (isset($countries))}
                        <div class="full-width">
                            <label for="update-countries-obj">Country/Land</label>
                            <select id="update-countries-obj" name="country_id" required>
                                {if $countries|@count > 0}
                                    <option value="" selected disabled>
                                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                                            Land wählen
                                        {else}
                                            Choose country
                                        {/if}
                                    </option>
                                    {foreach from=$countries item=country}
                                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                                            <option value="{$country->id}">{$country->countryName->de}</option>
                                        {else}
                                            <option value="{$country->id}">{$country->countryName->en}</option>
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
                        <div class="full-width" style="display: none;">
                            <label for="update-governrate-obj">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Gouverneursrat
                                {else}
                                    Governrate
                                {/if}
                            </label>
                            <select id="update-governrate-obj" name="governrate_id" required>

                            </select>
                        </div>
                    {/if}

                    {if (isset($cities))}
                        <div class="full-width" style="display: none;">
                            <label for="update-city-obj">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Stadt
                                {else}
                                    city
                                {/if}
                            </label>
                            <select id="update-city-obj" name="city_id" required>

                            </select>
                        </div>
                    {/if}

                    {if (isset($categories))}
                        <div class="full-width">
                            <label for="update-category-obj">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Kategoriebezeichnung
                                {else}
                                    category name
                                {/if}
                            </label>
                            <select id="update-category-obj" name="category_id" required>
                                <option value="" selected disabled>
                                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                                        Kategorie wählen
                                    {else}
                                        Choose Category
                                    {/if}
                                </option>
                                {foreach from=$categories item=category}
                                    <option value="{$category->id}">
                                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                                            {$category->categoryNameDE}
                                        {else}
                                            {$category->categoryNameEN}
                                        {/if}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                    {/if}

                    <div class="full-width">
                        <label for="update_long_description_en">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                lange Beschreibung Englisch
                            {else}
                                Long Description English
                            {/if}
                        </label>
                        <textarea required style="resize: none;" id="update_long_description_en"
                            name="long_description_en" rows="4"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}{else}object long description/Objekt lange Beschreibung{/if}"></textarea>
                    </div>

                    <div class="full-width">
                        <label for="update_long_description_de">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                lange Beschreibung Deutsch
                            {else}
                                Long Description German
                            {/if}
                        </label>
                        <textarea required style="resize: none;" id="update_long_description_de"
                            name="long_description_de" rows="4" placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}
                                Objekt lange Beschreibung
                            {else}
                                object long description
                            {/if}"></textarea>
                    </div>

                    <div class="full-width">
                        <label for="update_short_description_en">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Kurzbeschreibung Englisch
                            {else}
                                Short Description English
                            {/if}
                        </label>
                        <textarea required style="resize: none;" id="update_short_description_en"
                            name="short_description_en" rows="4" placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}
                                Objekt lange Beschreibung
                            {else}
                                object long description
                            {/if}"></textarea>
                    </div>

                    <div class="full-width">
                        <label for="update_short_description_de">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Kurzbeschreibung Deutsch
                            {else}
                                Short Description German
                            {/if}
                        </label>
                        <textarea required style="resize: none;" id="update_short_description_de"
                            name="short_description_de" rows="4"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Objektbeschreibung{else}object description{/if}"></textarea>
                    </div>

                    <div class="full-width">
                        <label for="update-image">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Hauptbild
                            {else}
                                Main Image
                            {/if}
                        </label>
                        {* <input id="update-image" required type="file" name="image"
                            accept="image/png, image/gif, image/jpeg" style="width: 100%;" /> *}

                        <input id="update-image" required type="file" name="image"
                            accept="image/png, image/gif, image/jpeg" style="width: 100%;" />
                    </div>

                    <div class="full-width">
                        <label for="update_includes_en">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Preis beinhaltet Englisch
                            {else}
                                Price Includes English
                            {/if}
                        </label>
                        <textarea id="update_includes_en" type="text" name="price_includes_en" style="resize: none;"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}mit Komma trennen: erster Punkt, zweiter Punkt, dritter Punkt ... usw.{else}separarte with comma: first point, second point, third point ... etc{/if}"
                            required></textarea>
                    </div>

                    <div class="full-width">
                        <label for="update_includes_de">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Preis beinhaltet Deutsch
                            {else}
                                Price Includes German
                            {/if}
                        </label>
                        <textarea id="update_includes_de" type="text" name="price_includes_de" style="resize: none;"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}mit Komma trennen: erster Punkt, zweiter Punkt, dritter Punkt ... usw.{else}separarte with comma: first point, second point, third point ... etc{/if}"
                            required></textarea>
                    </div>

                    <div class="full-width">
                        <label for="update_excludes_en">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Preis exkl. Englisch
                            {else}
                                Price Excludes English
                            {/if}
                        </label>
                        <textarea id="update_excludes_en" type="text" name="price_excludes_en" style="resize: none;"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}mit Komma trennen: erster Punkt, zweiter Punkt, dritter Punkt ... usw.{else}separarte with comma: first point, second point, third point ... etc{/if}"
                            required></textarea>
                    </div>

                    <div class="full-width">
                        <label for="update_excludes_de">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Preis exkl. Deutsch
                            {else}
                                Price Excludes German
                            {/if}
                        </label>
                        <textarea id="update_excludes_de" type="text" name="price_excludes_de" style="resize: none;"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}mit Komma trennen: erster Punkt, zweiter Punkt, dritter Punkt ... usw.{else}separarte with comma: first point, second point, third point ... etc{/if}"
                            required></textarea>
                    </div>

                    <hr class="full-width">

                    <div id="update_additional_inputs_controllers" class="full-width" style="padding: 0; margin: 0;">

                        <h2 class="text-center">
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Zusätzliche Merkmale
                            {else}
                                Additional Features
                            {/if}
                        </h2>

                        <div>
                            <label for="update-additional-features-name">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Merkmale Name
                                {else}
                                    Features Name
                                {/if}
                            </label>
                            <input id="update-additional-features-name" type="text" name="update_custom_features_input"
                                placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Typmerkmale Name{else}Type features name{/if}">
                        </div>

                        <div>
                            <label for="update-additional-features-type">
                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                    Merkmale Typ
                                {else}
                                    Features Type
                                {/if}
                            </label>
                            <select id="update-additional-features-type" name="update_custom_features_input">
                                <option value="" selected disabled>
                                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                                        Art der Merkmale auswählen
                                    {else}
                                        Choose features type
                                    {/if}
                                </option>
                                <option value="string">
                                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                                        Text
                                    {else}
                                        text
                                    {/if}
                                </option>
                                <option value="integer">
                                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                                        Nummer
                                    {else}
                                        number
                                    {/if}
                                </option>
                                <option value="text">
                                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                                        textarea
                                    {else}
                                        textarea
                                    {/if}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div style="height: fit-content; width: 100%;margin: 10px 0 0;padding: 0;"
                        class="full-width tecSee-table-parent">
                        <div style="padding:0; margin:0;" class='tecSee-table-container'>
                            <div style="padding:0; margin:0;" class="tecSee-remove-padding">
                                <table class="tecSee-table mb-3">
                                    <thead>
                                        <tr>
                                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                                <th>Nummer</th>
                                                <th>Name</th>
                                                <th>Typ</th>
                                                <th>Wert</th>
                                                <th>Löschen</th>
                                            {else}
                                                <th>number</th>
                                                <th>name</th>
                                                <th>type</th>
                                                <th>value</th>
                                                <th>delete</th>
                                            {/if}
                                        <tr>
                                    </thead>

                                    <tbody id="update_additional_inputs">
                                        <tr>
                                            <td class="text-center" colspan="5">
                                                {if $smarty.session.AdminAccount->language === 'de-DE'}
                                                    es liegen keine Daten vor
                                                {else}
                                                    there is no data
                                                {/if}
                                            </td>
                                        <tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="update-additional-features-array" name="additional_features">

                    <hr class="full-width">

                    <input type="submit"
                        value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
                </form>
            </div>
        </div>

    </div>
</div>
{* ======================== update modal *}

<script src="{$pluginPath}js/objects/index.js"></script>