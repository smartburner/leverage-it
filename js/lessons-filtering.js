jQuery(document).ready(function ($) {

	// Filtering form
	const filteringForm = $(".lessons-filtering-form");

	// Lessons Cards row
	const lessonsCardsRow = $(".lessons-cards-row");

	// On Form Change - Creating Ajax Request for the filtering lessons
	filteringForm.on('change', function () {

		jQuery.ajax({
			url: ajax_obj.ajaxurl,
			data: {
				action: "filter_lessons",
				security_nonce: ajax_obj.les_filter_nonce,
				filtering_data: filteringForm.serialize()
			},
			type: "post",
			beforeSend: function (xhr) {

				// Disable Form Controls during request
				filteringForm.find("input, select").attr("disabled", true);

				// Preloader
				lessonsCardsRow.html('<div class="w-100 mt-5 text-center">' +
					'<div class="spinner-border" role="status">' +
					'  <span class="visually-hidden">Loading...</span>' +
					'</div>' +
					'</div>');

			},
			success: function (data) {

				// Parsing JSON
				let requestResult = jQuery.parseJSON(data);

				// Checking Backend Errors
				if (requestResult.errors.length === 0) {

					// Printing Results
					lessonsCardsRow.html(requestResult.html_output);

				} else {
					// Printing the errors

					let requestErrors = requestResult.errors;

					// Cleaning HTML before printing the errors
					lessonsCardsRow.empty();

					// Printing the errors
					for (const requestError of requestErrors) {
						lessonsCardsRow.append(requestError);
					}

				}

				// Disable Form Controls during request
				filteringForm.find("input, select").removeAttr("disabled");
			}
		});

	});


});
