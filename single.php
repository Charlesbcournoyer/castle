<?php get_header(); ?>
	<div id="container">
		<section id="content" <?php castle_content_class(); ?>>
			<?php if( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class="entry">
						<header class="entry-header">
							<<?php castle_title_tag( 'post' ); ?> class="entry-title"><?php the_title(); ?></<?php castle_title_tag( 'post' ); ?>>
							<?php castle_entry_meta(); ?>
						</header><!-- .entry-header -->
						<div class="entry-content">
							<?php if( has_post_format( 'audio' ) ) : ?>
								<p><?php castle_post_audio(); ?></p>
							<?php elseif( has_post_format( 'video' ) ) : ?>
								<p><?php castle_post_video(); ?></p>
							<?php endif; ?>
							<?php the_content(); ?>
							<div class="clear"></div>
						</div><!-- .entry-content -->
						<footer class="entry-utility">
							<?php wp_link_pages( array( 'before' => '<p class="post-pagination">' . __( 'Pages:', 'castle' ), 'after' => '</p>' ) ); ?>
							<?php the_tags( '<div class="entry-tags">', ' ', '</div>' ); ?>
							<?php castle_social_bookmarks(); ?>
							<?php castle_post_author(); ?>
						</footer><!-- .entry-utility -->
					</div><!-- .entry -->
					<?php comments_template(); ?>
				</article><!-- .post -->
			<?php else : ?>
				<?php castle_404(); ?>
			<?php endif; ?>
		</section><!-- #content -->
		<?php if( ( 'no-sidebars' != castle_get_option( 'layout' ) ) && ( 'full-width' != castle_get_option( 'layout' ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div><!-- #container -->
<?php get_footer(); ?>