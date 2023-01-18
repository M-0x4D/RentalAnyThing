{block name='fetch-error-rental-message'}
    {* ============= no results found ============= *}
    <div id='no-results-found-for-rental'>
        <div class="child-div-error">
            <p class="no-results-message">
                {if $smarty.session.kSprache == 1 }
                    Keine Ergebnisse gefunden
                {else}
                    no results found
                {/if}
            </p>
        </div>
    </div>

    {* ============= error found ============= *}
    <div id='error-found-for-rental'>
        <div class="child-div-error">
            <p class="no-results-message">there was an problem <br>please try again</p>
        </div>
    </div>
{/block}