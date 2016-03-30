<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */

include dirname( __FILE__ ) . '/framework.php';

//Header functions
include dirname( __FILE__ ) . '/header.php';
//Header hooks
ms_hook( 'header', 'makesite_hd_skiplinks',  20 );
ms_hook( 'header', 'makesite_hd_branding',   30 );
ms_hook( 'header', 'makesite_hd_navigation', 40 );

ms_hook( 'header_navs', 'makesite_hd_navs',  25 );

ms_hook( 'header_desktop_nav', 'makesite_desktop_nav',     25 );
ms_hook( 'header_mobile_nav',  'makesite_mobile_nav_btn',  20 );
ms_hook( 'header_mobile_nav',  'makesite_mobile_nav',      25 );

add_filter( 'wp_nav_menu', 'ms_minify_html',        7 );

//Sidebar functions
include dirname( __FILE__ ) . '/sidebar.php';
//Sidebar hooks
ms_hook( 'sidebar',  'makesite_sb_widgets', 25 );
ms_hook( 'sidebar2', 'makesite_sb2_widgets', 25 );

//Content functions
include dirname( __FILE__ ) . '/content.php';
//Content hooks
ms_hook( 'content', 'makesite_ct_loop', 25 );

//Footer functions
include dirname( __FILE__ ) . '/footer.php';
//Footer hooks
ms_hook( 'footer', 'makesite_ft_navigation', 20 );
ms_hook( 'footer', 'makesite_ft_skiplinks',  30 );
ms_hook( 'footer', 'makesite_ft_info',       40 );
