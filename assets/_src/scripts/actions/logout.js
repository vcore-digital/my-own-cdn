/**
 * Internal dependencies
 */
import API from '../modules/api';
import { getLink } from '../modules/utils';

/**
 * Logout callback
 */
export const logout = (e) => {
	e.preventDefault();

	const api = new API();

	api.post('moc_logout')
		.then(() => {
			window.location.href = getLink('pluginURL');
		})
		.catch(console.log);
};
