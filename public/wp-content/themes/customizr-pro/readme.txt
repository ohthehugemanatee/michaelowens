# Customizr Pro v1.0.17
> The pro version of the popular Customizr WordPress theme.

## Copyright
**Customizr Pro** is a WordPress theme designed by Nicolas Guillaume in Nice, France. ([website : Themes and Co](http://themesandco.com>)) 
Customizr Pro is distributed under the terms of the [GNU GPL v2.0 or later](http://www.gnu.org/licenses/gpl-3.0.en.html)

## Documentation and FAQs
* DOCUMENTATION : http://doc.themesandco.com/customizr-pro
* FAQs : http://doc.themesandco.com/customizr-pro/faq
* SNIPPETS : http://themesandco.com/code-snippets/
* HOOKS API : http://themesandco.com/customizr/hooks-api/

## Changelog
= 1.0.17 March 11th 2015 =
* added : customizer previewer filter for custom skins

= 1.0.16 March 9th 2015 =
* replaced in featured pages get_the_excerpt filter by the_excerpt
* fixed : tc_set_post_list_hooks hooked on wp_head. wp was too early => fixes bbpress compatibility
* improved : tc_user_options_style filter now declared in the classes constructor
* fixed : bbpress issue with single user profiles not showing up ( initially reported here : https://wordpress.org/support/topic/bbpress-problems-with-versions-avove-3217?replies=7#post-6669693 )
* fixed : better insertion of font icons and custom css in the custom inline stylesheet
* fixed : bbpress conflict with the post grid
* fixed : the_content and the_excerpt WP filters missing in post list content model
* fixed : smart load issue when .hentry class is missing (in WooCommerce search results for example)
* added : has-thumb class to the grid > figure element
* added : make the expanded class optional with a filter : tc_grid_add_expanded_class
* added : fade background effect for the excerpt in the no-thumbs grid blocks
* changed : TC_post_list_grid::tc_is_grid_enabled shifted from private to public
* improved : jqueryextLinks.js check if the tc-external element already exists before appending it
* fixed : .tc-grid-icon:before better centering

= 1.0.15 March 4th 2015 =
Fix slider img centering bug

= 1.0.14 March 4th 2015 =
Fix: array dereferencing fix for PHP<5.4.0
Fix: typos in webkit transition/transform properties

= 1.0.13 March 2nd 2015 =
* Upgraded to customizr v3.3.6
* added in Featured Pages a dynamic images centering feature as option

= 1.0.12 February 13th 2015 =
* Upgraded to customizr v3.3.1, safe for child theme users : https://github.com/Nikeo/customizr#changelog

= 1.0.11 February 13th 2015 =
* Upgraded to customizr v3.3.0, safe for child theme users
* Font Customizer : hide controls on load when they are not wrapper in zones, since wp 4.1+
* Feat. Pages Fix : use text-domain prefix for translations files
* Feat. Pages Fix : fp button display nothing if empty
* Feat. Pages Fix : perform tc_setup after_setup_theme when as addon in customizr-pro
* Feat. Pages Fix : temporary fix, don't include woocommerce products in fp
* Feat. Pages Fix : use a more proper filter to which pass the ->post_excerpt
* Feat. Pages Fix : don't retrieve already retrieved post/page object when getting the excerpt

= 1.0.10 January 23rd 2015 =
* Fix parse error due to an anonymous function syntax not supported by old version of php

= 1.0.9 January 22nd 2015 =
* Fix warning when attempting to load Google font in the admin editor

= 1.0.8 January 22nd 2015 =
* Updated to the core Customizr theme v3.2.12

= 1.0.7 December 23rd 2014 =
* Safer fix for the hidden font customizer controls. Cross browser compatible and compatible with  WP version 4.1+
* Updated to the core Customizr theme v3.2.10 : http://themesandco.com/whats-new-customizr-theme-v3-2-9/

= 1.0.6 December 21st 2014 =
* follow up of the font customizer controls not showing up. Additional delay added to init the sections

= 1.0.5 December 20th 2014 =
* 18db9f3 fix the api.reflowPaneContents bug in the font customizer

= 1.0.4 December 14th 2014 =
* b1e9173 Fix $logos_img instanciation bug in class TC_header_main#148

= 1.0.3 December 12th 2014 =
* 0402f83 fix customizr pro name to customizr-pro in config.json of FPU

= 1.0.2 December 8th 2014 =
* 9ef1370 FPU addon : fix the comment bubble bug. get_the_title() not used anymore.
* f806c18 pages with comments : enable the comment bubble after the title in headings
* 57ac308 admin css : change help buttons and icon to the new set of colors : #27CDA5 #1B8D71
* 786bbbc expand submenus for tablets in landscape mode
* d4bc5eb add a tc-is-mobile class to the body tag if wp_is_mobile()
* d3bb703 Fix the skin dropdown not closing when clicking outside the dropdown
* 094e0b2 Changed author URL to http://themesandco.com/
* c6611bb Merge branch 'eri-trabiccolo-android-menu' into dev
* d94fff6 Fix collapsed menu on android devices
* 605a462 Merge branch 'eri-trabiccolo-fp-edit-link' into dev
* 63c6aa0 Featured Pages: fix edit link
* 8e24584 Merge branch 'eri-trabiccolo-parent-menu-item' into dev
* 708b7b1 Merge branch 'eri-trabiccolo-hammer-issue' into dev
* Fix click on slide's call to action buttons in mobile devs
* 7b31410 Merge branch 'eri-trabiccolo-dev' for the sticky logo into dev
* cb77df3 add the title and notice to TC_Customize_Upload_Control
* 62bce18 add the title rendering for some control types
* 48891bb fix the $default_title_length hard coded value

= 1.0.1 December 8th 2014 =
* dd4bfe6 v1.0.1 grunt build
* 90d292e change gitignore settings
* fd10bbf setup the automatic updates and the activation key page admin
* 4b5df34 addons updates

= 1.0.0 December 6th 2014 =
* Initial release