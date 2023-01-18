{block name='my-rental-cars'}
    <!-- start work in search-components -->
    <div id="container-for-features-and-search-my-rental"
        class="container-for-features-and-search p-xs-1 p-sm-3 px-md-3 px-lg-4 px-xl-5 py-md-1 py-lg-3 py-xl-3"
        {if isset($smarty.session.Kunde->kKunde)} data-u-i='{$smarty.session.Kunde->kKunde}' {/if}>

        <h1 class="text-center rented-title" style="font-size: 27px;">{$translations['rented_products']}</h1>

    </div>
    <!-- end work in search-components -->

    <!-- ============================================================================================================ -->

    <!-- start work in search results -->
    <div class="container-for-rentaled-results px-md-3 px-lg-4 px-xl-5 d-flex flex-wrap-reverse">
        <div class="title-and-results-rented-container d-flex flex-column">
            {if $my_rentals|@count > 0}
                <div class="title-box d-flex justify-content-between align-items-center">
                    <h3 class="child-header-parent">{$translations['sort_by']}</h3>

                    <div class="price-filter d-flex">
                        <span class="text-box">{$translations['date']}</span>

                        <div class="icon-box d-flex flex-column align-items-center">
                            <i class="fas fa-caret-up sort-rent-by-date" date-rent-filter='ASC'></i>
                            <i class="fas fa-caret-down sort-rent-by-date" date-rent-filter='DESC'></i>
                        </div>

                    </div>

                    <div class="view-type-icons-parent d-flex">
                        <span class="icon-up" id="table-view"><i class="fas fa-table"></i></span>
                        <span class="icon-up active" id="list-view"><i class="fas fa-list"></i></span>
                    </div>
                </div>
                <!-- ======================== small barrier -->

                {* <pre>
                    {$my_rentals|print_r}
                </pre> *}

                <div class="results-container d-flex flex-wrap" id="results-container">
                    {foreach from=$my_rentals item=my_rental}
                        <div class="result-box d-flex flex-wrap">
                            <div class="img-box">
                                <img src="{$my_rental->imagePath}" alt="">
                            </div>

                            <div class="car-details d-flex">
                                <div class="main-details d-flex flex-column justify-content-around">
                                    <div class="one-up d-flex flex-column">
                                        {* <p class="car-details"> *}
                                        <p>
                                            {if $smarty.session.kSprache === 1}
                                                {$my_rental->name->de}
                                            {else}
                                                {$my_rental->name->en}
                                            {/if}
                                        </p>
                                    </div>
                                    <div class="all-icon-box">
                                        {if $smarty.session.kSprache === 1}
                                            <i class="fa fa-bars" aria-hidden="true"></i> {$my_rental->categoryName->de} -
                                            <i class="fa fa-map" aria-hidden="true">
                                            </i> {$my_rental->countryName->de} - {$my_rental->governrateName->de} -
                                            {$my_rental->cityName->de}
                                        {else}
                                            <i class="fa fa-bars" aria-hidden="true"></i> {$my_rental->categoryName->en} -
                                            <i class="fa fa-map" aria-hidden="true"></i> {$my_rental->countryName->en} -
                                            {$my_rental->governrateName->en} - {$my_rental->cityName->en}
                                        {/if}
                                    </div>

                                    <div>
                                        <p>
                                            {if $smarty.session.kSprache === 1}
                                                Beschreibung: {$my_rental->short_description->de}
                                            {else}
                                                Description: {$my_rental->short_description->en}
                                            {/if}
                                        </p>
                                    </div>

                                    <div>
                                        <p>
                                            {if $smarty.session.kSprache === 1}
                                                Menge: {$my_rental->quantity}
                                            {else}
                                                Quantity: {$my_rental->quantity}
                                            {/if}
                                        </p>
                                    </div>

                                    <div>
                                        <p>
                                            {if $smarty.session.kSprache === 1}
                                                Farbe: {$my_rental->colorName->de}
                                            {else}
                                                Color: {$my_rental->colorName->en}
                                            {/if}
                                        </p>
                                    </div>

                                    <div class="rant-price d-flex rant-price-up-on-small">{$translations['pickup_date']}:
                                        {$my_rental->pickup_date}
                                        <br>
                                        {$translations['dropoff_date']}: {$my_rental->dropoff_date}
                                        <br>
                                        {if $smarty.session.kSprache === 1}
                                            Dauerpreis:
                                            {if $my_rental->duration == 1}
                                                pro Tag
                                            {elseif $my_rental->duration == 7}
                                                pro Woche
                                            {elseif $my_rental->duration == 30}
                                                pro Monat
                                            {else}
                                                pro Stunde
                                            {/if}
                                        {else}
                                            duration price:
                                            {if +$my_rental->duration === 1}
                                                per day
                                            {elseif +$my_rental->duration === 7}
                                                per week
                                            {else if +$my_rental->duration === 30}
                                                per month
                                            {else}
                                                per hour
                                            {/if}
                                        {/if}
                                    </div>
                                </div>

                                <div class="book-price d-flex flex-column align-items-center justify-content-around">
                                    <div class="d-flex flex-column rant-price-up">{$translations['total_cost']}
                                        <span class="rant-price">
                                            {$my_rental->total_amount} {$my_rental->currencyCode}
                                        </span>
                                    </div>

                                    {if $my_rental->rental_status === 'Pending'}
                                        <p style="margin-bottom: 0; font-size: 18px; font-weight: bold;">
                                            {if $smarty.session.kSprache === 1}
                                                Ausstehend
                                            {else}
                                                Pending
                                            {/if}
                                        </p>
                                    {elseif $my_rental->rental_status ==='APPROVED'}
                                        <p style="margin-bottom: 0; font-size: 18px; font-weight: bold;">
                                            {if $smarty.session.kSprache === 1}
                                                Genehmigt
                                            {else}
                                                Approved
                                            {/if}
                                        </p>
                                    {/if}

                                    {if $my_rental->rental_status === 'Pending'}
                                        <a style="text-align: center; text-decoration: none; font-size: 12px; margin: 0; width: 130px;"
                                            href="{$my_rental->link}" class="car-rent-on-click">{$translations['complete_payment']}</a>
                                    {/if}
                                </div>
                            </div>
                        </div>


                    {/foreach}
                {else}
                    <p class="no-resaults-for-rent">
                        <span>{$translations['no-resaults-for-rent-1']}</span> <br>
                        <span>{$translations['no-resaults-for-rent-2']}</span>
                    </p>
                {/if}
            </div>
        </div>
    </div>
    <!-- end work in search results -->
    <!-- ============================================================================================================ -->
{/block}