<?php
/**
 * Sanitization helper functions.
 *
 * @package RR_Cookies
 */

class RR_Cookies_Sanitizer {
    /**
     * Sanitize hex color.
     *
     * @param string $color Color to sanitize.
     * @return string
     */
    public static function sanitize_hex_color($color) {
        if ('' === $color) {
            return '';
        }

        // 3 or 6 hex digits, or the empty string.
        if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
            return $color;
        }

        return '';
    }

    /**
     * Sanitize integer within range.
     *
     * @param int $input Number to check within the range.
     * @param int $min Minimum value.
     * @param int $max Maximum value.
     * @return int
     */
    public static function sanitize_int_range($input, $min, $max) {
        $input = absint($input);
        return min(max($input, $min), $max);
    }

    /**
     * Sanitize cookie types array.
     *
     * @param array $types Cookie types to sanitize.
     * @return array
     */
    public static function sanitize_cookie_types($types) {
        $allowed_types = array('necessary', 'analytics', 'marketing');
        return array_intersect($types, $allowed_types);
    }

    /**
     * Sanitize banner position.
     *
     * @param string $position Position to sanitize.
     * @return string
     */
    public static function sanitize_banner_position($position) {
        $allowed_positions = array('top', 'bottom');
        return in_array($position, $allowed_positions) ? $position : 'bottom';
    }

    /**
     * Sanitize animation type.
     *
     * @param string $animation Animation type to sanitize.
     * @return string
     */
    public static function sanitize_animation_type($animation) {
        $allowed_animations = array('slide', 'fade');
        return in_array($animation, $allowed_animations) ? $animation : 'slide';
    }
}
