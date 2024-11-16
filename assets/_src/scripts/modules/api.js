/**
 * Functions for API calls.
 *
 * @since 1.0.0
 */

'use strict';

import Notice from './notice';

/* global MOCJS */
/* global ajaxurl */

export default class API {
	/**
	 * Do AJAX request to WordPress.
	 *
	 * @since 1.0.0
	 * @param {string} action Registered AJAX action.
	 * @param {Object} data   Additional data that needs to be passed in POST request.
	 * @return {Promise<unknown>} Return data.
	 */
	post(action, data = {}) {
		return new Promise((resolve, reject) => {
			const { nonce } = MOCJS;
			fetch(ajaxurl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: new URLSearchParams({
					_ajax_nonce: nonce,
					action,
					...data,
				}),
			})
				.then((response) => {
					if (!response.ok) {
						throw new Error(
							`HTTP error! status: ${response.status}`
						);
					}
					return response.json();
				})
				.then((data) => resolve(data))
				.catch((error) => reject(error));
		});
	}

	/**
	 * Process API response.
	 *
	 * @since 1.0.0
	 *
	 * @param {Object} response API response.
	 * @return {boolean} Return false on issues with response. True on success.
	 */
	processResponse(response) {
		const notice = new Notice();

		// Unsuccessful request.
		if (!response.success) {
			notice.error(response.data);
			return false;
		}

		// Exception.
		if (response.data.exception && response.data.message) {
			notice.error(response.data.message);
			return false;
		}

		// Error in the form.
		if (response.data.errors && response.data.message) {
			notice.error(response.data.message);
			notice.showFormErrors(response.data.errors);
			return false;
		}

		return true;
	}
}
