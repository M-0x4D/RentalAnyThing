{block name='layout-header-top-bar-cms-pages' append}
    {include file="./Licenses/layout.tpl"}  
    <li class='nav-item'>
        {if $smarty.session.kSprache === 2}
            <a class='nav-link' href='{$ShopURL}/rental'>rental</a>
        {else}
            <a class='nav-link' href='{$ShopURL}/vermietung'>vermietung</a>
        {/if}
    <li>
{/block}