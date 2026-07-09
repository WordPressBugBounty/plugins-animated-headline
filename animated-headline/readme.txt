=== Animated Headline ===
Contributors: anshuln90
Tags: animated headline, headline, shortcode, animation, text animation, gutenberg, elementor, wpbakery, animation effect, anshulg90, anshul, wordpress
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 5.0
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Animated Headline lets you add beautiful animated headline text to posts, pages, and widgets with a simple shortcode, Gutenberg block, Elementor widget, or WPBakery element.

== Description ==

Animated Headline is a lightweight and simple plugin for creating animated heading text. Keep your visitors engaged with 10 different smooth animation effects!

**New in Version 5.0:** Full Page Builder Support!
You can now add Animated Headlines easily using your favorite page builders without writing shortcodes:
* **Gutenberg Block** - Native block with live preview in the WordPress editor.
* **Elementor Widget** - Custom widget with full settings right inside Elementor.
* **WPBakery Element** - Fully integrated into the WPBakery Page Builder.

**Shortcode Example:**
`[animated-headline title="Hello my friend" animated_text="Anshul,Rahul,Niya" animation="clip" delay="2500" speed="600" tag="h2"]`

**Available Animation Effects:**
* rotate-1
* rotate-2
* rotate-3
* type
* scale
* loading-bar
* slide
* clip
* zoom
* push

**Shortcode Parameters:**
* `title`: Static text before the animation.
* `animated_text`: Comma-separated list of words to animate.
* `animation`: The animation effect (see list above).
* `delay`: (Optional) Time between word changes in milliseconds (default: 2500).
* `speed`: (Optional) Animation transition speed in milliseconds (default: 600).
* `tag`: (Optional) HTML tag for the headline e.g., h1, h2, h3, div (default: h1).

**Performance Optimized:**
CSS and JS assets are loaded conditionally! The plugin will only load its scripts on pages where the Animated Headline shortcode or block is actually used, ensuring your website stays lightning fast.

Need help generating a shortcode? Visit **Settings > Animated Headline** in your WordPress admin area to use the Live Shortcode Generator!

== Installation ==

1. Upload the `animated-headline` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the Plugins screen in WordPress.
3. Add the block/widget via Gutenberg, Elementor, WPBakery, or use the shortcode.
4. Visit **Settings > Animated Headline** for the Shortcode Generator and Live Preview.

== Frequently Asked Questions ==

= How do I use the plugin? =
Simply search for the "Animated Headline" block/widget in Gutenberg, Elementor, or WPBakery.
Alternatively, use the shortcode: `[animated-headline title="Hello my friend" animated_text="Anshul,Rahul,Nisha" animation="clip"]`

= Which animation effects are supported? =
The plugin supports rotate-1, rotate-2, rotate-3, type, scale, loading-bar, slide, clip, zoom, and push.

= Will this plugin slow down my site? =
No! Version 2.1.0 introduces performance optimizations where plugin assets (CSS/JS) only load on pages where the animated headline is actually present.

== Changelog ==

= 2.1.0 =
* FEATURE: Added native Gutenberg Block support with static preview.
* FEATURE: Added Elementor Widget support.
* FEATURE: Added WPBakery Page Builder element support.
* FEATURE: Added `delay`, `speed`, and `tag` parameters to shortcode.
* ENHANCEMENT: Massive performance upgrade. CSS and JS only load on pages where the shortcode/block is used.
* ENHANCEMENT: Completely revamped the Settings page with a Live Shortcode Generator.
* ENHANCEMENT: Added donation links.

= 1.6.0 =
* Updated compatibility metadata for WordPress 6.0+ and PHP 7.4+.
* Improved shortcode sanitization and escaping.
* Updated asset loading to use modern WordPress enqueue hooks.

= 1.5 =
* Removed some bugs.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 5.0 =
Massive update! Full support for Gutenberg, Elementor, and WPBakery, plus conditional asset loading for better performance. Settings page now includes a live shortcode generator.
