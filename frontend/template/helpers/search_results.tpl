{block name='search-results-container'}
    <!-- start work in search results -->
    <div class="parent-for-container-search-results" id="parent-for-container-search-results">
        <div class="container-for-search-results px-md-3 px-lg-4 px-xl-5 d-flex flex-wrap-reverse"
            id="container-for-search-results">
            <div class="title-and-results-container d-flex flex-column">

                <p class='no-resaults-for-rent'>
                    <span>{$translations['no-resaults-for-rent-1']}</span> <br>
                    <span>{$translations['no-resaults-for-rent-2']}</span>
                </p>

                <div class="d-flex flex-column messaga-and-car-boxes">
                    <div class="title-box d-flex justify-content-between align-items-center">
                        <h3 class="child-header-parent">{$translations['sort_by']}</h3>

                        <div class="price-filter d-flex">
                            <span class="text-box">{$translations['price']}</span>

                            <div class="icon-box d-flex flex-column align-items-center">
                                <i class="fa fa-caret-up" id="expensive-price-filter"></i>
                                <i class="fa fa-caret-down" id="cheap-price-filter"></i>
                            </div>

                        </div>

                        <div class="view-type-icons-parent d-flex">
                            <span class="icon-up" id="table-view"><i class="fas fa-table"></i></span>
                            <span class="icon-up active" id="list-view"><i class="fas fa-list"></i></span>
                        </div>
                    </div>

                    <!-- ======================== small barrier -->

                    <div class="results-container d-flex flex-wrap" id="results-container"
                        {if (isset($smarty.session.Kunde->kKunde))} data-customerId="{$smarty.session.Kunde->kKunde}" 
                        {else}
                        data-customerId="no-login" {/if}>
                        {* ================ boxes will genrate from js after search ================ *}
                    </div>
                </div>
            </div>

            <!-- ======================== small barrier -->
            {* start include filters *}
            {include file="../small_components/rental_filters.tpl"}
            {* end include filters *}
        </div>
    </div>

    {* =============================================================== *}

    {* start include error message *}
    {include file="../small_components/fetch_error_rental_message.tpl"}
    {* end include error message *}
    <!-- end work in search results -->
{/block}