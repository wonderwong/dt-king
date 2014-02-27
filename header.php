<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<title>
	<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		echo " | $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		echo ' | ' . sprintf( __( 'Page %s', LANGUAGE_ZONE ), max( $paged, $page ) );
	}
	?>
</title>
<?php wp_head(); ?>

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main.css">
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/plugins/prettyPhoto/css/prettyPhoto.css">

<!--[if IE 6]>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG.js"></script>
<script type="text/javascript">
  DD_belatedPNG.fix('#top-nav li ul li a,#header-tag li,.img-wrap .to-img, .img-wrap .to-page ,#footer,#footer .icon a,#footer .copyright,#gallery .img .to-big,#resume .job-name,#resume .h .c2,#resume .aq,#resume .skill p,#resume .job h3,.reco-book-list li,.reco-book-list');
</script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->

<?php
$icon = of_get_option( 'appearance-favicon' );
echo empty($icon)?'':'<link rel="icon" type="image/png" href="' . ( (strpos($icon, '/wp-content') === 0)?get_site_url().$icon:$icon ) . '" />'; 
?>
</head>

<body <?php body_class(); ?>>
	<header id="header">
		<div class="wp clearfix">
			<!--logo-->
			<a id="logo" class="fl font-yh" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">悟道前端</a>
			<!--/logo-->
			
			<a id="menu-btn"></a>
			
			<!--菜单-->
			<nav id="nav-wrap" class="fr">
<?php
	dt_menu( array(
		'menu_wraper' 	=> '<ul id="top-nav" class="top-nav">%MENU_ITEMS%</ul>',
		'menu_items'	=> '<li %IS_FIRST%><a class="%ITEM_CLASS%" href="%ITEM_HREF%" title="%ESC_ITEM_TITLE%">%ITEM_TITLE%</a>%SUBMENU%</li>',
		'submenu' 		=> '<div style="display: none;"><ul>%ITEM%</ul><i></i></div>'
	) );
?>
			</nav>
			<!--/菜单-->
			
		</div>
	</header>
	
	<section id="banner">
		<div class="wp">
			<div id="header-tag"></div>
			<div class="crumbs clearfix">
					<?php 
					if (!(is_home() || is_front_page())){
						get_breadcrumbs();
					}
					?>
			</div>
		</div>
	</section>