<?php get_header(); ?>
<section id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if (!is_page('shop')) { ?>
	<header class="header">
<h1 class="entry-title"><?php the_title(); ?></h1>
</header>
	<?php } ?>
<section class="entry-content">

<?php
    if (is_page('shop')) {
			echo '<nav id="shop-menu" role="navigation">';
			wp_nav_menu( array( 'theme_location' => 'shop-menu' ) );

			echo '</nav>';
			
	}
?>

<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
<?php the_content(); ?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
</section>
</article>
<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
<?php endwhile; endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>