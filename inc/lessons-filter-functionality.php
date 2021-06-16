<?php
// Generating the shortcode
add_shortcode('lessons-layout', 'leverage_it_gen_lessons_layout');
function leverage_it_gen_lessons_layout()
{

	// Getting amount of published Lessons
	$published_lessons_num = wp_count_posts('lessons')->publish;

	// Resulting html output
	$html_output = "";

	// Root div
	$html_output .= '<div class="lessons-with-filter py-5">';

	// Container div
	$html_output .= '<div class="container">';

	// Checking if published lessons exist
	if ($published_lessons_num > 0) {

		// Getting all Taxonomies
		$lessons_languages = get_terms([
			'taxonomy' => 'lessons-language'
		]);

		$lessons_subjects = get_terms([
			'taxonomy' => 'lessons-subject'
		]);

		// Starting buffer
		ob_start();

		// Generating filter form
		get_template_part('template-parts/lessons', 'filter-form', [
			'lessons_languages' => $lessons_languages,
			'lessons_subjects' => $lessons_subjects
		]);

		// Saving html into output
		$html_output .= ob_get_contents();

		// Ending and cleaning buffer
		ob_end_clean();

		//////////////////////////////////////////////////////

		// Printing all lessons
		// Query Args
		$args = [
			'post_type' => 'lessons',
			'posts_per_page' => -1,
		];

		$query = new WP_Query($args);

		if ($query->have_posts()) {

			// Starting buffer
			ob_start();

			// Row of the Lessons Cols (cards)
			echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 lessons-cards-row">';

			while ($query->have_posts()) {
				$query->the_post();

				// Get Lesson Start Date & Lesson End Date
				$lesson_start_date = DateTime::createFromFormat("Y-m-d H:i:s", get_field("start_date"));
				$lesson_end_date = DateTime::createFromFormat("Y-m-d H:i:s", get_field("end_date"));

				// Calculate Lesson Duration
				$lesson_duration = $lesson_start_date->diff($lesson_end_date)->format("%I");

				// Get Lesson Attachment
				$lesson_attachment = get_field("lesson_attachment");

				// Pasting into buffer .col div
				echo '<div class="col">';

				// Pasting into buffer lessons cards
				get_template_part('template-parts/content', 'lessons', [
					'lesson_start_date' => esc_html($lesson_start_date->format("d.m.Y H:i")),
					'lesson_end_date' => esc_html($lesson_end_date->format("d.m.Y H:i")),
					'lesson_duration' => esc_html($lesson_duration . " minutes"),
					'lesson_attachment' => $lesson_attachment
				]);

				// Closing in buffer .col div
				echo '</div>'; // .col

			}

			// Closing .row in buffer
			echo '</div>'; // .row

		}

		wp_reset_postdata();

		// Pasting buffer into var
		$html_output .= ob_get_contents();

		ob_clean();

	} else {
		// Printing an error

		// Starting buffer
		ob_start();

		get_template_part('template-parts/error-message', 'content', [
			'error_message' => __("There are no published lessons", "leverage-it")
		]);

		// Pasting buffer into var
		$html_output .= ob_get_contents();

		// Ending and Cleaning buffer
		ob_end_clean();

	}

	$html_output .= '</div>'; // .lessons-with-filter
	$html_output .= '</div>'; // .container



	return $html_output;
}


// Lessons Filtering Function
if (wp_doing_ajax()) {
	add_action('wp_ajax_filter_lessons', 'leverage_it_lessons_filtering');
	add_action('wp_ajax_nopriv_filter_lessons', 'leverage_it_lessons_filtering');
}

function leverage_it_lessons_filtering()
{

	// Checking nonce
	if (check_ajax_referer("filter_nonce", 'security_nonce', false)) {

		// Result var
		$html_result_output = "";

		// Errors array
		$errors = [];

		// Filtering data parsing
		$filtering_data = [];
		parse_str($_POST['filtering_data'], $filtering_data);

		// Defining default Query Args
		$query_args = [
			'post_type' => 'lessons',
			'posts_per_page' => -1,
			'tax_query' => [
				'relation' => 'AND'
			],
			'meta_query' => [
				'relation' => 'AND'
			]
		];

		// Getting and sanitizing Filtering Form params, Creating Tax Query (Language)
		if (isset($filtering_data['lessons_language']) && $filtering_data['lessons_language'] != "" && $filtering_data['lessons_language'] != "all") {

			$lessons_language = sanitize_term_field('term_id', $filtering_data['lessons_language'], $filtering_data['lessons_language'], 'lessons-language', 'db');

			$query_args['tax_query'][] = [
				'taxonomy' => 'lessons-language',
				'field' => 'term_id',
				'terms' => $lessons_language
			];
		}

		// Getting and sanitizing Filtering Form params, Creating Tax Query (Subject)
		if (isset($filtering_data['lessons_subject']) && $filtering_data['lessons_subject'] != "" && $filtering_data['lessons_subject'] != "all") {

			$lessons_subject = sanitize_term_field('term_id', $filtering_data['lessons_subject'], $filtering_data['lessons_subject'], 'lessons-subject', 'db');

			$query_args['tax_query'][] = [
				'taxonomy' => 'lessons-subject',
				'field' => 'term_id',
				'terms' => $lessons_subject
			];
		}

		// Creating meta_query (Type of lessons: Free/Paid/All)
		if (isset($filtering_data['type_of_lesson']) && $filtering_data['type_of_lesson'] != "" && $filtering_data['type_of_lesson'] != "all") {

			$type_of_lesson = sanitize_text_field($filtering_data['type_of_lesson']);

			// Creating meta query
			$query_args['meta_query'][] = [
				'key'           => 'type_of_the_lesson',
				'compare'       => '=',
				'value'         => $type_of_lesson
			];

		}

		// Creating meta_query (Date of lessons: Upcoming/Past/All)
		if (isset($filtering_data['date_of_lesson']) && $filtering_data['date_of_lesson'] != "" && $filtering_data['date_of_lesson'] != "all") {

			$date_of_lesson = sanitize_text_field($filtering_data['date_of_lesson']);

			// Getting current DateTime
			$current_date_time = date('Y-m-d H:i:s');

			// Creating meta query
			switch ($date_of_lesson) {

				case "upcoming" :

					$query_args['meta_query'][] = [
						'key'           => 'start_date',
						'compare'       => '>=',
						'value'         => $current_date_time,
						'type'          => 'DATETIME',
					];

					break;

				case "past" :

					$query_args['meta_query'][] = [
						'key'           => 'start_date',
						'compare'       => '<',
						'value'         => $current_date_time,
						'type'          => 'DATETIME',
					];

					break;
			}

		}

		// Creating WP_Query
		$query = new WP_Query($query_args);

		if ($query->have_posts()) {

			// Starting buffer
			ob_start();

			while ($query->have_posts()) {
				$query->the_post();

				// Get Lesson Start Date & Lesson End Date
				$lesson_start_date = DateTime::createFromFormat("Y-m-d H:i:s", get_field("start_date"));
				$lesson_end_date = DateTime::createFromFormat("Y-m-d H:i:s", get_field("end_date"));

				// Calculate Lesson Duration
				$lesson_duration = $lesson_start_date->diff($lesson_end_date)->format("%I");

				// Get Lesson Attachment
				$lesson_attachment = get_field("lesson_attachment");

				// Pasting into buffer .col div
				echo '<div class="col">';

				// Pasting into buffer lessons cards
				get_template_part('template-parts/content', 'lessons', [
					'lesson_start_date' => esc_html($lesson_start_date->format("d.m.Y H:i")),
					'lesson_end_date' => esc_html($lesson_end_date->format("d.m.Y H:i")),
					'lesson_duration' => esc_html($lesson_duration . " minutes"),
					'lesson_attachment' => $lesson_attachment
				]);

				// Closing in buffer .col div
				echo '</div>'; // .col

			}
		} else {

			// Printing an error (Posts not found)
			ob_start();

			get_template_part('template-parts/error-message', 'content', [
				'error_message' => __("No lessons were found for the specified criteria", "leverage-it")
				]);


			$errors[] = ob_get_contents();

			ob_end_clean();
		}

		// Saving buffer into result output
		$html_result_output .= ob_get_contents();

		// Cleaning buffer
		ob_end_clean();

		// Resetting post data
		wp_reset_postdata();

	} else {

		// Printing an error Incorrect nonce (Security)
		ob_start();

		get_template_part('template-parts/error-message', 'content', [
			'error_message' => __("Incorrect nonce (Security)", "leverage-it")
		]);


		$errors[] = ob_get_contents();

		ob_end_clean();
	}


	// Printing results
	echo json_encode([
		'html_output' => $html_result_output,
		'errors' => $errors
	]);


	wp_die();
}
