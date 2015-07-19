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
	$term_text = sanitize_text_field($_POST['term_text']); 
	$solution  = "";
	$uploaddir = wp_upload_dir();
	if (($handle = fopen($uploaddir['baseurl']."/glossario.csv", "r")) !== FALSE) {
    	 	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    			if( mb_strtolower($data[0]) === mb_strtolower($term_text)) {
    	  			$solution = $dta[1];
    			} 
    		}
    		fclose($handle);
	}

	$response = json_encode( $solution  );
  	header( "Content-Type: application/json" );
  	echo $response;
	
	die();
	
}

