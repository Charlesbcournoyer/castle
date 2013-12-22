<?php

function castle_theme_page() {
	add_theme_page( __( 'Castle Theme Options', 'castle' ), __( 'Theme Options', 'castle' ), 'edit_theme_options', 'castle_options', 'castle_admin_options_page' );
}

add_action( 'admin_menu', 'castle_theme_page' );

function castle_register_settings() {
	register_setting( 'castle_theme_options', 'castle_theme_options', 'castle_validate_theme_options' );
}

add_action( 'admin_init', 'castle_register_settings' );

function castle_admin_scripts( $page_hook ) {
	if( 'appearance_page_castle_options' == $page_hook ) {
		wp_enqueue_style( 'castle_admin_style', get_template_directory_uri() . '/styles/admin.css' );
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'json2' );
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'wp-color-picker' );
	}
}

add_action( 'admin_enqueue_scripts', 'castle_admin_scripts' );

function castle_admin_options_page() { ?>
	<div class="wrap">
		<?php castle_admin_options_page_tabs(); ?>
		<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
			<div class='updated'><p><?php _e( 'Theme settings updated successfully.', 'castle' ); ?></p></div>
		<?php endif; ?>
		<form action="options.php" method="post">
			<?php settings_fields( 'castle_theme_options' ); ?>
			<?php do_settings_sections('castle_options'); ?>
			<p>&nbsp;</p>
			<?php $tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' ); ?>
			<input name="castle_theme_options[submit-<?php echo $tab; ?>]" type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'castle' ); ?>" />
			<input name="castle_theme_options[reset-<?php echo $tab; ?>]" type="submit" class="button-secondary" value="<?php _e( 'Reset Defaults', 'castle' ); ?>" />
			<script>
				jQuery(document).ready(function($) {
					$('.wp-color-picker').wpColorPicker();
				});
			</script>
		</form>
	</div>
<?php
}

function castle_admin_options_page_tabs( $current = 'general' ) {
	$current = ( isset ( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
	$tabs = array(
		'general' => __( 'General', 'castle' ),
		'design' => __( 'Design', 'castle' ),
		'layout' => __( 'Layout', 'castle' ),
		'typography' => __( 'Typography', 'castle' ),
		'seo' => __( 'SEO', 'castle' )
	);
	$links = array();
	foreach( $tabs as $tab => $name )
		$links[] = "<a class='nav-tab" . ( $tab == $current ? ' nav-tab-active' : '' ) ."' href='?page=castle_options&tab=$tab'>$name</a>";
	echo '<div id="icon-themes" class="icon32"><br /></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $links as $link )
		echo $link;
	echo '</h2>';
}

function castle_admin_options_init() {
	global $pagenow;
	if( 'themes.php' == $pagenow && isset( $_GET['page'] ) && 'castle_options' == $_GET['page'] ) {
		$tab = ( isset ( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
		switch ( $tab ) {
			case 'general' :
				castle_general_settings_sections();
				break;
			case 'design' :
				castle_design_settings_sections();
				break;
			case 'layout' :
				castle_layout_settings_sections();
				break;
			case 'typography' :
				castle_typography_settings_sections();
				break;
			case 'seo' :
				castle_seo_settings_sections();
				break;
		}
	}
}

add_action( 'admin_init', 'castle_admin_options_init' );

function castle_general_settings_sections() {
	add_settings_section( 'castle_global_options', __( 'Global Options', 'castle' ), 'castle_global_options', 'castle_options' );
	add_settings_section( 'castle_social_media_options', __( 'Social Media Links', 'castle' ), 'castle_social_media_options', 'castle_options' );
	add_settings_section( 'castle_home_page_options', __( 'Home Page', 'castle' ), 'castle_home_page_options', 'castle_options' );
	add_settings_section( 'castle_portfolio_page_options', __( 'Portfolio Page', 'castle' ), 'castle_portfolio_page_options', 'castle_options' );
	add_settings_section( 'castle_archive_page_options', __( 'Blog Pages', 'castle' ), 'castle_archive_page_options', 'castle_options' );
	add_settings_section( 'castle_single_options', __( 'Single Posts', 'castle' ), 'castle_single_options', 'castle_options' );
	add_settings_section( 'castle_footer_options', __( 'Footer', 'castle' ), 'castle_footer_options', 'castle_options' );
}

function castle_global_options() {
	add_settings_field( 'castle_retina_header', __( 'Retina Header Image', 'castle' ), 'castle_retina_header', 'castle_options', 'castle_global_options' );
	add_settings_field( 'castle_fancy_dropdowns', __( 'Fancy Drop-down Menus', 'castle' ), 'castle_fancy_dropdowns', 'castle_options', 'castle_global_options' );
	add_settings_field( 'castle_crop_thumbnails', __( 'Post Thumbnails', 'castle' ), 'castle_crop_thumbnails', 'castle_options', 'castle_global_options' );
	add_settings_field( 'castle_use_lightbox', __( 'Lightbox', 'castle' ), 'castle_use_lightbox', 'castle_options', 'castle_global_options' );
	add_settings_field( 'castle_posts_nav', __( 'Posts Navigation', 'castle' ), 'castle_posts_nav', 'castle_options', 'castle_global_options' );
	add_settings_field( 'castle_posts_nav_labels', __( 'Posts Navigation Labels', 'castle' ), 'castle_posts_nav_labels', 'castle_options', 'castle_global_options' );
}

function castle_retina_header() { ?>
	<label class="description">
		<input name="castle_theme_options[retina_header]" type="checkbox" value="1" <?php checked( castle_get_option( 'retina_header' ) ); ?> />
		<span><?php _e( 'Uploaded header images are HiDPI images for retina displays, downsize on normal screen devices.', 'castle' ); ?></span>
	</label>
<?php
}

function castle_fancy_dropdowns() { ?>
	<label class="description">
		<input name="castle_theme_options[fancy_dropdowns]" type="checkbox" value="1" <?php checked( castle_get_option( 'fancy_dropdowns' ) ); ?> />
		<span><?php _e( 'Enable transition effects for drop-down menus', 'castle' ); ?></span>
	</label>
<?php
}

function castle_crop_thumbnails() { ?>
	<label class="description">
		<input name="castle_theme_options[crop_thumbnails]" type="checkbox" value="1" <?php checked( castle_get_option( 'crop_thumbnails' ) ); ?> />
		<span><?php _e( 'Hard crop post thumbnails', 'castle' ); ?></span>
	</label><br />
	<span class="description"><strong>Note:</strong> <?php _e( 'After changing this option, it is recommended to recreate your thumbnails using a plugin like', 'castle' ); ?> <a href="<?php echo esc_url('http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/'); ?>">AJAX Thumbnail Rebuild</a></span>
<?php
}

function castle_use_lightbox() { ?>
	<label class="description">
		<input name="castle_theme_options[lightbox]" type="checkbox" value="1" <?php checked( castle_get_option( 'lightbox' ) ); ?> />
		<span><?php _e( 'Open image links in a lightbox', 'castle' ); ?></span>
	</label>
<?php
}

function castle_posts_nav() { ?>
	<select name="castle_theme_options[posts_nav]">
		<option value="static" <?php selected( 'static', castle_get_option( 'posts_nav' ) ); ?>><?php _e( 'Static Links', 'castle' ); ?></option>
		<option value="ajax" <?php selected( 'ajax', castle_get_option( 'posts_nav' ) ); ?>><?php _e( 'AJAX Links', 'castle' ); ?></option>
		<option value="infinite" <?php selected( 'infinite', castle_get_option( 'posts_nav' ) ); ?>><?php _e( 'Infinite Scroll', 'castle' ); ?></option>
	</select>
<?php
}

function castle_posts_nav_labels() { ?>
	<select name="castle_theme_options[posts_nav_labels]">
		<option value="next/prev" <?php selected( 'next/prev', castle_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Next Page', 'castle' ); ?> / <?php _e( 'Previous Page', 'castle' ); ?></option>
		<option value="older/newer" <?php selected( 'older/newer', castle_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Older Posts', 'castle' ); ?> / <?php _e( 'Newer Posts', 'castle' ); ?></option>
		<option value="earlier/later" <?php selected( 'earlier/later', castle_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Earlier Posts', 'castle' ); ?> / <?php _e( 'Later Posts', 'castle' ); ?></option>
		<option value="numbered" <?php selected( 'numbered', castle_get_option( 'posts_nav_labels' ) ); ?>><?php _e( 'Numbered Pagination', 'castle' ); ?></option>
	</select>
<?php
}

function castle_social_media_options() {
	add_settings_field( 'castle_facebook_link', __( 'Facebook Page', 'castle' ), 'castle_facebook_link', 'castle_options', 'castle_social_media_options' );
	add_settings_field( 'castle_twitter_link', __( 'Twitter Account', 'castle' ), 'castle_twitter_link', 'castle_options', 'castle_social_media_options' );
	add_settings_field( 'castle_pinterest_link', __( 'Pinterest Board', 'castle' ), 'castle_pinterest_link', 'castle_options', 'castle_social_media_options' );
	add_settings_field( 'castle_flickr_link', __( 'Flickr Account', 'castle' ), 'castle_flickr_link', 'castle_options', 'castle_social_media_options' );
	add_settings_field( 'castle_vimeo_link', __( 'Vimeo Account', 'castle' ), 'castle_vimeo_link', 'castle_options', 'castle_social_media_options' );
	add_settings_field( 'castle_youtube_link', __( 'Youtube Channel', 'castle' ), 'castle_youtube_link', 'castle_options', 'castle_social_media_options' );
	add_settings_field( 'castle_googleplus_link', __( 'Google Plus Account', 'castle' ), 'castle_googleplus_link', 'castle_options', 'castle_social_media_options' );
	add_settings_field( 'castle_dribble_link', __( 'Dribble Account', 'castle' ), 'castle_dribble_link', 'castle_options', 'castle_social_media_options' );
	add_settings_field( 'castle_linkedin_link', __( 'LinkedIn Account', 'castle' ), 'castle_linkedin_link', 'castle_options', 'castle_social_media_options' );
}

function castle_facebook_link() { ?>
	<input name="castle_theme_options[facebook_link]" type="text" value="<?php echo castle_get_option( 'facebook_link' ); ?>" />
<?php
}

function castle_twitter_link() { ?>
	<input name="castle_theme_options[twitter_link]" type="text" value="<?php echo castle_get_option( 'twitter_link' ); ?>" />
<?php
}

function castle_pinterest_link() { ?>
	<input name="castle_theme_options[pinterest_link]" type="text" value="<?php echo castle_get_option( 'pinterest_link' ); ?>" />
<?php
}

function castle_flickr_link() { ?>
	<input name="castle_theme_options[flickr_link]" type="text" value="<?php echo castle_get_option( 'flickr_link' ); ?>" />
<?php
}

function castle_vimeo_link() { ?>
	<input name="castle_theme_options[vimeo_link]" type="text" value="<?php echo castle_get_option( 'vimeo_link' ); ?>" />
<?php
}

function castle_youtube_link() { ?>
	<input name="castle_theme_options[youtube_link]" type="text" value="<?php echo castle_get_option( 'youtube_link' ); ?>" />
<?php
}

function castle_googleplus_link() { ?>
	<input name="castle_theme_options[googleplus_link]" type="text" value="<?php echo castle_get_option( 'googleplus_link' ); ?>" />
<?php
}

function castle_dribble_link() { ?>
	<input name="castle_theme_options[dribble_link]" type="text" value="<?php echo castle_get_option( 'dribble_link' ); ?>" />
<?php
}

function castle_linkedin_link() { ?>
	<input name="castle_theme_options[linkedin_link]" type="text" value="<?php echo castle_get_option( 'linkedin_link' ); ?>" />
<?php
}

function castle_home_page_options() {
	add_settings_field( 'castle_home_page_excerpts', __( 'Full posts to display', 'castle' ), 'castle_home_page_excerpts', 'castle_options', 'castle_home_page_options' );
	add_settings_field( 'castle_home_page_slider', __( 'Sticky Posts Slider', 'castle' ), 'castle_home_page_slider', 'castle_options', 'castle_home_page_options' );
	add_settings_field( 'castle_blog_exclude_portfolio', __( 'Exclude Portfolio', 'castle' ), 'castle_blog_exclude_portfolio', 'castle_options', 'castle_home_page_options' );
}

function castle_home_page_excerpts() { ?>
	<label class="description">
		<input name="castle_theme_options[home_page_excerpts]" type="text" value="<?php echo castle_get_option( 'home_page_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid', 'castle' ); ?></span>
	</label>
<?php
}

function castle_blog_exclude_portfolio() { ?>
	<label class="description">
		<input name="castle_theme_options[blog_exclude_portfolio]" type="checkbox" value="<?php echo castle_get_option( 'blog_exclude_portfolio' ); ?>" <?php checked( castle_get_option( 'blog_exclude_portfolio' ) ); ?> />
		<span><?php _e( 'Exclude Portfolio Category from main loop', 'castle' ); ?></span>
	</label>
<?php
}

function castle_home_page_slider() { ?>
	<label class="description">
		<input name="castle_theme_options[slider]" type="checkbox" value="<?php echo castle_get_option( 'slider' ); ?>" <?php checked( castle_get_option( 'slider' ) ); ?> />
		<span><?php _e( 'Display a slider of sticky posts on the front page', 'castle' ); ?></span>
	</label>
<?php
}

function castle_portfolio_page_options() {
	add_settings_field( 'castle_portfolio_cat', __( 'Portfolio Category', 'castle' ), 'castle_portfolio_cat', 'castle_options', 'castle_portfolio_page_options' );
	add_settings_field( 'castle_portfolio_excerpts', __( 'Full posts to display on first page', 'castle' ), 'castle_portfolio_excerpts', 'castle_options', 'castle_portfolio_page_options' );
	add_settings_field( 'castle_portfolio_archive_excerpts', __( 'Full posts to display on secondary pages', 'castle' ), 'castle_portfolio_archive_excerpts', 'castle_options', 'castle_portfolio_page_options' );
}

function castle_portfolio_cat() {
	$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) ); ?>
	<select name="castle_theme_options[portfolio_cat]">
		<option value="-1" <?php selected( castle_get_option( 'portfolio_cat' ), -1 ); ?>>&mdash;</option>
		<?php foreach( $categories as $category ) : ?>
			<option value="<?php echo $category->cat_ID; ?>" <?php selected( castle_get_option( 'portfolio_cat' ), $category->cat_ID ); ?>><?php echo $category->cat_name; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_portfolio_excerpts() { ?>
	<label class="description">
		<input name="castle_theme_options[portfolio_excerpts]" type="text" value="<?php echo castle_get_option( 'portfolio_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid', 'castle' ); ?></span>
	</label>
<?php
}

function castle_portfolio_archive_excerpts() { ?>
	<label class="description">
		<input name="castle_theme_options[portfolio_archive_excerpts]" type="text" value="<?php echo castle_get_option( 'portfolio_archive_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid', 'castle' ); ?></span>
	</label>
<?php
}

function castle_archive_page_options() {
	add_settings_field( 'castle_archive_location', 'Archive Page Location', 'castle_archive_location', 'castle_options', 'castle_archive_page_options' );
	add_settings_field( 'castle_archive_excerpts', 'Full posts to display', 'castle_archive_excerpts', 'castle_options', 'castle_archive_page_options' );
}

function castle_archive_location() { ?>
	<label class="description">
		<input name="castle_theme_options[location]" type="checkbox" value="<?php echo castle_get_option( 'location' ); ?>" <?php checked( castle_get_option( 'location' ) ); ?> />
		<span><?php _e( 'Show current location in archive pages', 'castle' ); ?></span>
	</label>
<?php
}

function castle_archive_excerpts() { ?>
	<label class="description">
		<input name="castle_theme_options[archive_excerpts]" type="text" value="<?php echo castle_get_option( 'archive_excerpts' ); ?>" size="2" maxlength="2" />
		<span><?php _e( 'Full posts to display before grid', 'castle' ); ?></span>
	</label>
<?php
}

function castle_single_options() {
	add_settings_field( 'castle_show_social_bookmarks', __( 'Social Bookmarks', 'castle' ), 'castle_show_social_bookmarks', 'castle_options', 'castle_single_options' );
	add_settings_field( 'castle_show_author_box', __( 'Author Box', 'castle' ), 'castle_show_author_box', 'castle_options', 'castle_single_options' );
}

function castle_show_social_bookmarks() { ?>
	<label class="description">
		<input name="castle_theme_options[facebook]" type="checkbox" value="<?php echo castle_get_option( 'facebook' ); ?>" <?php checked( castle_get_option( 'facebook' ) ); ?> />
		<span><?php _e( 'Facebook Like', 'castle' ); ?></span>
	</label><br />
	<label class="description">
		<input name="castle_theme_options[twitter]" type="checkbox" value="<?php echo castle_get_option( 'twitter' ); ?>" <?php checked( castle_get_option( 'twitter' ) ); ?> />
		<span><?php _e( 'Twitter Button', 'castle' ); ?></span>
	</label><br />
	<label class="description">
		<input name="castle_theme_options[google]" type="checkbox" value="<?php echo castle_get_option( 'google' ); ?>" <?php checked( castle_get_option( 'google' ) ); ?> />
		<span><?php _e( 'Google +1', 'castle' ); ?></span>
	</label><br />
	<label class="description">
		<input name="castle_theme_options[pinterest]" type="checkbox" value="<?php echo castle_get_option( 'pinterest' ); ?>" <?php checked( castle_get_option( 'pinterest' ) ); ?> />
		<span><?php _e( 'Pinterest', 'castle' ); ?></span>
	</label>
<?php
}

function castle_show_author_box() { ?>
	<label class="description">
		<input name="castle_theme_options[author_box]" type="checkbox" value="<?php echo castle_get_option( 'author_box' ); ?>" <?php checked( castle_get_option( 'author_box' ) ); ?> />
		<span><?php _e( 'Display a hcard microformatted box featuring author name, avatar and bio', 'castle' ); ?></span>
	</label>
<?php
}

function castle_footer_options() {
	add_settings_field( 'castle_copyright_notice', __( 'Copyright Notice', 'castle' ), 'castle_copyright_notice', 'castle_options', 'castle_footer_options' );
	add_settings_field( 'castle_credit_links', __( 'Credit Links', 'castle' ), 'castle_credit_links', 'castle_options', 'castle_footer_options' );
}

function castle_copyright_notice() { ?>
	<label class="description">
		<input name="castle_theme_options[copyright_notice]" type="text" value="<?php echo esc_html( castle_get_option( 'copyright_notice' ) ); ?>" />
		<span><?php _e( 'Text to display in the footer copyright section (%year% = current year, %blogname% = website name)', 'castle' ); ?></span>
	</label>
<?php
}

function castle_credit_links() { ?>
	<label class="description">
		<input name="castle_theme_options[theme_credit_link]" type="checkbox" value="<?php echo castle_get_option( 'theme_credit_link' ); ?>" <?php checked( castle_get_option( 'theme_credit_link' ) ); ?> />
		<span><?php _e( 'Show theme credit link', 'castle' ); ?></span>
	</label><br />
	<label class="description">
		<input name="castle_theme_options[author_credit_link]" type="checkbox" value="<?php echo castle_get_option( 'author_credit_link' ); ?>" <?php checked( castle_get_option( 'author_credit_link' ) ); ?> />
		<span><?php _e( 'Show author credit link', 'castle' ); ?></span>
	</label><br />
	<label class="description">
		<input name="castle_theme_options[wordpress_credit_link]" type="checkbox" value="<?php echo castle_get_option( 'wordpress_credit_link' ); ?>" <?php checked( castle_get_option( 'wordpress_credit_link' ) ); ?> />
		<span><?php _e( 'Show WordPress credit link', 'castle' ); ?></span>
	</label>
<?php
}

function castle_design_settings_sections() {
	add_settings_section( 'castle_backgrounds', __( 'Background Colors', 'castle' ), 'castle_backgrounds', 'castle_options' );
}

function castle_backgrounds() {
	add_settings_field( 'castle_page_background', __( 'Page Background Color', 'castle' ), 'castle_page_background', 'castle_options', 'castle_backgrounds' );
	add_settings_field( 'castle_menu_background', __( 'Menu Background Color', 'castle' ), 'castle_menu_background', 'castle_options', 'castle_backgrounds' );
	add_settings_field( 'castle_submenu_background', __( 'Dropdown Menus Background Color', 'castle' ), 'castle_submenu_background', 'castle_options', 'castle_backgrounds' );
	add_settings_field( 'castle_sidebar_wide_background', __( 'Site Location Background Color', 'castle' ), 'castle_sidebar_wide_background', 'castle_options', 'castle_backgrounds' );
	add_settings_field( 'castle_content_background', __( 'Content Background Color', 'castle' ), 'castle_content_background', 'castle_options', 'castle_backgrounds' );
	add_settings_field( 'castle_post_meta_background', __( 'Post Meta Background Color', 'castle' ), 'castle_post_meta_background', 'castle_options', 'castle_backgrounds' );
	add_settings_field( 'castle_footer_area_background', __( 'Footer Widgets Background Color', 'castle' ), 'castle_footer_area_background', 'castle_options', 'castle_backgrounds' );
	add_settings_field( 'castle_footer_background', __( 'Footer Background Color', 'castle' ), 'castle_footer_background', 'castle_options', 'castle_backgrounds' );
}

function castle_page_background() { ?>
	<input name="castle_theme_options[page_background]" type="text" id="page_background" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'page_background' ) ); ?>" />
	<?php
}

function castle_menu_background() { ?>
	<input name="castle_theme_options[menu_background]" type="text" id="menu_background" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'menu_background' ) ); ?>" />
	<?php
}

function castle_submenu_background() { ?>
	<input name="castle_theme_options[submenu_background]" type="text" id="submenu_background" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'submenu_background' ) ); ?>" />
	<?php
}

function castle_sidebar_wide_background() { ?>
	<input name="castle_theme_options[sidebar_wide_background]" type="text" id="sidebar_wide_background" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'sidebar_wide_background' ) ); ?>" />
	<?php
}

function castle_content_background() { ?>
	<input name="castle_theme_options[content_background]" type="text" id="content_background" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'content_background' ) ); ?>" />
	<?php
}

function castle_post_meta_background() { ?>
	<input name="castle_theme_options[post_meta_background]" type="text" id="post_meta_background" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'post_meta_background' ) ); ?>" />
	<?php
}

function castle_footer_area_background() { ?>
	<input name="castle_theme_options[footer_area_background]" type="text" id="footer_area_background" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'footer_area_background' ) ); ?>" />
	<?php
}

function castle_footer_background() { ?>
	<input name="castle_theme_options[footer_background]" type="text" id="footer_background" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'footer_background' ) ); ?>" />
	<?php
}

function castle_layout_settings_sections() {
	add_settings_section( 'castle_layout', __( 'Default Layout Template', 'castle' ), 'castle_layout', 'castle_options' );
	add_settings_section( 'castle_layout_dimensions', __( 'Grid Layout Dimensions', 'castle' ), 'castle_layout_dimensions', 'castle_options' );
	add_settings_section( 'castle_responsive_layout', __( 'Responsive Layout', 'castle' ), 'castle_responsive_layout', 'castle_options' );
	add_settings_section( 'castle_custom_css', __( 'Custom CSS', 'castle' ), 'castle_custom_css', 'castle_options' );
}

function castle_layout() {
	add_settings_field( 'castle_layout_template', __( 'Choose your preferred Layout', 'castle' ), 'castle_layout_template', 'castle_options', 'castle_layout' );
}

function castle_layout_dimensions() {
	add_settings_field( 'castle_layout_columns', __( 'Content Columns', 'castle' ), 'castle_layout_columns', 'castle_options', 'castle_layout_dimensions' );
	add_settings_field( 'castle_boxes_columns', __( 'Boxes Sidebar Columns', 'castle' ), 'castle_boxes_columns', 'castle_options', 'castle_layout_dimensions' );
	add_settings_field( 'castle_footer_columns', __( 'Footer Sidebar Columns', 'castle' ), 'castle_footer_columns', 'castle_options', 'castle_layout_dimensions' );
}

function castle_responsive_layout() {
	add_settings_field( 'castle_hide_sidebar', __( 'Hide Sidebar', 'castle' ), 'castle_hide_sidebar', 'castle_options', 'castle_responsive_layout' );
	add_settings_field( 'castle_hide_footer_area', __( 'Hide Footer Widgets Area', 'castle' ), 'castle_hide_footer_area', 'castle_options', 'castle_responsive_layout' );
}

function castle_custom_css() {
	add_settings_field( 'castle_user_css', __( 'Enter your custom CSS', 'castle' ), 'castle_user_css', 'castle_options', 'castle_custom_css' );
}

function castle_layout_template() {
	$current_layout = castle_get_option( 'layout' );
	$layouts = array(
		'content-sidebar' => array(
			'name' => 'Content / Sidebar',
			'image' => 'content-sidebar.png'
		),
		'sidebar-content' => array(
			'name' => 'Sidebar / Content',
			'image' => 'sidebar-content.png'
		),
		'content-sidebar-half' => array(
			'name' => 'Content / Sidebar Half',
			'image' => 'content-sidebar-half.png'
		),
		'sidebar-content-half' => array(
			'name' => 'Sidebar / Content Half',
			'image' => 'content-sidebar-half.png'
		),
		'no-sidebars' => array(
			'name' => 'No Sidebars',
			'image' => 'no-sidebars.png'
		),
		'full-width' => array(
			'name' => 'Full Width',
			'image' => 'full-width.png'
		),
	); ?>
	<script>
		jQuery(document).ready(function($) {
			var label_id = '';
			$('.layout').each(function(){
				if($(this).attr('checked')=='checked')
					label_id = '#label-'+$(this).attr('id');
			});
			if('' != label_id)
				$(label_id).addClass('checked');
			$('.layout-label').click(function() {
				$('.layout-label').removeClass('checked');
				$(this).addClass('checked');
			});
		});
	</script>
	<?php foreach( $layouts as $layout => $data ) : ?>
		<label for="<?php echo $layout; ?>" class="layout-label" id="label-<?php echo $layout; ?>"><img src="<?php echo get_template_directory_uri() . '/images/' . $data['image']; ?>" alt="<?php echo $data['name']; ?>" title="<?php echo $data['name']; ?>" />
		<input name="castle_theme_options[layout]" class="layout" id="<?php echo $layout; ?>" value="<?php echo $layout; ?>" type="radio" <?php checked( $layout, $current_layout ); ?> /></label>
	<?php endforeach;
}

function castle_layout_columns() { ?>
	<select name="castle_theme_options[layout_columns]">
		<option value="2" <?php selected( 2, castle_get_option( 'layout_columns' ) ); ?>>2</option>
		<option value="3" <?php selected( 3, castle_get_option( 'layout_columns' ) ); ?>>3</option>
		<option value="4" <?php selected( 4, castle_get_option( 'layout_columns' ) ); ?>>4</option>
	</select><br />
	<span class="description">
		<strong><?php _e( 'Note', 'castle' ); ?>:</strong> <?php _e( 'If your layout contains a sidebar, the sidebar accounts for 1 column from the grid.', 'castle' ); ?><br />
		<?php _e( 'Not all combinations of layouts and number of columns may be practical.', 'castle' ); ?>
	</span>
<?php
}

function castle_boxes_columns() { ?>
	<select name="castle_theme_options[boxes_columns]">
		<option value="2" <?php selected( 2, castle_get_option( 'boxes_columns' ) ); ?>>2</option>
		<option value="3" <?php selected( 3, castle_get_option( 'boxes_columns' ) ); ?>>3</option>
		<option value="4" <?php selected( 4, castle_get_option( 'boxes_columns' ) ); ?>>4</option>
	</select>
<?php
}

function castle_footer_columns() { ?>
	<select name="castle_theme_options[footer_columns]">
		<option value="2" <?php selected( 2, castle_get_option( 'footer_columns' ) ); ?>>2</option>
		<option value="3" <?php selected( 3, castle_get_option( 'footer_columns' ) ); ?>>3</option>
		<option value="4" <?php selected( 4, castle_get_option( 'footer_columns' ) ); ?>>4</option>
	</select>
<?php
}

function castle_hide_sidebar() { ?>
	<label class="description">
		<input name="castle_theme_options[hide_sidebar]" type="checkbox" value="<?php echo castle_get_option( 'hide_sidebar' ); ?>" <?php checked( castle_get_option( 'hide_sidebar' ) ); ?> />
		<span><?php _e( 'Hide Sidebar on Mobile Devices', 'castle' ); ?></span>
	</label>
<?php
}

function castle_hide_footer_area() { ?>
	<label class="description">
		<input name="castle_theme_options[hide_footer_area]" type="checkbox" value="<?php echo castle_get_option( 'hide_footer_area' ); ?>" <?php checked( castle_get_option( 'hide_footer_area' ) ); ?> />
		<span><?php _e( 'Hide Footer Widget Area on Mobile Devices', 'castle' ); ?></span>
	</label>
<?php
}

function castle_user_css() { ?>
	<textarea name="castle_theme_options[user_css]" cols="70" rows="15" style="width:97%;font-family:monospace;background:#f9f9f9"><?php echo esc_textarea( castle_get_option( 'user_css' ) ); ?></textarea>
<?php
}

function castle_typography_settings_sections() {
	add_settings_section( 'castle_fonts', __( 'Font Families', 'castle' ), 'castle_fonts', 'castle_options' );
	add_settings_section( 'castle_font_sizes', __( 'Font Sizes', 'castle' ), 'castle_font_sizes', 'castle_options' );
	add_settings_section( 'castle_colors', __( 'Colors', 'castle' ), 'castle_colors', 'castle_options' );
}

function castle_fonts() {
	add_settings_field( 'castle_body_font', __( 'Default Font Family', 'castle' ), 'castle_body_font', 'castle_options', 'castle_fonts' );
	add_settings_field( 'castle_headings_font', __( 'Headings Font Family', 'castle' ), 'castle_headings_font', 'castle_options', 'castle_fonts' );
	add_settings_field( 'castle_content_font', __( 'Body Copy Font Family', 'castle' ), 'castle_content_font', 'castle_options', 'castle_fonts' );
}

function castle_body_font() {
	$fonts = castle_available_fonts(); ?>
	<select name="castle_theme_options[body_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, castle_get_option( 'body_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_headings_font() {
	$fonts = castle_available_fonts(); ?>
	<select name="castle_theme_options[headings_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, castle_get_option( 'headings_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_content_font() {
	$fonts = castle_available_fonts(); ?>
	<select name="castle_theme_options[content_font]">
		<?php foreach( $fonts as $name => $family ) : ?>
			<option value="<?php echo $name; ?>" <?php selected( $name, castle_get_option( 'content_font' ) ); ?>><?php echo str_replace( '"', '', $family ); ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_font_sizes() {
	add_settings_field( 'castle_body_font_size', __( 'Default Font Size', 'castle' ), 'castle_body_font_size', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_body_line_height', __( 'Default Line Height', 'castle' ), 'castle_body_line_height', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_h1_font_size', __( 'H1 Font Size', 'castle' ), 'castle_h1_font_size', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_h2_font_size', __( 'H2 Font Size', 'castle' ), 'castle_h2_font_size', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_h3_font_size', __( 'H3 Font Size', 'castle' ), 'castle_h3_font_size', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_h4_font_size', __( 'H4 Font Size', 'castle' ), 'castle_h4_font_size', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_headings_line_height', __( 'Headings Line Height', 'castle' ), 'castle_headings_line_height', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_content_font_size', __( 'Body Copy Font Size', 'castle' ), 'castle_content_font_size', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_content_line_height', __( 'Body Copy Line Height', 'castle' ), 'castle_content_line_height', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_mobile_font_size', __( 'Body Copy Font Size on Mobile Devices', 'castle' ), 'castle_mobile_font_size', 'castle_options', 'castle_font_sizes' );
	add_settings_field( 'castle_mobile_line_height', __( 'Body Copy Line Height on Mobile Devices', 'castle' ), 'castle_mobile_line_height', 'castle_options', 'castle_font_sizes' );
}

function castle_body_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[body_font_size]" type="text" value="<?php echo castle_get_option( 'body_font_size' ); ?>" size="4" />
	<select name="castle_theme_options[body_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'body_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_body_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[body_line_height]" type="text" value="<?php echo castle_get_option( 'body_line_height' ); ?>" size="4" />
	<select name="castle_theme_options[body_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'body_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_h1_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[h1_font_size]" type="text" value="<?php echo castle_get_option( 'h1_font_size' ); ?>" size="4" />
	<select name="castle_theme_options[h1_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'h1_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_h2_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[h2_font_size]" type="text" value="<?php echo castle_get_option( 'h2_font_size' ); ?>" size="4" />
	<select name="castle_theme_options[h2_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'h2_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_h3_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[h3_font_size]" type="text" value="<?php echo castle_get_option( 'h3_font_size' ); ?>" size="4" />
	<select name="castle_theme_options[h3_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'h3_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_h4_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[h4_font_size]" type="text" value="<?php echo castle_get_option( 'h4_font_size' ); ?>" size="4" />
	<select name="castle_theme_options[h4_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'h4_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_headings_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[headings_line_height]" type="text" value="<?php echo castle_get_option( 'headings_line_height' ); ?>" size="4" />
	<select name="castle_theme_options[headings_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'headings_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_content_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[content_font_size]" type="text" value="<?php echo castle_get_option( 'content_font_size' ); ?>" size="4" />
	<select name="castle_theme_options[content_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'content_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_content_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[content_line_height]" type="text" value="<?php echo castle_get_option( 'content_line_height' ); ?>" size="4" />
	<select name="castle_theme_options[content_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'content_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_mobile_font_size() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[mobile_font_size]" type="text" value="<?php echo castle_get_option( 'mobile_font_size' ); ?>" size="4" />
	<select name="castle_theme_options[mobile_font_size_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'mobile_font_size_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_mobile_line_height() {
	$units = array( 'px', 'pt', 'em', '%' ); ?>
	<input name="castle_theme_options[mobile_line_height]" type="text" value="<?php echo castle_get_option( 'mobile_line_height' ); ?>" size="4" />
	<select name="castle_theme_options[mobile_line_height_unit]">
		<?php foreach( $units as $unit ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, castle_get_option( 'mobile_line_height_unit' ) ); ?>><?php echo $unit; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_colors() {
	add_settings_field( 'castle_body_color', __( 'Default Font Color', 'castle' ), 'castle_body_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_headings_color', __( 'Headings Font Color', 'castle' ), 'castle_headings_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_content_color', __( 'Body Copy Font Color', 'castle' ), 'castle_content_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_links_color', __( 'Links Color', 'castle' ), 'castle_links_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_links_hover_color', __( 'Links Hover Color', 'castle' ), 'castle_links_hover_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_menu_color', __( 'Navigation Links Color', 'castle' ), 'castle_menu_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_menu_hover_color', __( 'Navigation Links Hover Color', 'castle' ), 'castle_menu_hover_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_sidebar_color', __( 'Sidebar Widgets Color', 'castle' ), 'castle_sidebar_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_sidebar_title_color', __( 'Sidebar Widgets Title Color', 'castle' ), 'castle_sidebar_title_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_sidebar_links_color', __( 'Widgets Links Color', 'castle' ), 'castle_sidebar_links_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_footer_color', __( 'Footer Widgets Color', 'castle' ), 'castle_footer_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_footer_title_color', __( 'Footer Widgets Title Color', 'castle' ), 'castle_footer_title_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_copyright_color', __( 'Footer Color', 'castle' ), 'castle_copyright_color', 'castle_options', 'castle_colors' );
	add_settings_field( 'castle_copyright_links_color', __( 'Footer Links Color', 'castle' ), 'castle_copyright_links_color', 'castle_options', 'castle_colors' );
}

function castle_body_color() { ?>
	<input name="castle_theme_options[body_color]" type="text" id="body_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'body_color' ) ); ?>" />
	<?php
}

function castle_headings_color() { ?>
	<input name="castle_theme_options[headings_color]" type="text" id="headings_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'headings_color' ) ); ?>" />
	<?php
}

function castle_content_color() { ?>
	<input name="castle_theme_options[content_color]" type="text" id="content_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'content_color' ) ); ?>" />
	<?php
}

function castle_links_color() { ?>
	<input name="castle_theme_options[links_color]" type="text" id="links_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'links_color' ) ); ?>" />
	<?php
}

function castle_links_hover_color() { ?>
	<input name="castle_theme_options[links_hover_color]" type="text" id="links_hover_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'links_hover_color' ) ); ?>" />
	<?php
}

function castle_menu_color() { ?>
	<input name="castle_theme_options[menu_color]" type="text" id="menu_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'menu_color' ) ); ?>" />
	<?php
}

function castle_menu_hover_color() { ?>
	<input name="castle_theme_options[menu_hover_color]" type="text" id="menu_hover_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'menu_hover_color' ) ); ?>" />
	<?php
}

function castle_sidebar_color() { ?>
	<input name="castle_theme_options[sidebar_color]" type="text" id="sidebar_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'sidebar_color' ) ); ?>" />
	<?php
}

function castle_sidebar_title_color() { ?>
	<input name="castle_theme_options[sidebar_title_color]" type="text" id="sidebar_title_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'sidebar_title_color' ) ); ?>" />
	<?php
}

function castle_sidebar_links_color() { ?>
	<input name="castle_theme_options[sidebar_links_color]" type="text" id="sidebar_links_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'sidebar_links_color' ) ); ?>" />
	<?php
}

function castle_footer_color() { ?>
	<input name="castle_theme_options[footer_color]" type="text" id="footer_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'footer_color' ) ); ?>" />
	<?php
}

function castle_footer_title_color() { ?>
	<input name="castle_theme_options[footer_title_color]" type="text" id="footer_title_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'footer_title_color' ) ); ?>" />
	<?php
}

function castle_copyright_color() { ?>
	<input name="castle_theme_options[copyright_color]" type="text" id="copyright_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'copyright_color' ) ); ?>" />
	<?php
}

function castle_copyright_links_color() { ?>
	<input name="castle_theme_options[copyright_links_color]" type="text" id="copyright_links_color" class="wp-color-picker" value="<?php echo esc_attr( castle_get_option( 'copyright_links_color' ) ); ?>" />
	<?php
}
function castle_seo_settings_sections() {
	add_settings_section( 'castle_home_tags', __( 'Home Page', 'castle' ), 'castle_home_tags', 'castle_options' );
	add_settings_section( 'castle_archive_tags', __( 'Archive Pages', 'castle' ), 'castle_archive_tags', 'castle_options' );
	add_settings_section( 'castle_single_tags', __( 'Single Posts &amp; Pages', 'castle' ), 'castle_single_tags', 'castle_options' );
	add_settings_section( 'castle_other_tags', __( 'Other', 'castle' ), 'castle_other_tags', 'castle_options' );
}

function castle_home_tags() {
	add_settings_field( 'castle_home_site_title_tag', __( 'Site Title Tag', 'castle' ), 'castle_home_site_title_tag', 'castle_options', 'castle_home_tags' );
	add_settings_field( 'castle_home_site_desc_tag', __( 'Site Description Tag', 'castle' ), 'castle_home_site_desc_tag', 'castle_options', 'castle_home_tags' );
	add_settings_field( 'castle_home_post_title_tag', __( 'Post Title Tag', 'castle' ), 'castle_home_post_title_tag', 'castle_options', 'castle_home_tags' );
}

function castle_home_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[home_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'home_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_home_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[home_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'home_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_home_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[home_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'home_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_archive_tags() {
	add_settings_field( 'castle_archive_site_title_tag', __( 'Site Title Tag', 'castle' ), 'castle_archive_site_title_tag', 'castle_options', 'castle_archive_tags' );
	add_settings_field( 'castle_archive_site_desc_tag', __( 'Site Description Tag', 'castle' ), 'castle_archive_site_desc_tag', 'castle_options', 'castle_archive_tags' );
	add_settings_field( 'castle_archive_location_title_tag', __( 'Site Location Title Tag', 'castle' ), 'castle_archive_location_title_tag', 'castle_options', 'castle_archive_tags' );
	add_settings_field( 'castle_archive_post_title_tag', __( 'Post Title Tag', 'castle' ), 'castle_archive_post_title_tag', 'castle_options', 'castle_archive_tags' );
}

function castle_archive_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[archive_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'archive_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_archive_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[archive_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'archive_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_archive_location_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[archive_location_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'archive_location_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_archive_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[archive_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'archive_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_single_tags() {
	add_settings_field( 'castle_single_site_title_tag', __( 'Site Title Tag', 'castle' ), 'castle_single_site_title_tag', 'castle_options', 'castle_single_tags' );
	add_settings_field( 'castle_single_site_desc_tag', __( 'Site Description Tag', 'castle' ), 'castle_single_site_desc_tag', 'castle_options', 'castle_single_tags' );
	add_settings_field( 'castle_single_post_title_tag', __( 'Post Title Tag', 'castle' ), 'castle_single_post_title_tag', 'castle_options', 'castle_single_tags' );
	add_settings_field( 'castle_single_comments_title_tag', __( 'Comments Title Tag', 'castle' ), 'castle_single_comments_title_tag', 'castle_options', 'castle_single_tags' );
	add_settings_field( 'castle_single_respond_title_tag', __( 'Reply Form Title Tag', 'castle' ), 'castle_single_respond_title_tag', 'castle_options', 'castle_single_tags' );
}

function castle_single_site_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[single_site_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'single_site_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_single_site_desc_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[single_desc_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'single_desc_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_single_post_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[single_post_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'single_post_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_single_comments_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[single_comments_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'single_comments_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_single_respond_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[single_respond_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'single_respond_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_other_tags() {
	add_settings_field( 'castle_widget_title_tag', __( 'Widget Title Tag', 'castle' ), 'castle_widget_title_tag', 'castle_options', 'castle_other_tags' );
}

function castle_widget_title_tag() {
	$tags = array( 'h1', 'h2', 'h3', 'p', 'div' ); ?>
	<select name="castle_theme_options[widget_title_tag]">
		<?php foreach( $tags as $tag ) : ?>
			<option value="<?php echo $tag; ?>" <?php selected( $tag, castle_get_option( 'widget_title_tag' ) ); ?>><?php echo $tag; ?></option>
		<?php endforeach; ?>
	</select>
<?php
}

function castle_validate_theme_options( $input ) {
	if( isset( $input['submit-general'] ) || isset( $input['reset-general'] ) ) {
		if( ! is_numeric( absint( $input['home_page_excerpts'] ) ) || $input['home_page_excerpts'] > get_option( 'posts_per_page' ) || '' == $input['home_page_excerpts'] )
			$input['home_page_excerpts'] = castle_get_option( 'home_page_excerpts' );
		else
			$input['home_page_excerpts'] = absint( $input['home_page_excerpts'] );
		if( -1 != $input['portfolio_cat'] ) {
			$valid = 0;
			$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) );
			foreach( $categories as $category ) {
				if( $input['portfolio_cat'] == $category->cat_ID )
					$valid = 1;
			}
			if( ! $valid )
				$input['portfolio_cat'] = castle_get_option( 'portfolio_cat' );
		}
		if( ! is_numeric( absint( $input['portfolio_excerpts'] ) ) || $input['portfolio_excerpts'] > get_option( 'posts_per_page' ) || '' == $input['portfolio_excerpts'] )
			$input['portfolio_excerpts'] = castle_get_option( 'portfolio_excerpts' );
		else
			$input['portfolio_excerpts'] = absint( $input['portfolio_excerpts'] );
		if( ! is_numeric( absint( $input['portfolio_archive_excerpts'] ) ) || $input['portfolio_archive_excerpts'] > get_option( 'posts_per_page' ) || '' == $input['portfolio_archive_excerpts'] )
			$input['portfolio_archive_excerpts'] = castle_get_option( 'portfolio_archive_excerpts' );
		else
			$input['portfolio_archive_excerpts'] = absint( $input['portfolio_archive_excerpts'] );
		if( ! is_numeric( absint( $input['archive_excerpts'] ) ) || $input['archive_excerpts'] > get_option( 'posts_per_page' ) || '' == $input['archive_excerpts'] )
			$input['archive_excerpts'] = castle_get_option( 'archive_excerpts' );
		else
			$input['archive_excerpts'] = absint( $input['archive_excerpts'] );
		$input['slider'] = ( isset( $input['slider'] ) ? true : false );
		$input['blog_exclude_portfolio'] = ( isset( $input['blog_exclude_portfolio'] ) ? true : false );
		$input['location'] = ( isset( $input['location'] ) ? true : false );
		$input['retina_header'] = ( isset( $input['retina_header'] ) ? true : false );
		$input['crop_thumbnails'] = ( isset( $input['crop_thumbnails'] ) ? true : false );
		$input['lightbox'] = ( isset( $input['lightbox'] ) ? true : false );
		if( ! in_array( $input['posts_nav'], array( 'static', 'ajax', 'infinite' ) ) )
			$input['posts_nav'] = castle_get_option( 'posts_nav' );
		if( ! in_array( $input['posts_nav_labels'], array( 'next/prev', 'older/newer', 'earlier/later', 'numbered' ) ) )
			$input['posts_nav_labels'] = castle_get_option( 'posts_nav_labels' );
		$input['fancy_dropdowns'] = ( isset( $input['fancy_dropdowns'] ) ? true : false );
		$input['facebook_link'] = esc_url_raw( $input['facebook_link'] );
		$input['twitter_link'] = esc_url_raw( $input['twitter_link'] );
		$input['pinterest_link'] = esc_url_raw( $input['pinterest_link'] );
		$input['youtube_link'] = esc_url_raw( $input['youtube_link'] );
		$input['vimeo_link'] = esc_url_raw( $input['vimeo_link'] );
		$input['flickr_link'] = esc_url_raw( $input['flickr_link'] );
		$input['googleplus_link'] = esc_url_raw( $input['googleplus_link'] );
		$input['dribble_link'] = esc_url_raw( $input['dribble_link'] );
		$input['linkedin_link'] = esc_url_raw( $input['linkedin_link'] );
		$input['facebook'] = ( isset( $input['facebook'] ) ? true : false );
		$input['twitter'] = ( isset( $input['twitter'] ) ? true : false );
		$input['google'] = ( isset( $input['google'] ) ? true : false );
		$input['pinterest'] = ( isset( $input['pinterest'] ) ? true : false );
		$input['author_box'] = ( isset( $input['author_box'] ) ? true : false );
		$input['copyright_notice'] = balanceTags( $input['copyright_notice'] );
		$input['theme_credit_link'] = ( isset( $input['theme_credit_link'] ) ? true : false );
		$input['author_credit_link'] = ( isset( $input['author_credit_link'] ) ? true : false );
		$input['wordpress_credit_link'] = ( isset( $input['wordpress_credit_link'] ) ? true : false );
	} elseif( isset( $input['submit-design'] ) || isset( $input['reset-design'] ) ) {
		$input['page_background'] = substr( $input['page_background'], 0, 7 );
		$input['menu_background'] = substr( $input['menu_background'], 0, 7 );
		$input['submenu_background'] = substr( $input['submenu_background'], 0, 7 );
		$input['sidebar_wide_background'] = substr( $input['sidebar_wide_background'], 0, 7 );
		$input['content_background'] = substr( $input['content_background'], 0, 7 );
		$input['post_meta_background'] = substr( $input['post_meta_background'], 0, 7 );
		$input['footer_area_background'] = substr( $input['footer_area_background'], 0, 7 );
		$input['footer_background'] = substr( $input['footer_background'], 0, 7 );
	} elseif( isset( $input['submit-layout'] ) || isset( $input['reset-layout'] ) ) {
		if( ! in_array( $input['layout'], array( 'content-sidebar', 'sidebar-content', 'content-sidebar-half', 'sidebar-content-half', 'no-sidebars', 'full-width' ) ) )
			$input['layout'] = castle_get_option( 'layout' );
		if( is_numeric( $input['layout_columns'] ) && 2 <= $input['layout_columns'] && 44 >= $input['layout_columns'] )
			$input['layout_columns'] = absint( $input['layout_columns'] );
		else
			$input['layout_columns'] = castle_get_option( 'layout_columns' );
		$input['hide_sidebar'] = ( isset( $input['hide_sidebar'] ) ? true : false );
		$input['hide_footer_area'] = ( isset( $input['hide_footer_area'] ) ? true : false );
		$input['user_css'] = strip_tags( $input['user_css'] );
		$input['user_css'] = str_replace( 'behavior', '', $input['user_css'] );
		$input['user_css'] = str_replace( 'expression', '', $input['user_css'] );
		$input['user_css'] = str_replace( 'binding', '', $input['user_css'] );
		$input['user_css'] = str_replace( '@import', '', $input['user_css'] );
	} elseif( isset( $input['submit-typography'] ) || isset( $input['reset-typography'] ) ) {
		$fonts = castle_available_fonts();
		$units = array( 'px', 'pt', 'em', '%' );
		$input['body_font'] = ( array_key_exists( $input['body_font'], $fonts ) ? $input['body_font'] : castle_get_option( 'body_font' ) );
		$input['headings_font'] = ( array_key_exists( $input['headings_font'], $fonts ) ? $input['headings_font'] : castle_get_option( 'headings_font' ) );
		$input['content_font'] = ( array_key_exists( $input['content_font'], $fonts ) ? $input['content_font'] : castle_get_option( 'content_font' ) );
		$input['body_font_size'] = number_format( floatval( $input['body_font_size'] ), 2, '.', '' );
		$input['body_font_size_unit'] = ( in_array( $input['body_font_size_unit'], $units ) ? $input['body_font_size_unit'] : castle_get_option( 'body_font_size_unit' ) );
		$input['body_line_height'] = number_format( floatval( $input['body_line_height'] ), 2, '.', '' );
		$input['body_line_height_unit'] = ( in_array( $input['body_line_height_unit'], $units ) ? $input['body_line_height_unit'] : castle_get_option( 'body_line_height_unit' ) );
		$input['h1_font_size'] = number_format( floatval( $input['h1_font_size'] ), 2, '.', '' );
		$input['h1_font_size_unit'] = ( in_array( $input['h1_font_size_unit'], $units ) ? $input['h1_font_size_unit'] : castle_get_option( 'h1_font_size_unit' ) );
		$input['h2_font_size'] = number_format( floatval( $input['h2_font_size'] ), 2, '.', '' );
		$input['h2_font_size_unit'] = ( in_array( $input['h2_font_size_unit'], $units ) ? $input['h2_font_size_unit'] : castle_get_option( 'h2_font_size_unit' ) );
		$input['h3_font_size'] = number_format( floatval( $input['h3_font_size'] ), 2, '.', '' );
		$input['h3_font_size_unit'] = ( in_array( $input['h3_font_size_unit'], $units ) ? $input['h3_font_size_unit'] : castle_get_option( 'h3_font_size_unit' ) );
		$input['h4_font_size'] = number_format( floatval( $input['h4_font_size'] ), 2, '.', '' );
		$input['h4_font_size_unit'] = ( in_array( $input['h4_font_size_unit'], $units ) ? $input['h4_font_size_unit'] : castle_get_option( 'h4_font_size_unit' ) );
		$input['headings_line_height'] = number_format( floatval( $input['headings_line_height'] ), 2, '.', '' );
		$input['headings_line_height_unit'] = ( in_array( $input['headings_line_height_unit'], $units ) ? $input['headings_line_height_unit'] : castle_get_option( 'headings_line_height_unit' ) );
		$input['content_font_size'] = number_format( floatval( $input['content_font_size'] ), 2, '.', '' );
		$input['content_font_size_unit'] = ( in_array( $input['content_font_size_unit'], $units ) ? $input['content_font_size_unit'] : castle_get_option( 'content_font_size_unit' ) );
		$input['content_line_height'] = number_format( floatval( $input['content_line_height'] ), 2, '.', '' );
		$input['content_line_height_unit'] = ( in_array( $input['content_line_height_unit'], $units ) ? $input['content_line_height_unit'] : castle_get_option( 'content_line_height_unit' ) );
		$input['mobile_font_size'] = number_format( floatval( $input['mobile_font_size'] ), 2, '.', '' );
		$input['mobile_font_size_unit'] = ( in_array( $input['mobile_font_size_unit'], $units ) ? $input['mobile_font_size_unit'] : castle_get_option( 'mobile_font_size_unit' ) );
		$input['mobile_line_height'] = number_format( floatval( $input['mobile_line_height'] ), 2, '.', '' );
		$input['mobile_line_height_unit'] = ( in_array( $input['mobile_line_height_unit'], $units ) ? $input['mobile_line_height_unit'] : castle_get_option( 'mobile_line_height_unit' ) );
		$input['body_color'] = substr( $input['body_color'], 0, 7 );
		$input['headings_color'] = substr( $input['headings_color'], 0, 7 );
		$input['content_color'] = substr( $input['content_color'], 0, 7 );
		$input['links_color'] = substr( $input['links_color'], 0, 7 );
		$input['links_hover_color'] = substr( $input['links_hover_color'], 0, 7 );
		$input['menu_color'] = substr( $input['menu_color'], 0, 7 );
		$input['menu_hover_color'] = substr( $input['menu_hover_color'], 0, 7 );
		$input['sidebar_color'] = substr( $input['sidebar_color'], 0, 7 );
		$input['sidebar_title_color'] = substr( $input['sidebar_title_color'], 0, 7 );
		$input['sidebar_links_color'] = substr( $input['sidebar_links_color'], 0, 7 );
		$input['footer_color'] = substr( $input['footer_color'], 0, 7 );
		$input['footer_title_color'] = substr( $input['footer_title_color'], 0, 7 );
		$input['copyright_color'] = substr( $input['copyright_color'], 0, 7 );
		$input['copyright_links_color'] = substr( $input['copyright_links_color'], 0, 7 );
	} elseif( isset( $input['submit-seo'] ) || isset( $input['reset-seo'] ) ) {
		$tags = array( 'h1', 'h2', 'h3', 'p', 'div' );
		foreach( $input as $key => $tag )
			if( ( 'reset-seo' != $key ) && ! in_array( $tag, $tags ) )
				$input[$key] = castle_get_option( $key );
	}
	if( isset( $input['reset-general'] ) || isset( $input['reset-layout'] ) || isset( $input['reset-design'] ) || isset( $input['reset-typography'] ) || isset( $input['reset-seo'] ) ) {
		$default_options = castle_default_options();
		foreach( $input as $name => $value )
			if( 'reset-general' != $name  && 'reset-design' != $name && 'reset-layout' != $name && 'reset-typography' != $name && 'reset-seo' != $name )
				$input[$name] = $default_options[$name];
	}
	$input = wp_parse_args( $input, get_option( 'castle_theme_options', castle_default_options() ) );
	return $input;
}