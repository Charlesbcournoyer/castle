<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="entry">
		<?php if( ! castle_post_is_full_width() ) : ?>
			<?php castle_post_thumbnail(); ?>
		<?php endif; ?>
		<div class="entry-container">
			<header class="entry-header">
				<<?php castle_title_tag( 'post' ); ?> class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></<?php castle_title_tag( 'post' ); ?>>
				<?php if( castle_post_is_full_width() ) : ?>
					<?php castle_entry_meta(); ?>
				<?php endif; ?>
			</header><!-- .entry-header -->
			<?php if( castle_post_is_full_width() ) : ?>
				<?php castle_post_thumbnail(); ?>
			<?php endif; ?>
			<?php if( ! is_category( castle_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( castle_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php endif; ?>
			<div class="clear"></div>
		</div><!-- .entry-container -->
		<?php if( ! castle_post_is_full_width() ) : ?>
			<?php castle_entry_meta(); ?>
		<?php endif; ?>
	</div><!-- .entry -->
</article><!-- .post -->