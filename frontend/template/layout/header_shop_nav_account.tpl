{block name='layout-header-shop-nav-account-logged-in' prepend}
    {if (isset($smarty.session.Kunde->kKunde))}
        {if $smarty.session.kSprache === 1}
            {dropdownitem href="{$ShopURL}/meine-vermietungen"}
                Meine Vermietungen
            {/dropdownitem}
        {else}
            {dropdownitem href="{$ShopURL}/my-rentals"}
                My Rentals
            {/dropdownitem}
        {/if}
    {/if}
{/block}