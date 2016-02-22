=== MP Stacks + PostGrid ===
Contributors: johnstonphilip
Donate link: http://mintplugins.com/
Tags: message bar, header
Requires at least: 3.5
Tested up to: 4.4
Stable tag: 1.0.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add-On Plugin for MP Stacks which shows a grid of Posts in a Brick. Set the source of posts to a category or tag, set the number of posts per row, featured image size, title and excerpt colours and sizes, or show just images, or just text - or both!

== Description ==

Extremely simple to set up - allows you to show posts on any page, at any time, anywhere on your website. Just put make a brick using “MP Stacks”, put the stack on a page, and set the brick’s Content-Type to be “PostGrid”.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the 'mp-stacks-postgrid’ folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Build Bricks under the “Stacks and Bricks” menu. 
4. Publish your bricks into a “Stack”.
5. Put Stacks on pages using the shortcode or the “Add Stack” button.

== Frequently Asked Questions ==

See full instructions at http://mintplugins.com/doc/mp-stacks

== Screenshots ==


== Changelog ==

= 1.0.2.0 = February 21, 2016
* Added Google Font Control to all Grid Text items

= 1.0.1.9 = November 4, 2015
* Remove Font Awesome and use MP Stacks's version
* Added "Load From Scratch" Isotope Filter support
* Added filter for the postgrid's title output "mp_stacks_postgrid_title".

= 1.0.1.8 = September 24, 2015
* Posts per row are now passed through the mp_stacks_grid_posts_per_row_percentage function.

= 1.0.1.7 = September 22, 2015
* Removed 'hentry' from postgrid posts. Some themes use this class to add extra styling - which is properly done by the postgrid CSS controls.

= 1.0.1.6 = September 20, 2015
* Front End Scripts now enqueued only when needed.
* Added jQuery namespace for animations.
* Admin Meta Scripts now enqueued only when needed.
* Brick Metabox controls now load using ajax.

= 1.0.1.5 = May 31, 2015
* Added brick ID to permalink filter (mp_stacks_postgrid_grid_post_permalink) for context
* Added filter for CSS Classes for postgrid links called (mp_stacks_postgrid_grid_postlink_classes). This allows them to do things like open in lightboxes using a custom filter. For more information on proper usage please visit: https://mintplugins.com/support/how-to-use-postgrid-for-other-post-types/

= 1.0.1.4 = May 30, 2015
* Make postgrid css Add to any existing css filtered to mp_brick_additional_css - previousl to this release it overwrote any incoming CSS.
* Changed the way we check if the PHP session exists by seeing is isset( $_SESSION ). Older versions of PHP seemed to have trouble with this.
* Added filter for PostGrid grid items permalink called "mp_stacks_postgrid_grid_post_permalink".

= 1.0.1.3 = May 12, 2015
* Added orderby options.

= 1.0.1.2 = May 9, 2015
* Added filter to allow more isotope taxonomies
* Removed old, duplicate masonry option

= 1.0.1.1 = May 3, 2015
* Changed session_start check to be strict.
* Updated plugin installer in-sync with latest in mp_core

= 1.0.1.0 = April 29, 2015
* Set a proper default for the 'postgrid_featured_images_show' option and used mp_core_get_post_meta_checkbox for displaying.

= 1.0.0.9 = April 24, 2015
* Added taxonomy filters so postgrid can be used for other post types
* Added Isotope Filtering Controls.

= 1.0.0.8 = March 1, 2015
* Made defaults more accurate to coincide with efficiency changes in mp_core.
* Post Bg Controls Added
* Spacing between text items added
* Velocity JS updated to use velocity.min.js instead of jquery.velocity.min.js in MP_CORE.
* Multiple taxonomy terms added. You can now choose multiple sources for the grid.
* Related Posts option added.
* Better line height presets set for titles and excerpts.
* Added max-width option for grid images.

= 1.0.0.7 = January 30, 2015
* Date format added: uses WordPress's date_format option.
* Alt tags added to featured images

= 1.0.0.6 = January 9, 2015
* Big overhaul to have better meta options, and use MP Stacks grid functions.
* This release coincides with MP Stacks 1.0.1.4  

= 1.0.0.5 = Aug 1, 2014
* Options added for animation, placement of text, text backgrounds
* Changed post grid choices to only include post categories for the sake of simplicity
* Ajax Load More button now changes to “Loading..” when clicked

= 1.0.0.4 = June 8, 2014
* Mobile Sizing
* Only create metabox if current screen is mp_brick

= 1.0.0.3 = May 20, 2014
* Additional options for colours, text sizing, and post spacing
* Ajax “Load More” button added
* Move To Mint 

= 1.0.0.2 = February 20, 2014
* Change postgrid to free plugin 

= 1.0.0.1 = February 10, 2014
* Changed hook for metabox to be after taxonomies are created - so we can choose from ALL taxonomies. From 'plugins_loaded' to 'widgets_init'.

= 1.0.0.0 = February 9, 2014
* Original release
