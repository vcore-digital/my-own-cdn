/**
 * Functions for notice management.
 *
 * @since 1.0.0
 */

'use strict';

export default class Notice {
	/**
	 * Try to add errors to forms, based on fields.
	 *
	 * @since 1.0.0
	 * @param {Object} errors Object of errors, where key - form element ID, value - error text.
	 */
	showFormErrors(errors = {}) {
		// Remove existing error messages.
		document
			.querySelectorAll('.moc-ajax-error')
			.forEach((el) => el.remove());

		for (const [type, error] of Object.entries(errors)) {
			const el = document.querySelector(`input#${type}`);

			if (!el) {
				continue;
			}

			el.setAttribute('aria-invalid', 'true');

			// Create error message element.
			const errorElement = document.createElement('small');
			errorElement.className = 'form-error moc-ajax-error';
			errorElement.textContent = String(error);

			// Insert the error message after the input field.
			el.insertAdjacentElement('afterend', errorElement);
		}
	}

	/**
	 * Show error notice.
	 *
	 * @since 1.0.0
	 * @param {string}  message  Message text.
	 * @param {boolean} autoHide Auto hide message.
	 */
	error(message = '', autoHide = false) {
		this.show(message, 'error', autoHide);
	}

	/**
	 * Show success notice.
	 *
	 * @since 1.0.0
	 * @param {string}  message  Message text.
	 * @param {boolean} autoHide Auto hide message.
	 */
	success(message = '', autoHide = false) {
		this.show(message, 'success', autoHide);
	}

	/**
	 * Internal show message method.
	 *
	 * @since 1.0.0
	 * @param {string}  message  Message text.
	 * @param {string}  type     Message type.
	 * @param {boolean} autoHide Auto hide message.
	 */
	show(message, type = 'success', autoHide = false) {
		const notice = document.getElementById('moc-ajax-notice');

		if (!notice) return;

		// Clear existing content.
		notice.innerHTML = '';

		// Add the new message.
		const paragraph = document.createElement('p');
		paragraph.textContent = message;
		notice.appendChild(paragraph);

		// Update notice classes.
		notice.classList.remove('notice-success', 'notice-error');
		notice.classList.add(`notice-${type}`);

		// Show the notice.
		notice.style.display = 'block';

		if (autoHide) {
			setTimeout(() => {
				notice.style.display = 'none';
			}, 5000);
		}
	}
}
