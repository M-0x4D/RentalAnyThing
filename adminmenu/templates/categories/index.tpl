{include file="../layout/tecsee_styles.tpl"}
<script src="{$pluginPath}js/Fiberjs/Fiber.js" type="text/javascript"></script>
<script src="{$pluginPath}js/Fiberjs/JsonParseException.js" type="text/javascript"></script>
<script src="{$pluginPath}js/Fiberjs/ResponseException.js" type="text/javascript"></script>

<form class="tecSee-form" onsubmit='createCategory(event)' id="create-category" method="POST" autocomplete="off"
    enctype="multipart/form-data">
    {$jtl_token}

    <div>
        <label for="categories_name_en">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Kategorie Name Englisch
            {else}
                Category Name English
            {/if}
        </label>
        <input id="categories_name_en" type="text" name="categories_name_en"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Kategorie Name Englisch{else}Category Name English{/if}"
            required>
    </div>

    <div>
        <label for="categories_name_de">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Kategorie Name Deutsch
            {else}
                Category Name German
            {/if}
        </label>
        <input id="categories_name_de" type="text" name="categories_name_de"
            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Kategorie Name Deutsch{else}Category Name German{/if}"
            required>
    </div>

    <input type="submit" value="{if $smarty.session.AdminAccount->language === 'de-DE'}Anzeige{else}Add{/if}">
</form>
<hr />
{if (isset($categories)) && (count($categories) > 0)}
    <div class="tecSee-table-parent">
        <div class='tecSee-table-container'>
            <div class="tecSee-remove-padding">
                <table class="tecSee-table">
                    <tr>
                        <th>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Update
                            {else}
                                Update
                            {/if}
                        </th>

                        <th>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Id
                            {else}
                                Id
                            {/if}
                        </th>

                        <th>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Kategorie Name Englisch
                            {else}
                                Category Name English
                            {/if}
                        </th>

                        <th>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Kategorie Name Deutsch
                            {else}
                                Category Name German
                            {/if}
                        </th>

                        <th>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Löschen
                            {else}
                                Delete
                            {/if}
                        </th>
                    <tr>
                        {foreach from=$categories item=category}
                        <tr>
                            <td>
                                <button class="fas fa-edit text-dark"
                                    onclick="handleCategory('{$category->id}','{$category->categoryNameEN}','{$category->categoryNameDE}');"></button>
                            </td>
                            <td>{$category->id}</td>
                            <td>{$category->categoryNameEN}</td>
                            <td>{$category->categoryNameDE}</td>
                            <td>
                                <form onsubmit="deleteCategory(event,{$category->id})" action="" method="get">
                                    <input type="hidden" name="kPlugin" value="{$pluginId}">
                                    <input type="hidden" name="fetch" value="categories">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="categoryId" value="{$category->id}">
                                    {$jtl_token}
                                    <button type="submit" class="btn btn-danger tecSee-button-delete"
                                        style="font-weight: bold;">
                                        {if $smarty.session.AdminAccount->language === 'de-DE'}
                                            Löschen
                                        {else}
                                            Delete
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


<button type="button" hidden class="btn btn-info btn-lg" id="categoryeditmodal" data-toggle="modal"
    data-target="#categoryModal"></button>

<!--  Edit modal -->

<div class="modal fade" id="categoryModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i id="close-edit-category" class="fas fa-xmark close" data-dismiss="modal">X</i>
                <h4>
                    {if $smarty.session.AdminAccount->language === 'de-DE'}
                        bearbeiten
                    {else}
                        Edit
                    {/if}
                </h4>
            </div>

            <div class="modal-body">
                <form class="tecSee-form" onsubmit='updateCategory(event)' id="update-category" method="POST"
                    autocomplete="off" enctype="multipart/form-data">
                    {$jtl_token}

                    <input type="hidden" id="categoryId" name="categoryId">
                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Kategorie Name Englisch
                            {else}
                                Category Name English
                            {/if}
                        </label>
                        <input type="text" id="category-en" name="category_name_en"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Kategorie Name Englisch{else}Category Name English{/if}"
                            required>
                    </div>

                    <div>
                        <label>
                            {if $smarty.session.AdminAccount->language === 'de-DE'}
                                Kategorie Name Deutsch
                            {else}
                                Category Name German
                            {/if}
                        </label>
                        <input type="text" name="category_name_de" id="category-de"
                            placeholder="{if $smarty.session.AdminAccount->language === 'de-DE'}Kategorie Name Deutsch{else}Category Name German{/if}"
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
<button style="display: none;" id="open-category-button" type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#modalForCategoryTab">
</button>

<!-- Modal -->
<div class="modal fade" id="modalForCategoryTab" tabindex="-1" role="dialog" aria-labelledby="modalForCategoryTabTitle"
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
                <button id="close-category-icon" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="category-message"></p>
            </div>
            <div class="modal-footer">
                <button id="close-category-button" type="button" class="btn btn-secondary" data-dismiss="modal">
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

<script src="{$pluginPath}js/categories/index.js" type="text/javascript"></script>