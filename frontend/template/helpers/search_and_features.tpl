{block name='search-and-features-container'}
    <form class="container-for-features-and-search p-xs-1 p-sm-3 px-md-3 px-lg-4 px-xl-5 py-md-2 py-lg-3 py-xl-3"
        data-token='{$jtl_token}'>

        <h2 class="fea-title">{$translations['find_product']}</h2>

        <div class="search-components-container align-items-center d-flex align-content-center flex-wrap" style="gap: 10px"
            id="datepicker">
            <div class="d-flex flex-column flex-grow-1 container-for-search">
                <label for="category" class="mb-2 font-weight-900">* {$translations['category']}</label>
                <div class="input-group date">
                    <select required name="category" id="category" class="custom-select-location send-se-par">
                        <option disabled selected value="">{$translations['category']}</option>
                        {foreach from=$categories item=category}
                            <option value="{$category->id}">{$category->categoryNameEN}</option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <div class="d-flex flex-column flex-grow-1 container-for-search">
                <label for="pick-up-date" class="mb-2 font-weight-900">* {$translations['pickup_date']}</label>
                <div class="input-group date">
                    <input required type="text" class="form-control send-se-par date-search">
                    <span class="input-group-addon custom-adding-style"><i class="fas fa-calendar-alt"></i></span>
                </div>
            </div>

            <div class="d-flex flex-column flex-grow-1 container-for-search">
                <label for="drop-off-date" class="mb-2 font-weight-900">* {$translations['dropoff_date']}</label>
                <div class="input-group date">
                    <input required type="text" class="form-control send-se-par date-search"><span
                        class="input-group-addon custom-adding-style"><i class="fas fa-calendar-alt"></i></span>
                </div>
            </div>

            <div class="d-flex flex-column flex-grow-1 container-for-search">
                <label for="pick-up-country" class="mb-2 font-weight-900">*
                    {if $smarty.session.kSprache === 1}
                        Land wählen
                    {else}
                        Choose Country
                    {/if}
                </label>
                <div>
                    <select required name="pick-up-country" id="pick-up-country" class="custom-select-location send-se-par">
                        {if $countries|@count > 0}
                            {if $smarty.session.kSprache === 1}
                                <option value="" selected disabled>Land wählen</option>
                            {else}
                                <option value="" selected disabled>Choose country</option>
                            {/if}
                            {foreach from=$countries item=country}
                                {if $smarty.session.kSprache === 1}
                                    <option value="{$country->id}">{$country->name->en}</option>
                                {else}
                                    <option value="{$country->id}">{$country->name->de}</option>
                                {/if}
                            {/foreach}
                        {else}
                            <option value="" selected disabled>
                                {if $smarty.session.kSprache === 1}
                                    Land zuerst hinzufügen
                                {else}
                                    Add Country First
                                {/if}
                            </option>
                        {/if}
                    </select>
                </div>
            </div>

            <div class="d-flex flex-column flex-grow-1 container-for-search">
                <label for="pick-up-gouvernement" class="mb-2 font-weight-900">
                    {if $smarty.session.kSprache === 1}
                        Wählen Sie ein Gouvernement
                    {else}
                        Choose Governorate
                    {/if}
                </label>
                <div>
                    <select name="pick-up-governorate" id="pick-up-governorate"
                        class="custom-select-location send-se-par">
                        <option value="" selected disabled>
                            {if $smarty.session.kSprache === 1}
                                Wählen Sie zuerst das Land
                            {else}
                                Choose Country First
                            {/if}
                        </option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-column flex-grow-1 container-for-search">
                <label for="pick-up-city" class="mb-2 font-weight-900">
                    {if $smarty.session.kSprache === 1}
                        Stadt wählen
                    {else}
                        Choose City
                    {/if}
                </label>
                <div>
                    <select name="pick-up-city" id="pick-up-city" class="custom-select-location send-se-par">
                        <option value="" selected='selected' disabled='disabled'>
                            {if $smarty.session.kSprache === 1}
                                Wählen Sie zuerst Land und Gouvernement
                            {else}
                                Choose Country And governorate First
                            {/if}
                        </option>
                    </select>
                </div>
            </div>

            <button class="custom-search-btn btn-custom" id='send-se-par'>{$translations['search']}</button>
        </div>

        <!-- start work in features -->
        <div class="features-title-and-content">
            <h2 class="fea-title">{$translations['features']}</h2>

            <div class="features-box-container d-flex flex-wrap">
                <div class="fea-box d-flex">
                    <div class="icon-parent d-flex align-items-center justify-content-center">
                        <i class="fas fa-check"></i>
                    </div>

                    <p class="fea-desc">{$translations['first_feature']}</p>
                </div>

                <div class="fea-box d-flex">
                    <div class="icon-parent d-flex align-items-center justify-content-center">
                        <i class="fas fa-check"></i>
                    </div>

                    <p class="fea-desc">{$translations['second_feature']}</p>
                </div>

                <div class="fea-box d-flex">
                    <div class="icon-parent d-flex align-items-center justify-content-center">
                        <i class="fas fa-check"></i>
                    </div>

                    <p class="fea-desc">{$translations['third_feature']}</p>
                </div>
            </div>
        </div>
        <!-- end work in features -->
    </form>
{/block}