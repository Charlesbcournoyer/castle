<?php
/*
Template Name: Blog, Full Width
*/
?><?php get_header(); ?>
	<?php global $castle_page_template; ?>
	<?php $castle_page_template = 'template-blog-full-width.php'; ?>
	<?php if( castle_get_option( 'location' ) ) : ?>
		<?php castle_current_location(); ?>
	<?php endif; ?>
	<div id="container">
		<section id="content" class="column onecol">
			<?php $args = array( 'posts_per_page' => get_option( 'posts_per_page' ), 'paged' => max( 1, get_query_var( 'paged' ) ) ); ?>
			<?php if( castle_get_option( 'blog_exclude_portfolio' ) ) : ?>
				<?php $args['cat'] = '-' . castle_get_option( 'portfolio_cat' ); ?>
			<?php endif; ?>
			<?php global $wp_query, $wp_the_query; ?>
			<?php $wp_query = new WP_Query( $args ); ?>
			<?php if( $wp_query->have_posts() ) : ?>
				<div class="entries">
					<?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</div><!-- .entries -->
				<?php castle_posts_nav(); ?>
			<?php else : ?>
				<?php castle_404(); ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			<?php $wp_query = $wp_the_query; ?>
		</section><!-- #content -->
		<div class="clear"></div>
	</div><!-- #container -->
<?php get_footer(); ?>