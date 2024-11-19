/**
 * Internal dependencies
 */
import API from '../modules/api';
import { getLink, getString } from '../modules/utils';
import Notice from '../modules/notice';

/**
 * Update status
 */
export const cache = (e) => {
	e.preventDefault();

	e.target.setAttribute('disabled', 'disabled');
	e.target.setAttribute('aria-busy', 'true');
	e.target.innerText = getString('clearingCache');

	const api = new API();

	api.post('moc_clear_cache')
		.then((response) => {
			if (!api.processResponse(response)) {
				return;
			}

			const notice = new Notice();
			notice.success(getString('cacheCleared'), true);
		})
		.catch(console.log)
		.finally(() => {
			e.target.removeAttribute('disabled');
			e.target.setAttribute('aria-busy', 'false');
			e.target.innerText = getString('clearCache');
		});
};
