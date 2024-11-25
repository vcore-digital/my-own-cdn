/**
 * Internal dependencies
 */
import API from '../modules/api';
import { getLink } from '../modules/utils';

/**
 * Remove form errors and hide notices.
 *
 * @since 1.0.0
 */
const removeFormErrors = () => {
	document
		.querySelectorAll('.moc-ajax-error')
		.forEach((element) => element.remove());
	document.getElementById('moc-ajax-notice').style.display = 'none';
};

/**
 * Enable provider form.
 *
 * @since 1.0.0
 */
export const enable = (e) => {
	e.preventDefault();

	removeFormErrors();

	const submitButton = document.getElementById('moc-provider-btn');
	submitButton.setAttribute('aria-busy', 'true');

	const data = {
		provider: document.getElementById('provider').value,
	};

	const api = new API();

	api.post('moc_enable', data)
		.then((response) => {
			if (!api.processResponse(response)) {
				return;
			}

			window.location.href = getLink('pluginURL');
		})
		.catch(console.log)
		.finally(() => {
			submitButton.setAttribute('aria-busy', 'false');
		});
};
