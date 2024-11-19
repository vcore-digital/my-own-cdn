/**
 * Internal dependencies
 */
import API from '../modules/api';
import { getLink, getString } from '../modules/utils';

/**
 * Update status
 */
export const status = (e) => {
	e.preventDefault();

	e.target.setAttribute('disabled', 'disabled');
	e.target.setAttribute('aria-busy', 'true');
	e.target.innerText = getString('updating');

	const api = new API();

	api.post('moc_update_status')
		.then((response) => {
			if (!api.processResponse(response)) {
				return;
			}

			window.location.href = getLink('pluginURL');
		})
		.catch(console.log)
		.finally(() => {
			e.target.removeAttribute('disabled');
			e.target.setAttribute('aria-busy', 'false');
			e.target.innerText = getString('refreshStatus');
		});
};
