<h2 class="plugin-translation trainer-name">
    {if $smarty.session.AdminAccount->language === 'de-DE'}
        Plugin-Übersetzung
    {else}
        Plugin Translation
    {/if}
</h2>

<hr />

<form class="tecSee-form" id="translation-key" method="POST" autocomplete="off" enctype="multipart/form-data">
    <div>
        <label for="key">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                Schlüsselsprache
            {else}
                Key Language
            {/if}
        </label>

        <select name="lang" id="chooseLanguage">
            <option value="" selected disabled>Choose Language</option>
            <option value="en">
                {if $smarty.session.AdminAccount->language === 'de-DE'}
                    Englisch
                {else}
                    English
                {/if}
            </option>
            <option value="de">
            {if $smarty.session.AdminAccount->language === 'de-DE'}
                German
            {else}
                Deutsch
            {/if}
            </option>
        </select>
    </div>
</form>