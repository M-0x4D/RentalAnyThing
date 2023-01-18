{block name='main-car-banner-container'}
    <div class="car-main-banner d-flex">
        <div class="banner-car-img-container">
            {if isset($banner) && !!$banner}
                <img src='{$banner}' class="main-banner-img">
            {else}
                <img src='/mediafiles/Resources/Photos/car-visual.svg' class="main-banner-img">
            {/if}
        </div>

        <div class="banner-text-container">
            <div class="child-text-div">

                <h1>{$translations['header']}</h1>
                <div class="banner-buttons-container">
                    {if isset($smarty.session.Kunde->kKunde)}
                        {if $smarty.session.kSprache === 2}
                            <a class='mt-2 custom-search-btn' href='{$ShopURL}/my-rentals'>My Rentals</a>
                        {else}
                            <a class='mt-2 custom-search-btn' href='{$ShopURL}/meine-vermietungen'>Meine Vermietungen</a>
                        {/if}
                    {/if}
                </div>
            </div>
        </div>
    </div>
{/block}