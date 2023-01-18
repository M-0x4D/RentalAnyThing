{block name='alert-component'}
    <div class="pop-up-container" id="pop-up-container">
        <div class="pop-up-content-parent">
            <div class="pop-up-content" id="pop-up-content">
                <i id="close-rental-car-popup" class="fa fa-times"></i>

                <div class="pop-up-content-child" id="pop-up-content-child">
                    <img src='/mediafiles/Resources/Photos/close.svg' class='pop-up-icon' id="pop-up-icon">

                    <div class="button-up-up">
                        <p class="pop-up-message" id='error-message-v2'>
                            {$translations['input_filed_message']}
                        </p>

                        <div>
                            <button class="pop-up-button" id="confirm-pop-up-screen"
                                style="background-color: #25c6da;">{$translations['confirm']}</button>
                            <button class="pop-up-button" id="close-pop-up-screen">{$translations['close']}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}