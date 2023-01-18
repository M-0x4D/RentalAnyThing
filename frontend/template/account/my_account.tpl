{block name='account-my-account-account-data' append}
    {row}
        {col cols=12 lg=6 class="account-subscription"}
            {block name='account-my-account-subscription-content'}
                {card no-body=true}
                    {cardheader}
                        {block name='account-my-account-subscription-content-header'}
                            {row class="align-items-center-util"}
                                {if $smarty.session.kSprache === 1}
                                    {col}
                                        <span class="h3">
                                            {link class='text-decoration-none-util' href="{$ShopURL}/meine-vermietungen"}
                                                Meine Vermietungen
                                            {/link}
                                        </span>
                                    {/col}
                                    {col class="col-auto font-size-sm"}
                                        {link href="{$ShopURL}/meine-vermietungen"}
                                            {lang key='showAll'}
                                        {/link}
                                    {/col}
                                {else}
                                    {col}
                                        <span class="h3">
                                            {link class='text-decoration-none-util' href="{$ShopURL}/my-rentals"}
                                                My Rentals
                                            {/link}
                                        </span>
                                    {/col}
                                    {col class="col-auto font-size-sm"}
                                        {link href="{$ShopURL}/my-rentals"}
                                            {lang key='showAll'}
                                        {/link}
                                    {/col}
                                {/if}
                            {/row}
                        {/block}
                    {/cardheader}
                {/card}
            {/block}
        {/col}
    {/row}
{/block}