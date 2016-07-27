<?php
/**
 * Body classes for design page
 * @param array $body_classes Classes to apply to the body tag
 * @since 0.7.0
 */
$body_classes = apply_filters( 'ms_design_body_classes', array( 'ms-design' ) );
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Makesite Design</title>
	<link rel="stylesheet" href="<?php echo MS_DESIGN_URL ?>/assets/style.css?v=<?php echo MS_VER ?>">
	<?php
	/**
	 * At the end of the head on design page
	 * @since 0.7.0
	 */
	do_action( 'ms_design_head' )
	?>
</head>
<body class="<?php implode( ' ', array_unique( $body_classes ) ) ?>">
<div class="wrap">
	<aside>
		<?php
		/**
		 * Sidebar fields on design page
		 * @since 0.7.0
		 */
		do_action( 'ms_design_fields' ) ?>
	</aside>
	<section>
		<iframe id="site-iframe" src="<?php echo $_GET['url'] ?>" frameborder="0"></iframe>
	</section>
</div>


<?php
/**
 * At the end of the body on design page
 * @since 0.7.0
 */
 do_action( 'ms_design_footer' ) ?>
</body>
</html>
