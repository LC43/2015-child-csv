<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
		
}
wp_enqueue_script( 'glossary', get_stylesheet_directory_uri() . '/js/glossary.js', array( 'jquery' ), '20150330', true );
wp_localize_script( 'glossary', 'MyAjax', 
  	array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),
    	   'gettermsNonce' => wp_create_nonce( 'myajax-term-nonce' ),
	 ) );
	 

add_action('wp_ajax_get_terms','prefix_ajax_get_terms');
add_action('wp_ajax_nopriv_get_terms','prefix_ajax_get_terms');


function prefix_ajax_get_terms(){
	$nonce = $_POST['getterms_nonce'];
	
  //if ( ! wp_verify_nonce( $nonce, 'myajax-term-nonce' ) ) {
  //      die ( 'Not allowed.');
	//}
	// getting the term from ajax post
	$term_text = $_POST['term_text']; 
	$solution  = "";
	$uploaddir = wp_upload_dir();
	if (($handle = fopen($uploaddir['baseurl']."/glossario.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    	if( mb_strtolower($data[0]) === mb_strtolower($term_text)) {
    	  $solution = $data[1];
    	} 
    }
    fclose($handle);
	}

	$response = json_encode( $solution  );
  header( "Content-Type: application/json" );
  echo $response;
	
	die();
	
}


function head_cleanup() {
  // Originally from http://wpengineer.com/1438/wordpress-header/
  remove_action('wp_head', 'feed_links_extra', 3);
  add_action('wp_head', 'ob_start', 1, 0);
  add_action('wp_head', function () {
    $pattern = '/.*' . preg_quote(esc_url(get_feed_link('comments_' . get_default_feed())), '/') . '.*[\r\n]+/';
    echo preg_replace($pattern, '', ob_get_clean());
  }, 3, 0);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('use_default_gallery_style', '__return_false');
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
  }
}

add_action('init', 'head_cleanup');
add_filter('the_generator', '__return_false');
