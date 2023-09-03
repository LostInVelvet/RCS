<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
<style>
	html {
		background-image: url('<?php if ( get_theme_mod( 'background_image' ) ) : echo  get_theme_mod( 'background_image' ); endif; ?>');
		background-repeat: no-repeat;
		background: linear-gradient(
      					rgba(210, 210, 210, 0.7), 
      					rgba(210, 210, 210, 0.7)
    					),
					url('<?php if ( get_theme_mod( 'background_image' ) ) : echo  get_theme_mod( 'background_image' ); endif; ?>') no-repeat fixed center;
		background-size: cover;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	$(window).on('load resize', function(){	
		if( <?php if ( get_theme_mod( 'background_image' ) ) : echo  "true"; else : echo "false"; endif; ?> == true){
		}
		$("#wrapper").css('margin-top', $("#menu").height() + 'px');
		
		if( <?php if(is_user_logged_in()) { echo 'true'; } else { echo 'false'; } ?> ){
			$("#menu").css('top', $("#wpadminbar").height() + 'px');
		}
	});
</script>
	
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header id="header" role="banner">
<nav id="menu" role="navigation">
<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
</nav>
</header>
<div id="container">