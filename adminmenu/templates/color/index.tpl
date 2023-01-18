{include file="../layout/tecsee_styles.tpl"}


<form class="tecSee-form" onsubmit='createColor(event)' id="create-color" method="POST" autocomplete="off"
    enctype="multipart/form-data">
    {$jtl_token}
    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Farbe Name Englisch
            {else}
                Color Name English
            {/if}
        </label>
        <input type="text" name="color_name_en"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Farbe Name Englisch{else}Color Name English{/if}"
            required>
    </div>

    <div>
        <label>
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Farbe Name Deutsch
            {else}
                Color Name German
            {/if}
        </label>
        <input type="text" name="color_name_de"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Farbe Name Deutsch{else}Color Name German{/if}"
            required>
    </div>

    <input type="submit" value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
</form>
<hr />
{if (isset($colors)) && (count($colors) > 0)}

    <div class="tecSee-table-parent">
        <div class='tecSee-table-container'>
            <div class="tecSee-remove-padding">
                <table class="tecSee-table">
                    <tr>
                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                            <th>Auswahl</th>
                            <th>id</th>
                            <th>Farbe Name Englisch</th>
                            <th>Farbe Name Deutsch</th>
                            <th>Löschen</th>
                        {else}
                            <th>select</th>
                            <th>id</th>
                            <th>Color Name English</th>
                            <th>Color Name German</th>
                            <th>delete</th>
                        {/if}
                    <tr>
                        {foreach from=$colors item=color}
                        <tr>
                            <td>
                                <button class="fas fa-edit text-dark"
                                    onclick="handleColor('{$color->id}','{$color->colorNameEN}','{$color->colorNameDE}');"></button>
                            </td>
                            <td>{$color->id}</td>
                            <td>{$color->colorNameEN}</td>
                            <td>{$color->colorNameDE}</td>
                            <td>
                                <form onsubmit="deleteColor(event,{$color->id})" action="" method="get">
                                    <input type="hidden" name="kPlugin" value="{$pluginId}">
                                    <input type="hidden" name="fetch" value="colors">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="colorId" value="{$color->id}">
                                    {$jtl_token}
                                    <button type="submit" class="btn btn-danger tecSee-button-delete"
                                        style="font-weight: bold;">
                                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                                            Löschen
                                        {else}
                                            delete
                                        {/if}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </div>
        </div>
    </div>
{/if}


<button type="button" hidden class="btn btn-info btn-lg" id="coloreditmodal" data-toggle="modal"
    data-target="#colorModal"></button>

<!--  Edit modal -->

<div class="modal fade" id="colorModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i id="close-edit-color" class="fas fa-xmark close" data-dismiss="modal">X</i>
                <h4>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        bearbeiten
                    {else}
                        Edit
                    {/if}
                </h4>
            </div>

            <div class="modal-body">
                <form class="tecSee-form" onsubmit='updateColor(event)' id="update-color" method="POST"
                    autocomplete="off" enctype="multipart/form-data">
                    {$jtl_token}

                    <input type="hidden" id="colorId" name="colorId">
                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Farbe Name Englisch
                            {else}
                                Color Name English
                            {/if}
                        </label>
                        <input type="text" id="color-en" name="color_name_en"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Farbe Name Englisch{else}Color Name English{/if}"
                            required>
                    </div>

                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Farbe Name Deutsch
                            {else}
                                Color Name German
                            {/if}
                        </label>
                        <input type="text" name="color_name_de" id="color-de"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Farbe Name Deutsch{else}Color Name German{/if}"
                            required>
                    </div>

                    <input type="submit"
                        value="{if $smarty.session.AdminAccount->language === 'de-DE'}bearbeiten{else}Edit{/if}">
                </form>
            </div>
        </div>

    </div>
</div>


<!-- Modal -->

<!--  Edit modal -->

<!-- Button trigger modal -->
<button style="display: none;" id="open-color-button" type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#modalForColorTab">
</button>

<!-- Modal -->
<div class="modal fade" id="modalForColorTab" tabindex="-1" role="dialog" aria-labelledby="modalForColorTabTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Status der Operationen
                    {else}
                        Operations Status
                    {/if}
                </h5>
                <button id="close-color-icon" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="color-message"></p>
            </div>
            <div class="modal-footer">
                <button id="close-color-button" type="button" class="btn btn-secondary" data-dismiss="modal">
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        Schließen Sie
                    {else}
                        Close
                    {/if}
                </button>
            </div>
        </div>
    </div>
</div>

{include file="./colorFooter.tpl"}