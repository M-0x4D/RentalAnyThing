{block name='results-filters-for-rental'}
    <div class="a-side-filter-container">
        <h4 class="filters-title">{$translations['more_filters']}</h4>

        <!-- ======================== small barrier -->
        <form class="radio-filters-container d-flex flex-column">
            <div class="container-for-checkbox">
                <div class="box-one">
                    <span class="title" data-filter-title='duration'>
                        {if $smarty.session.kSprache === 1}
                            Dauer
                        {else}
                            Duration
                        {/if}
                    </span>
                    <div class="checkbox-child-container">
                        <label class="container-input">
                            {if $smarty.session.kSprache === 1}
                                Stunde
                            {else}
                                Hour
                            {/if}
                            <input type="radio" name='duration' value='hour'>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container-input">
                            {if $smarty.session.kSprache === 1}
                                Tag
                            {else}
                                Day
                            {/if}
                            <input type="radio" name='duration' value='day'>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container-input">
                            {if $smarty.session.kSprache === 1}
                                Woche
                            {else}
                                Week
                            {/if}
                            <input type="radio" name='duration' value='week'>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container-input">
                            {if $smarty.session.kSprache === 1}
                                Monat
                            {else}
                                Month
                            {/if}
                            <input type="radio" name='duration' value='month'>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="box-one">
                    <span class="title" data-filter-title='price range'>{$translations['price_range']}</span>

                    <div class="checkbox-child-container">
                        <label class="container-input">0 - 49 €
                            <input type="checkbox" required name='price-range' value='0 - 49 $'>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container-input">50 - 99 €
                            <input type="checkbox" required name='price-range' value='50 - 99 $'>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container-input">100 - 149 €
                            <input type="checkbox" required name='price-range' value='100 - 149 $'>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container-input">150 - 199 €
                            <input type="checkbox" required name='price-range' value='150 - 199 $'>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container-input">200 € +
                            <input type="checkbox" required name='price-range' value='200 $ +'>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>


            <div class='parent-filters-button'>
                <input value="{$translations['reset']}" type="reset" class="custom-search-btn custom-change"
                    id="reset-rent-filters"">
            <button class=" custom-search-btn custom-change" id="fetch-on-apply"
                style="background-color: #25c6da;">{$translations['apply_filter']}</button>
            </div>
        </form>
    </div>
{/block}