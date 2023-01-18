{if $smarty.server.REQUEST_URI|strstr: 'vermietung' or $smarty.server.REQUEST_URI|strstr: 'rental' or $smarty.server.REQUEST_URI|strstr: 'auto-details' or $smarty.server.REQUEST_URI|strstr: 'car-details'}
    {block name='layout-index-heading'}

    {/block}
{/if}