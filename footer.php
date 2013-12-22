		<?php if( is_front_page() || is_page_template( 'template-landing-page.php' ) || ( is_home() && ! is_paged() ) ) : ?>
			<?php get_sidebar( 'footer-wide' ); ?>
		<?php endif; ?>
		<div id="footer">
			<?php get_sidebar( 'footer' ); ?>
			<div id="copyright">
				<p class="copyright twocol"><?php castle_copyright_notice(); ?></p>
				<?php if( castle_get_option( 'theme_credit_link' ) || castle_get_option( 'author_credit_link' )  || castle_get_option( 'wordpress_credit_link' ) ) : ?>
					<p class="credits twocol">
						<?php $theme_credit_link = '<a href="' . esc_url( 'http://www.charlescournoyer.com/wordpress-themes/castle' ) . '" title="' . esc_attr( __( 'Castle Theme', 'castle' ) ) . '">' . __( 'Castle Theme', 'castle' ) . '</a>'; ?>
						<?php $author_credit_link = '<a href="' . esc_url( 'http://www.charlescournoyer.com/' ) . '" title="' . esc_attr( __( 'Charles Cournoyer', 'castle' ) ) . '">' . __( 'Charles Cournoyer', 'castle' ) . '</a>'; ?>
						<?php $wordpress_credit_link = '<a href="' . esc_url( 'http://wordpress.org/' ) . '" title="' . esc_attr( __( 'WordPress', 'castle' ) ) . '">' . __( 'WordPress', 'castle' ) . '</a>';; ?>
						<?php if( castle_get_option( 'theme_credit_link' ) && castle_get_option( 'author_credit_link' ) && castle_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s by %2$s and %3$s', 'castle' ), $theme_credit_link, $author_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( castle_get_option( 'theme_credit_link' ) && castle_get_option( 'author_credit_link' ) && ! castle_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s by %2$s', 'castle' ), $theme_credit_link, $author_credit_link ); ?>
						<?php elseif( castle_get_option( 'theme_credit_link' ) && ! castle_get_option( 'author_credit_link' ) && castle_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s and %2$s', 'castle' ), $theme_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( ! castle_get_option( 'theme_credit_link' ) && castle_get_option( 'author_credit_link' ) && castle_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s and %2$s', 'castle' ), $author_credit_link, $wordpress_credit_link ); ?>
						<?php elseif( castle_get_option( 'theme_credit_link' ) && ! castle_get_option( 'author_credit_link' ) && ! castle_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'castle' ), $theme_credit_link ); ?>
						<?php elseif( ! castle_get_option( 'theme_credit_link' ) && castle_get_option( 'author_credit_link' ) && ! castle_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'castle' ), $author_credit_link ); ?>
						<?php elseif( ! castle_get_option( 'theme_credit_link' ) && ! castle_get_option( 'author_credit_link' ) && castle_get_option( 'wordpress_credit_link' ) ) : ?>
							<?php echo sprintf( __( 'Powered by %1$s', 'castle' ), $wordpress_credit_link ); ?>
						<?php endif; ?>
					</p>
				<?php endif; ?>
				<div class="clear"></div>
			</div><!-- #copyright -->
		</div><!-- #footer -->
	</div><!-- #wrapper -->
<?php wp_footer(); ?>
</body>
</html>