<?php ?>
<div class="gdfrm-review-notice">
    <div class="gdfrm-first-col">
    </div>
    <div class="gdfrm-second-col">
        <div>
            <?php _e('Your opinion matters! Leave a Review!', GDFRM_TEXT_DOMAIN); ?>
        </div>
        <div>
            <?php _e('We hope you’ve enjoyed using GrandWP Forms plugin! Would you consider leaving us a review on WordPress?', GDFRM_TEXT_DOMAIN); ?>
        </div>
        <div>
            <ul>
                <li>
                    <a href="https://wordpress.org/support/plugin/easy-contact-form-builder/reviews#new-post"
                       target="_blank"><?php _e('Sure!', GDFRM_TEXT_DOMAIN); ?></a>
                </li>
                <li>
                    <a href="<?php echo add_query_arg('gdform_ignore_notice', 'true'); ?>"><?php _e('Already Left :)', GDFRM_TEXT_DOMAIN); ?></a>
                </li>
                <li>
                    <a href="<?php echo add_query_arg('gdform_delay_notice', 'true'); ?>"><?php _e('Maybe Later', GDFRM_TEXT_DOMAIN); ?></a>
                </li>
                <li>
                    <a href="<?php echo add_query_arg('gdform_ignore_notice', 'true'); ?>"><?php _e('Don\'t Show This!', GDFRM_TEXT_DOMAIN); ?></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="gdfrm-third-col">
        <img src="<?php echo GDFRM_IMAGES_URL . 'grandwp-bg.png'; ?>"/>
    </div>
</div>