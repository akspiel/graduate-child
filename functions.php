<?php

// add styles
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
     add_action("wp_enqueue_scripts","add_fonts_to_theme");
// Choose the fonts 
    function all_google_fonts() {
        $fonts = array(
               "Roboto+Slab:wght@400,700&display=swap"
            );
        $fonts_collection = add_query_arg(array(
            "family"=>urlencode(implode("|",$fonts)),
            "subset"=>"latin"
            ),'https://fonts.googleapis.com/css2?');
        return $fonts_collection;
     }
     
//add script
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function my_scripts_method() {
    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/custom_script.js',
        array( 'jquery' ),
        false, 
        true
    );
}
//stop adding p tags
remove_filter (‘the_content’, ‘wpautop’);
remove_filter (‘the_excerpt’, ‘wpautop’);

if ( ! function_exists( 'graduate_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Graduate 0.1
	 *
	 */
	function graduate_site_branding() {
		?>
		<div class="container">
			<div class="site-branding pull-left">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo">
	            		<?php echo get_custom_logo(); ?>
	          		</div>
          		<?php endif; ?>
				<div id="site-header">
					<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img id="logo" src="/wp-content/uploads/2020/11/MUG-Coffee-Logo.svg" height="68" alt=""><span><?php bloginfo( 'name' ); ?></span></a></div>
					<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo esc_html( $description ); ?></p>
					<?php
					endif; ?>
				</div><!--#site-header-->
			</div><!--end .site-branding-->

			<?php if ( is_active_sidebar( 'graduate-header-widget-area' ) ) { ?>
				<div class="pull-right">
					<?php dynamic_sidebar( 'graduate-header-widget-area' ); ?>
				</div><!--.pull-right-->
			<?php } ?>
		</div><!--.container-->
	<?php
	}
endif;
add_action( 'graduate_header_action', 'graduate_site_branding', 20 );

if ( ! function_exists( 'graduate_footer_site_info' ) ) :
	/**
	 * Footer ends
	 *
	 * @since Graduate 0.1
	 *
	 */
	function graduate_footer_site_info() { 
		$options = graduate_get_theme_options();
		$search = array( '[the-year]', '[site-link]' );

        $replace = array( date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

        $options['copyright_text'] = str_replace( $search, $replace, $options['copyright_text'] );
		?>
		<div class="site-info clear">
			<div class="container">
				<div class="pull-left footer-menu">
					<?php 
					if ( has_nav_menu( 'footer-menu' ) ) :
						wp_nav_menu(
						 	array( 
							 	'theme_location' 	=> 'footer-menu', 
							 	'menu_id' 			=> 'footer-menu',
							 	'depth'				=> 1 
						 	) 
						 ); 
					endif; ?>
				</div><!--.pull-left-->
				<div class="pull-right">
					<p>
						<?php echo graduate_santize_allow_tag( $options['copyright_text'] ); ?>
						<?php printf( esc_html__( '%1$s by %2$s', 'graduate' ), 'Site design', '<a href="' . esc_url( 'https://akspiel.com/' ) . '" rel="designer" target="_blank">Amy Spielmaker</a>' );
						if ( function_exists( 'the_privacy_policy_link' ) ) {
							the_privacy_policy_link( '<span> | </span>' );
						} ?>

				</div><!--.pull-right-->
			</div><!--.container-->
		</div><!--.site-info-->
	<?php
	}
endif;
add_action( 'graduate_footer', 'graduate_footer_site_info', 30 );

function guide_footer() { ?>
    <div class="container"><a href="/">Back to all guides</a></div>
<?php }
add_action('eckb-article-footer', 'guide_footer',10,4);

?>