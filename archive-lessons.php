<?php
/**
 * The template for displaying archive pages (Lessons CPT)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Leverage_IT_Theme
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php echo do_shortcode("[lessons-layout]"); ?>

	</main><!-- #main -->

<?php
get_footer();
