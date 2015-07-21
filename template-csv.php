<?php 
/** 
 * Template Name: CSV page
 */
 


get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			//get_template_part( 'content', 'page' );
?>
			<div id="gloss__block"><h2>Glossário</h2>
			<form id     = "booking__form"
  		      class  = "form-horizontal"  
            method = "get"  >
				<label class="floatl" for="booking__name"><?php _e('Termo em Inglês','43lc');?></label>
				<input type        ="text"  required
				       class       ="form-control " 
				       id          ="term__text" 
				       name        ="term__text"
				       value	     =""
				       min         ="0"
				       placeholder ="<?php _e('termo*','43lc');?>">
				       
			
			</form>
			<h3>Resultado:</h3>
			<p id="term__result"></p>
			
			</div>
			<div id="latestterms">
				<p id="firstresult" style="display: none;"></p>
				
			</div>
			
			<?php 


			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
