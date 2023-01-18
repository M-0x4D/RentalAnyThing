<!-- Button trigger modal -->
<button style="display: none;" id="open-translations-button" type="button" class="btn btn-primary" data-toggle="modal"
    data-target="#modalForTranslations">
</button>

<!-- Modal -->
<div class="modal fade" id="modalForTranslations" tabindex="-1" role="dialog"
    aria-labelledby="modalForImageTranslationsTitle" aria-hidden="true">
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
                <button id="close-translations-icon" type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="translations-message"></p>
            </div>
            <div class="modal-footer">
                <button id="close-translations-button" type="button" class="btn btn-secondary" data-dismiss="modal">
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