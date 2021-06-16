<?php
/**
 * Template part for displaying filter form for [lessons-layout] shortcode
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Leverage_IT_Theme
 */

// Defining params
/** @var WP_Term[] $lessons_languages */
/** @var WP_Term[] $lessons_subjects */
$lessons_languages = $args['lessons_languages'];
$lessons_subjects = $args['lessons_subjects'];


?>

<form action="" method="post" class="row mb-4 g-3 lessons-filtering-form">

	<?php if (count($lessons_languages) > 0 && !is_wp_error($lessons_languages)) : ?>
		<div class="col-12 col-sm-6 col-lg-3">

			<select name="lessons_language" class="form-select" aria-label="Lessons Language">
				<option value="all" selected>
					<?php _e("All Languages", "leverage-it"); ?>
				</option>
				<?php foreach ($lessons_languages as $lessons_language) : ?>
					<option value="<?php echo esc_attr($lessons_language->term_id); ?>">
						<?php echo esc_html($lessons_language->name); ?>
					</option>
				<?php endforeach; ?>
			</select>

		</div>
	<?php endif; ?>

	<?php if (count($lessons_subjects) > 0 && !is_wp_error($lessons_subjects)) : ?>
		<div class="col-12 col-sm-6 col-lg-3">
			<select name="lessons_subject" class="form-select" aria-label="Lessons Subject">

				<option value="all" selected>
					<?php _e("All Subjects", "leverage-it"); ?>
				</option>
				<?php foreach ($lessons_subjects as $lessons_subject) : ?>

					<option value="<?php echo esc_attr($lessons_subject->term_id); ?>">
						<?php echo esc_html($lessons_subject->name); ?>
					</option>

				<?php endforeach; ?>
			</select>
		</div>
	<?php endif; ?>

	<div class="col-12 col-sm-6 col-lg-3">
		<div class="input-group">

			<input type="radio" class="btn-check" value="all" name="type_of_lesson" id="all_btn"
				   autocomplete="off"
				   checked>
			<label class="btn btn-primary" for="all_btn">
				<?php _e("All", "leverage-it"); ?>
			</label>

			<input type="radio" class="btn-check" value="free" name="type_of_lesson" id="free_btn"
				   autocomplete="off">
			<label class="btn btn-primary" for="free_btn">
				<?php _e("Free", "leverage-it"); ?>
			</label>

			<input type="radio" class="btn-check" value="paid" name="type_of_lesson" id="paid_btn"
				   autocomplete="off">
			<label class="btn btn-primary" for="paid_btn">
				<?php _e("Paid", "leverage-it"); ?>
			</label>

		</div>
	</div>

	<!-- Date Radio -->
	<div class="col-12 col-sm-6 col-lg-3">
		<div class="input-group">
			<input type="radio" class="btn-check" value="all" name="date_of_lesson" id="all_dates_btn"
				   autocomplete="off" checked>
			<label class="btn btn-primary" for="all_dates_btn">
				<?php _e("All", "leverage-it"); ?>
			</label>
			<input type="radio" class="btn-check" value="upcoming" name="date_of_lesson" id="upcoming_btn"
				   autocomplete="off">
			<label class="btn btn-primary" for="upcoming_btn">
				<?php _e("Upcoming", "leverage-it"); ?>
			</label>
			<input type="radio" class="btn-check" value="past" name="date_of_lesson" id="past_btn"
				   autocomplete="off">
			<label class="btn btn-primary" for="past_btn">
				<?php _e("Past", "leverage-it"); ?>
			</label>
		</div>
	</div>

</form>
