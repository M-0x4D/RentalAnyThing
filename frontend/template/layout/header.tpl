{* {if $smarty.server.REQUEST_URI|strstr: 'vermietung' or $smarty.server.REQUEST_URI|strstr: 'rental' or $smarty.server.REQUEST_URI|strstr: 'produkt-details' or $smarty.server.REQUEST_URI|strstr: 'product-details' or $smarty.server.REQUEST_URI|strstr: 'meine-vermietungen' or $smarty.server.REQUEST_URI|strstr: 'my-rentals'}
    {block name='layout-header-content-wrapper-starttag'}
    <div style="padding-top: 0;" id="content-wrapper" class="{if ($Einstellungen.template.theme.left_sidebar === 'Y' && $boxesLeftActive) || $smarty.const.PAGE_ARTIKELLISTE === $nSeitenTyp}has-left-sidebar container-fluid container-fluid-xl{/if}
            {if $smarty.const.PAGE_ARTIKELLISTE === $nSeitenTyp}is-item-list{/if}
                {if $isFluidBanner || $isFluidSlider} has-fluid{/if}">
    {/block}

    {block name='layout-header-content-starttag'}
        <div id="content" style="padding-bottom: 0;">
    {/block}

    {block name='layout-header-breadcrumb'}
    {/block}
{/if} *}

{*categories*}
{block name='layout-header-include-include-categories-header' append}
    <div style="padding-left: 1rem; padding-right: 1rem;" class="plugin-link-sm">
        <div>
            {if $smarty.session.kSprache === 2}
                <a class='pl-0 nav-link' href='{$ShopURL}/rental'>rental</a>
            {else}
                <a class='pl-0 nav-link' href='{$ShopURL}/vermietung'>vermietung</a>
            {/if}
        </div>
        <hr class="mt-0 mb-0 nav-mobile-header-hr" />
    </div>
{/block}