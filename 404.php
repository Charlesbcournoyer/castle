<?php get_header(); ?>
	<div id="container">
		<section id="content" <?php castle_content_class(); ?>>
			<?php castle_404(); ?>
		</section><!-- #content -->
		<?php if( ( 'no-sidebars' != castle_get_option( 'layout' ) ) && ( 'full-width' != castle_get_option( 'layout' ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div><!-- #container -->
<?php get_footer(); ?>