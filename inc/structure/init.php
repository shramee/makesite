<?php
/**
 * @developer shramee.me <me@shramee.me>
 */

require_once dirname( __FILE__ ) . '/framework.php';

//Slide in areas' functions
require_once dirname( __FILE__ ) . '/slides.php';
//Slide in areas' hooks
add_action( 'wp_footer',    'makesite_slide_ins', 25 );
ms_hook( 'left_slide_in',  'makesite_lsi_widgets', 25 );
ms_hook( 'right_slide_in', 'makesite_rsi_widgets', 25 );

//Header functions
require_once dirname( __FILE__ ) . '/header.php';
//Header hooks
ms_hook( 'header', 'makesite_hd_skiplinks',  20 );
ms_hook( 'header', 'makesite_hd_top_nav',  20 );
ms_hook( 'header', 'makesite_hd_right_nav',  20 );
ms_hook( 'header', 'makesite_hd_left_nav',  20 );
ms_hook( 'header', 'makesite_hd_branding',   30 );
ms_hook( 'header', 'makesite_hd_navigation', 40 );
//Desktop and mobile navs
ms_hook( 'header_desktop_nav', 'makesite_desktop_nav',     25 );
ms_hook( 'header_mobile_nav',  'makesite_mobile_nav_btn',  20 );
ms_hook( 'header_mobile_nav',  'makesite_mobile_nav',      25 );

add_filter( 'wp_nav_menu', 'ms_minify',        7 );

//Sidebar functions
require_once dirname( __FILE__ ) . '/sidebars.php';
//Sidebar hooks
ms_hook( 'sidebar',  'makesite_sb_widgets', 25 );
ms_hook( 'sidebar2', 'makesite_sb2_widgets', 25 );

//Content functions
require_once dirname( __FILE__ ) . '/content.php';
//Content hooks
ms_hook( 'content', 'makesite_ct', 25 );
ms_hook( 'content_page', 'makesite_ct_page', 25 );
ms_hook( 'content_single', 'makesite_ct_single', 25 );
ms_hook( 'content_archive', 'makesite_ct_archive', 25 );
ms_hook( 'content_search', 'makesite_ct_search', 25 );
ms_hook( 'content_404', 'makesite_ct_404', 25 );

//Footer functions
require_once dirname( __FILE__ ) . '/footer.php';
//Footer hooks
ms_hook( 'footer', 'makesite_ft_navigation', 20 );
ms_hook( 'footer', 'makesite_ft_skiplinks',  30 );
ms_hook( 'footer', 'makesite_ft_info',       40 );
