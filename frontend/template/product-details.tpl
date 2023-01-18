{block name='container-for-car-details'}
    {* start include pop-up *}
    {include file="small_components/alert_component.tpl"}
    {include file="small_components/message_components.tpl"}
    {* end include pop-up *}

    {* <pre>
        {$objekt_details|print_r}
    </pre>

    {$objekt_details->imagePath} *}

    <!-- ============================================================================================================ -->
    {* <div class="summary-car-details p-xs-1 p-sm-3 px-md-3 px-lg-4 px-xl-5 py-md-1 py-lg-3 py-xl-3 d-flex flex-wrap"> *}
    <div class="summary-car-details d-flex flex-wrap">
        <div class="main-car-img-and-data d-flex flex-column">
            <div class="car-and-price-and-descriptio d-flex flex-wrap">
                <div class="containor-of-img">
                    <img src="{$objekt_details->imagePath}" alt="product img" />
                </div>

                <div class="all-text-on-details">
                    <div class="main-details-on-summary">
                        <div class="one-up d-flex flex-column de-no-border">
                            <h2 class="car-name-on-details">
                                {if $smarty.session.kSprache === 1}
                                    {$objekt_details->name->de}
                                {else}
                                    {$objekt_details->name->en}
                                {/if}
                            </h2>
                            <span class="manifacture-type">
                                {if $smarty.session.kSprache === 1}
                                    {$objekt_details->categoryName->de}
                                {else}
                                    {$objekt_details->categoryName->en}
                                {/if}
                            </span>
                        </div>

                        <div class="d-flex rant-price-up-on-small de-border">{$translations['per_day']} <span
                                class="rant-price">
                                <span id="rant-price">
                                    {$objekt_details->price}
                                </span>
                                {$objekt_details->currency->name}
                                {if $smarty.session.kSprache === 1}
                                    {if $objekt_details->duration == 1}
                                        /Tag
                                    {elseif $objekt_details->duration == 7}
                                        /Woche
                                    {elseif $objekt_details->duration == 30}
                                        /Monat
                                    {else}
                                        /Stunde
                                    {/if}
                                {else}
                                    {if $objekt_details->duration == 1}
                                        /Day
                                    {elseif $objekt_details->duration == 7}
                                        /Week
                                    {elseif $objekt_details->duration == 30}
                                        /Month
                                    {else}
                                        /Hour
                                    {/if}
                                {/if}
                        </div>

                        <div class="de-no-border text-center"
                            style="font-size: 20px; font-weight: bold; padding-bottom: 15px;">
                            {$translations['product_details']}
                        </div>

                        <div class="de-border custom-de-border">
                            {$translations['category_name']}:
                            {if $smarty.session.kSprache === 1}
                                {$objekt_details->categoryName->de}
                            {else}
                                {$objekt_details->categoryName->en}
                            {/if}
                        </div>

                        <div class="de-border custom-de-border">
                            {$translations['color']}:
                            {if $smarty.session.kSprache === 1}
                                {$objekt_details->colorName->en}
                            {else}
                                {$objekt_details->colorName->de}
                            {/if}
                        </div>

                        <div class="de-border custom-de-border">
                            {if $smarty.session.kSprache === 1}
                                Preisdauer:
                                {if $objekt_details->duration == 1}
                                    pro Tag
                                {elseif $objekt_details->duration == 7}
                                    pro Woche
                                {elseif $objekt_details->duration == 30}
                                    pro Monat
                                {else}
                                    pro Stunde
                                {/if}
                            {else}
                                price duration:
                                {if $objekt_details->duration == 1}
                                    per day
                                {elseif $objekt_details->duration == 7}
                                    per week
                                {elseif $objekt_details->duration == 30}
                                    per month
                                {else}
                                    per hour
                                {/if}
                            {/if}
                        </div>

                        <div class="de-border custom-de-border product-short-escription">
                            {$translations['short_description']}:
                            {if $smarty.session.kSprache === 1}
                                {$objekt_details->short_description->de}
                            {else}
                                {$objekt_details->short_description->en}
                            {/if}
                        </div>
                    </div>
                </div>
            </div>


            <div class="all-car-data-and-details d-flex">
                <div class="all-details-categorize">
                    <div class="cate active" data-cate-up="Availability">
                        {$translations['availability']}
                    </div>
                    <div class="cate border-only" data-cate-up="Description">
                        {$translations['description']}
                    </div>
                    <div class="cate" data-cate-up="Fine-print">{$translations['fine_print']}</div>
                </div>

                <div class="all-description-boxes">
                    <div class="description-box-container active" data-categorize="Availability">

                        {* start work in search *}
                        <div class="container-for-features-and-search p-xs-1 p-2" data-token='{$jtl_token}'>
                            <div class="search-components-container d-flex align-content-center flex-wrap" style="gap: 10px"
                                id="datepicker">

                                <div class="d-flex flex-column flex-grow-1 container-for-search">
                                    <label for="pick-up-date"
                                        class="mb-2 font-weight-900">{$translations['pickup_date']}</label>
                                    <div class="input-group date">
                                        <input autocomplete="off" id="obj_pickup_date" type="text"
                                            class="form-control send-se-par">
                                        <span class="input-group-addon custom-adding-style"><i
                                                class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-grow-1 container-for-search">
                                    <label for="drop-off-date"
                                        class="mb-2 font-weight-900">{$translations['dropoff_date']}</label>
                                    <div class="input-group date">
                                        <input autocomplete="off" id="obj_dropoff_date" type="text"
                                            class="form-control send-se-par"><span
                                            class="input-group-addon custom-adding-style"><i
                                                class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-grow-1 container-for-search">
                                    <label for="rental-product-quantity" class="mb-2 font-weight-900">
                                        {if $smarty.session.kSprache === 1}
                                            Menge
                                        {else}
                                            Quantity
                                        {/if}
                                    </label>
                                    {* <div class="input-group form-counter choose_quantity" id="quantity-grp" role="group">
                                        <div class="input-group-prepend ">
                                            <button type="button" class="btn  btn-" aria-label="decrease quantity"
                                                data-count-down="">
                                                <span class="fas fa-minus"></span>
                                            </button>
                                        </div>
                                        <input type="number" class="form-control quantity" id="quantity" value="1" min="0"
                                            step="1" name="anzahl" aria-label="Quantity" data-decimals="0">
                                        <div class="input-group-append ">
                                            <button type="button" class="btn  btn-" aria-label="increase quantity"
                                                data-count-up="">
                                                <span class="fas fa-plus"></span>
                                            </button>
                                        </div>
                                    </div> *}
                                    <input type="number" id="rental-product-quantity" value="1" name="quantity" min="1"
                                        max="{$objekt_details->quantity}">
                                </div>
                            </div>
                        </div>
                        {* start work in search *}

                        <div class="all-car-data-tables">
                            <div class="car-table-box">
                                <h2>{$translations['summary']}</h2>

                                <p>{$translations['summary_message']}</p>

                                <table class="car-summary-table">
                                    <tr>
                                        <td class="font-table-price">{$translations['from_date']}</td>
                                        <td id="rent-from-date">
                                            {if $smarty.session.kSprache === 1}
                                                Datum wählen
                                            {else}
                                                Choose Date
                                            {/if}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-table-price">{$translations['to_date']}</td>
                                        <td class="rent-to-date">
                                            {if $smarty.session.kSprache === 1}
                                                Datum wählen
                                            {else}
                                                Choose Date
                                            {/if}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-table-price">{$translations['reservation_total']}</td>
                                        <td class="combonent-rent-price" data-cur='{$objekt_details->currency_id}'
                                            data-nam='{$objekt_details->currency->name}'
                                            data-dur='{$objekt_details->duration}' data-loc='{$objekt_details->country_id}'
                                            id="reservation-total">
                                            {if $smarty.session.kSprache === 1}
                                                Datum wählen
                                            {else}
                                                Choose Date
                                            {/if}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <input type="hidden" id="calc-product-price" data-nam='{$objekt_details->currency->name}'
                                data-dur='{$objekt_details->duration}' data-pri='{$objekt_details->price}'>

                            <!-- ============= small barrier -->

                            <div class="hidn-table-price-breakdown">
                                <p id="brice-breakdown">{$translations['show_price_breakdown']}</p>

                                <div class="brice-breakdown">
                                    <div class="car-table-box">
                                        <p>{$translations['booking_breakdown']}</p>

                                        <table class="car-break-down-table-date" id="parent-of-rent-td">
                                            <thead>
                                                <tr
                                                    style="background-color: rgba(0, 0, 0, 0.03); font-weight: bold; font-size: 18px;">
                                                    <th>{$translations['date']}</th>
                                                    <th>{$translations['price_per_date']}</th>
                                                </tr>
                                            </thead>

                                            <tbody id="all-days-descriptions">
                                                <tr>
                                                    <td colspan="2" class="text-center">
                                                        {if $smarty.session.kSprache === 1}
                                                            Es liegen keine Daten vor
                                                        {else}
                                                            There is no data
                                                        {/if}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="car-table-box">
                                        <p>{$translations['date']}</p>

                                        <table class="car-break-down-table-item">
                                            <tr
                                                style="background-color: rgba(0, 0, 0, 0.03); font-weight: bold; font-size: 18px;">
                                                <td>{$translations['item']}</td>
                                                <td>{$translations['price']}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-table-price">{$translations['to_date']}</td>
                                                <td class="font-table-price rent-to-date">
                                                    {if $smarty.session.kSprache === 1}
                                                        Datum wählen
                                                    {else}
                                                        Choose Date
                                                    {/if}
                                                </td>
                                            </tr>

                                            <tr style="font-weight: bold; font-size: 18px;">
                                                <td>{$translations['total_price']}</td>
                                                <td class="font-table-price all-total-rent-price">
                                                    {if $smarty.session.kSprache === 1}
                                                        Datum wählen
                                                    {else}
                                                        Choose Date
                                                    {/if}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ======================== small barrier -->

                        <!-- ======================== small barrier -->

                        <div class="action-button-box d-flex justify-content-between mt-5">
                            <button class="custom-search-btn custom-button-action"
                                id="reset-all-extra-item">{$translations['reset']}</button>

                            <button class="custom-search-btn custom-button-action"
                                id="rental-proceed">{$translations['proceed']}</button>
                        </div>
                    </div>

                    <!-- ======================== small barrier -->
                    <div class="description-box-container" data-categorize="Description">
                        <div class="upper-box-container">
                            <h2>
                                {if $smarty.session.kSprache === 1}
                                    Beschreibung des Produkts:
                                {else}
                                    Product Description:
                                {/if}
                            </h2>

                            <p>
                                {if $smarty.session.kSprache === 1}
                                    {$objekt_details->long_description->de}
                                {else}
                                    {$objekt_details->long_description->en}
                                {/if}
                            </p>
                        </div>
                        <!-- ======================== small barrier -->

                        <div class="lower-box-container">
                            <h2>
                                {if $smarty.session.kSprache === 1}
                                    Label:
                                {else}
                                    Etikett:
                                {/if}
                            </h2>

                            {if $objekt_details->labels|@count > 0}
                                {foreach from=$objekt_details->labels item=label}
                                    {* <p style="padding:0;"> *}
                                    <p>
                                        <span class="fi">
                                            {$label.name}
                                        </span>
                                        <span class="sec">
                                            {$label.value}
                                        </span>
                                    </p>
                                {/foreach}
                            {else}
                                {* <p style="padding:0;"> *}
                                <p>
                                    {if $smarty.session.kSprache === 1}
                                        Es liegen keine Daten vor
                                    {else}
                                        There is no data
                                    {/if}
                                </p>
                            {/if}
                        </div>
                    </div>

                    <!-- ======================== small barrier -->

                    <div class="description-box-container" data-categorize="Fine-print">
                        {assign var="priceExcludesEn" value=$objekt_details->price_excludes->en}
                        {assign var="priceExcludesArrayEn" value=","|explode:$priceExcludesEn}

                        {assign var="priceExcludesDe" value=$objekt_details->price_excludes->de}
                        {assign var="priceExcludesArrayDe" value=","|explode:$priceExcludesDe}

                        {assign var="priceIncludesEn" value=$objekt_details->price_includes->en}
                        {assign var="priceIncludesArrayEn" value=","|explode:$priceIncludesEn}

                        {assign var="priceIncludesDe" value=$objekt_details->price_includes->de}
                        {assign var="priceIncludesArrayDe" value=","|explode:$priceIncludesDe}

                        <div>
                            <h2>{$translations['reservation_includes']}</h2>
                            <ul>
                                {if $smarty.session.kSprache === 1}
                                    {if $priceIncludesArrayDe|@count > 0}
                                        {foreach from=$priceIncludesArrayDe item=item}
                                            <li>{$item}</li>
                                        {/foreach}
                                    {else}
                                        Es liegen keine Daten vor
                                    {/if}
                                {else}
                                    {if $priceIncludesArrayEn|@count > 0}
                                        {foreach from=$priceIncludesArrayEn item=item}
                                            <li>{$item}</li>
                                        {/foreach}
                                    {else}
                                        There is no data
                                    {/if}
                                {/if}
                            </ul>
                        </div>
                        <div>
                            <h2>{$translations['reservation_excludes']}</h2>
                            <ul>
                                {if $smarty.session.kSprache === 1}
                                    {if $priceExcludesArrayDe|@count > 0}
                                        {foreach from=$priceExcludesArrayDe item=item}
                                            <li>{$item}</li>
                                        {/foreach}
                                    {else}
                                        Es liegen keine Daten vor
                                    {/if}
                                {else}
                                    {if $priceExcludesArrayEn|@count > 0}
                                        {foreach from=$priceExcludesArrayEn item=item}
                                            <li>{$item}</li>
                                        {/foreach}
                                    {else}
                                        There is no data
                                    {/if}
                                {/if}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {* code here *}
    </div>
{/block}
{* 
<pre>
    {$objekt_details|print_r}
</pre> *}