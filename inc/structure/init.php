<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */

include dirname( __FILE__ ) . '/framework.php';

//Header functions
include dirname( __FILE__ ) . '/header.php';
//Header hooks
add_action( 'makesite_header', 'makesite_hd_open',        7 );
add_action( 'makesite_header', 'makesite_hd_skiplinks',  20 );
add_action( 'makesite_header', 'makesite_hd_branding',   30 );
add_action( 'makesite_header', 'makesite_hd_navigation', 40 );
add_action( 'makesite_header', 'makesite_hd_close',      97 );
add_filter( 'wp_nav_menu', 'ms_minify_html',        7 );

//Sidebar functions
include dirname( __FILE__ ) . '/sidebar.php';
//Sidebar hooks
add_action( 'makesite_sidebar', 'makesite_sb_open',     7 );
add_action( 'makesite_sidebar', 'makesite_sb_widgets', 25 );
add_action( 'makesite_sidebar', 'makesite_sb_close',   97 );

//Content functions
include dirname( __FILE__ ) . '/content.php';
//Content hooks
add_action( 'makesite_content', 'makesite_ct_open',     7 );
add_action( 'makesite_content', 'makesite_ct_loop', 25 );
add_action( 'makesite_content', 'makesite_ct_close',   97 );

//Footer functions
include dirname( __FILE__ ) . '/footer.php';
//Footer hooks
add_action( 'makesite_footer', 'get_sidebar',             0 );
add_action( 'makesite_footer', 'makesite_ft_open',        7 );
add_action( 'makesite_footer', 'makesite_ft_navigation', 20 );
add_action( 'makesite_footer', 'makesite_ft_skiplinks',  30 );
add_action( 'makesite_footer', 'makesite_ft_info',       40 );
add_action( 'makesite_footer', 'makesite_ft_close',      97 );
