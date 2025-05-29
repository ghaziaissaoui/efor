<div class="gs-container u-margin-b-5">
    <div
        class="<?= SENDIFY_SLUG ?>-optin-form"
        data-double-optin="<?php echo $attributes['double_optin'] ?>"
        data-list="<?php echo $attributes['list'] ?>"
    >
        <?php do_action(SENDIFY_SLUG . '_optin_form_before_wrapper'); ?>
        <div class="<?= SENDIFY_SLUG ?>-optin-form__wrapper">
            <?php do_action(SENDIFY_SLUG . '_optin_form_before_input'); ?>
            <label>
                <input
                    class="<?= SENDIFY_SLUG ?>-optin-form__input"
                    placeholder="<?php echo $attributes['placeholder'] ?>"
                    type="email"
                />
            </label>
            <?php do_action(SENDIFY_SLUG . '_optin_form_after_input'); ?>
            <button type="button" class="<?= SENDIFY_SLUG ?>-optin-form__button">
                <?php echo apply_filters(SENDIFY_SLUG . '_optin_form_submit_text', $attributes['button_text']); ?>
            </button>
        </div>
        <?php do_action(SENDIFY_SLUG . '_optin_form_after_wrapper'); ?>
    </div>
</div>
