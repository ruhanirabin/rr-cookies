<?php
/**
 * Cookie consent banner template.
 *
 * @package RR_Cookies
 */
?>
<div id="rr-cookies-banner" class="rr-cookies-banner" role="alert" aria-live="polite">
    <div class="rr-cookies-banner-content">
        <div class="rr-cookies-banner-text">
            <p></p>
            <?php if (get_privacy_policy_url()): ?>
                <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="rr-cookies-privacy-link">
                    <?php esc_html_e('Privacy Policy', 'rr-cookies'); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="rr-cookies-banner-actions">
            <button type="button" class="rr-cookies-preferences-button">
                <?php esc_html_e('Cookie Settings', 'rr-cookies'); ?>
            </button>
            <button type="button" class="rr-cookies-accept-button">
                <?php esc_html_e('Accept All', 'rr-cookies'); ?>
            </button>
        </div>
    </div>
</div>
