<?php
/**
 * Cookie preferences modal template.
 *
 * @package RR_Cookies
 */
?>
<div id="rr-cookies-preferences" class="rr-cookies-preferences" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="rr-cookies-preferences-content">
        <div class="rr-cookies-preferences-header">
            <h2><?php esc_html_e('Cookie Preferences', 'rr-cookies'); ?></h2>
            <button type="button" class="rr-cookies-preferences-close" aria-label="<?php esc_attr_e('Close', 'rr-cookies'); ?>">×</button>
        </div>
        
        <div class="rr-cookies-preferences-body">
            <div class="rr-cookies-preference-group">
                <div class="rr-cookies-preference-item">
                    <label class="rr-cookies-switch">
                        <input type="checkbox" checked disabled>
                        <span class="rr-cookies-slider"></span>
                    </label>
                    <div class="rr-cookies-preference-info">
                        <h3><?php esc_html_e('Necessary', 'rr-cookies'); ?></h3>
                        <p><?php esc_html_e('Necessary cookies are essential for the website to function properly.', 'rr-cookies'); ?></p>
                    </div>
                </div>

                <div class="rr-cookies-preference-item">
                    <label class="rr-cookies-switch">
                        <input type="checkbox" name="analytics">
                        <span class="rr-cookies-slider"></span>
                    </label>
                    <div class="rr-cookies-preference-info">
                        <h3><?php esc_html_e('Analytics', 'rr-cookies'); ?></h3>
                        <p><?php esc_html_e('Analytics cookies help us understand how visitors interact with the website.', 'rr-cookies'); ?></p>
                    </div>
                </div>

                <div class="rr-cookies-preference-item">
                    <label class="rr-cookies-switch">
                        <input type="checkbox" name="marketing">
                        <span class="rr-cookies-slider"></span>
                    </label>
                    <div class="rr-cookies-preference-info">
                        <h3><?php esc_html_e('Marketing', 'rr-cookies'); ?></h3>
                        <p><?php esc_html_e('Marketing cookies are used to track visitors across websites to display relevant advertisements.', 'rr-cookies'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rr-cookies-preferences-footer">
            <button type="button" class="rr-cookies-save-preferences">
                <?php esc_html_e('Save Preferences', 'rr-cookies'); ?>
            </button>
        </div>
    </div>
</div>
