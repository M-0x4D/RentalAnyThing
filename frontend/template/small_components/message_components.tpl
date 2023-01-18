{block name='error-component'}
    <div class="pop-up-container" id="error-message-pop-up-container">
        <div class="pop-up-content-parent">
            <div class="pop-up-content" id="error-message-pop-up-content">
                <i id="error-message-pop-up-icon" class="close-rental-car-popup fa fa-times"></i>

                <div class="pop-up-content-child" id="pop-up-content-child">
                    <img src='/mediafiles/Resources/Photos/close.svg' class='pop-up-icon'>

                    <div class="button-up-up">
                        <p class="pop-up-message" id='error-message-message'>
                            {$translations['input_filed_message']}
                        </p>

                        <div>
                            <button class="pop-up-button" id="error-message-pop-up-button">{$translations['close']}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}