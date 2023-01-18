{block name='rental-products'}
    {* <pre>
            {$smarty.session.objects|print_r}
            </pre> *}

    {if +$smarty.session.objects|@count > 0}
        {if $smarty.session.kSprache === 1}
            <h2>Vermietete Produkte</h2>
        {else}
            <h2>Rental Products</h2>
        {/if}

        {foreach from=$smarty.session.objects item=object}
            <div class="row cart-items-body type-1">
                <div class="col cart-items-image col-xl-2 col-3">
                    <a href="{$object->productLink}">
                        <img src="{$object->imagePath}" srcset="{$object->imagePath}" data-srcset="{$object->imagePath}"
                            class="img-fluid w-100 ls-is-cached lazyloaded">
                    </a>
                </div>

                <div class="col ml-auto-util col-xl-9 col-9">
                    {* <a href="{$object->productLink}" class="cart-items-name"> *}
                    <span class="cart-items-name">
                        {if $smarty.session.kSprache === 1}
                            {$object->name->de}
                        {else}
                            {$object->name->en}
                        {/if}
                    </span>
                    <ul class="list-unstyled">
                        <li>
                            {if $smarty.session.kSprache === 1}
                                <i class="fa fa-bars" aria-hidden="true"></i> {$object->categoryName->de} -
                                <i class="fa fa-map" aria-hidden="true">
                                </i> {$object->countryName->de} - {$object->governrateName->de} -
                                {$object->cityName->de}
                            {else}
                                <i class="fa fa-bars" aria-hidden="true"></i> {$object->categoryName->en} -
                                <i class="fa fa-map" aria-hidden="true"></i> {$object->countryName->en} -
                                {$object->governrateName->en} - {$object->cityName->en}
                            {/if}
                        </li>

                        <li class="shortdescription">
                            {if $smarty.session.kSprache === 1}
                                {$object->short_description->de}
                            {else}
                                {$object->short_description->en}
                            {/if}
                        </li>

                        <li class="shortdescription">
                            {if $smarty.session.kSprache === 1}
                                Datum der Abholung: {$object->pickupDate}
                            {else}
                                Pick Up Date: {$object->pickupDate}
                            {/if}
                        </li>

                        <li class="shortdescription">
                            {if $smarty.session.kSprache === 1}
                                Abgabedatum: {$object->dropoffDate}
                            {else}
                                Drop Off Date: {$object->dropoffDate}
                            {/if}
                        </li>

                        <li class="shortdescription">
                            <strong>
                                {if $smarty.session.kSprache === 1}
                                    Menge: {$object->quantity}
                                {else}
                                    Quantity: {$object->quantity}
                                {/if}
                            </strong>
                        </li>

                        <li class="shortdescription">
                            <strong>
                                {if $smarty.session.kSprache === 1}
                                    Preis: {$object->price} {$object->currencyCode}
                                {else}
                                    Price: {$object->price} {$object->currencyCode}
                                {/if}
                            </strong>
                        </li>

                        <li class="shortdescription">
                            {if $smarty.session.kSprache === 1}
                                Dauer Preis: {$object->price}
                            {else}
                                Duration Price: {$object->price}
                            {/if}

                            {if $smarty.session.kSprache === 1}
                                {if $object->duration == 1}
                                    pro Tag
                                {elseif $object->duration == 7}
                                    pro Woche
                                {elseif $object->duration == 30}
                                    pro Monat
                                {else}
                                    pro Stunde
                                {/if}
                            {else}
                                {if +$object->duration === 1}
                                    per day
                                {elseif +$object->duration === 7}
                                    per week
                                {else if +$object->duration === 30}
                                    per month
                                {else}
                                    per hour
                                {/if}
                            {/if}
                        </li>
                    </ul>
                </div>

                <div class="col cart-items-price price-col col-xl-9 col-9" style="text-align:left">
                    <strong class="">
                        {if $smarty.session.kSprache === 1}
                            Gesamtpreis
                        {else}
                            Total Price
                        {/if}:</strong>
                    <span class="price_overall text-accent">
                        {$object->totalPrice} {$object->currencyCode}
                    </span>
                </div>

                <div class="col cart-items-delete col-xl-10 col-9" data-toggle="product-actions">
                    <a href="{$object->paypalLink}">
                        {if $smarty.session.kSprache === 1}
                            Paypal-Link
                        {else}
                            paypal link
                        {/if}
                    </a>

                    <button class="btn cash-on-deliver-button droppos btn-link btn-sm" data-id='{$object->id}'>
                        {if $smarty.session.kSprache === 1}
                            Nachnahme
                        {else}
                            Cash On Deliver
                        {/if}
                    </button>

                    <button class="btn cart-items-delete-button droppos btn-link btn-sm session-remove-product"
                        data-id='{$object->id}' data-quantity='{$object->quantity}'>
                        <span class="fas fa-trash-alt"></span>
                        {if $smarty.session.kSprache === 1}
                            entfernen
                        {else}
                            Remove
                        {/if}
                    </button>
                </div>

                <div class="col  col-12">
                    <hr>
                </div>
            </div>
        {/foreach}
    {/if}
{/block}