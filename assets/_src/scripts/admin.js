'use strict';

/**
 * Internal dependencies
 */
import '../styles/admin.scss';
import API from './modules/api';
import { getLink } from './modules/utils';

/**
 * MOC class.
 *
 * @since 1.0.0
 */
class MOC {
	/**
	 * Class constructor.
	 */
	constructor() {
		this.api = new API();

		const apiKeyForm = document.getElementById('moc-api-key-form');
		if (apiKeyForm) {
			this.processApiKeyForm = this.processApiKeyForm.bind(this);
			apiKeyForm.addEventListener('submit', this.processApiKeyForm);
		}

		const setupForm = document.getElementById('moc-provider-form');
		if (setupForm) {
			this.processSetupForm = this.processSetupForm.bind(this);
			setupForm.addEventListener('submit', this.processSetupForm);
		}

		const logoutButton = document.getElementById('moc-logout-btn');
		if (logoutButton) {
			this.logout = this.logout.bind(this);
			logoutButton.addEventListener('click', this.logout);
		}
	}

	/**
	 * Process API token form.
	 *
	 * @since 1.0.0
	 */
	processApiKeyForm(e) {
		e.preventDefault();

		this.removeFormErrors();

		const submitButton = document.getElementById('moc-save-btn');
		submitButton.setAttribute('aria-busy', 'true');

		const data = {
			token: document.getElementById('api-key').value,
		};

		this.api
			.post('moc_update_key', data)
			.then((response) => {
				if (!this.api.processResponse(response)) {
					return;
				}

				window.location.href = getLink('pluginURL');
			})
			.catch(console.log)
			.finally(() => {
				submitButton.setAttribute('aria-busy', 'false');
			});
	}

	/**
	 * Process provider setup form.
	 */
	processSetupForm(e) {}

	/**
	 * Logout.
	 */
	logout(e) {
		e.preventDefault();

		this.api
			.post('moc_logout')
			.then(() => {
				window.location.href = getLink('pluginURL');
			})
			.catch(console.log);
	}

	/**
	 * Remove form errors and hide notices.
	 *
	 * @since 1.0.0
	 */
	removeFormErrors() {
		document
			.querySelectorAll('.moc-ajax-error')
			.forEach((element) => element.remove());
		document.getElementById('moc-ajax-notice').style.display = 'none';
	}
}

const MyOwnCDN = new MOC();
window.MyOwnCDN = MyOwnCDN;
