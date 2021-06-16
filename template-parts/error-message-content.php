<?php
/**
 * Template part for displaying error notifications
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Leverage_IT_Theme
 */
?>
<div class="w-100">
	<div class="alert alert-danger" role="alert">
		<span>
			<?php echo esc_html($args['error_message'])?>
		</span>
	</div>
</div>
