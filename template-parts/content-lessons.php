<?php
/**
 * Template part for displaying Lessons posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Leverage_IT_Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>

	<?php the_post_thumbnail(); ?>
	<div class="card-body">
		<h5 class="card-title">
			<?php the_title(); ?>
		</h5>

		<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
		   class="card-author d-block">
			<?php the_author(); ?>
		</a>

		<div class="card-meta d-flex justify-content-between my-3">

			<small class="card-date text-secondary">
				<?php echo esc_html($args['lesson_start_date']); ?>
			</small>

			<small class="card-duration text-secondary">
				<?php echo esc_html($args['lesson_duration']); ?>
			</small>

		</div>

		<div class="card-buttons">

			<?php if ($args['lesson_attachment']) : ?>

				<a href="<?php echo esc_url($args['lesson_attachment']['url']); ?>" class="btn btn-primary me-2" download>
					<img src="<?php echo esc_url(get_template_directory_uri() . "/images/icons/download_icon.svg"); ?>" alt="Download attachment">
				</a>

			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" class="btn btn-primary">
				Read more
			</a>

		</div>

	</div>

</article>
