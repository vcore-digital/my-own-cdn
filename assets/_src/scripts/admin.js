'use strict';

/**
 * Internal dependencies
 */
import '../styles/admin.scss';
import { login } from './actions/login';
import { logout } from './actions/logout';
import { status } from './actions/status';
import { cache } from './actions/cache';

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
		this.bindEvents();
	}

	/**
	 * Binds event listeners to DOM elements.
	 */
	bindEvents() {
		this.addEventListener('moc-api-key-form', 'submit', login);
		this.addEventListener('moc-logout-btn', 'click', logout);
		this.addEventListener('moc-status-btn', 'click', status);
		this.addEventListener('moc-clear-cache', 'click', cache);
	}

	/**
	 * Adds an event listener to a DOM element if it exists.
	 *
	 * @param {string}   elementId The ID of the DOM element.
	 * @param {string}   eventType The event type (e.g., 'click').
	 * @param {Function} callback  The event callback function.
	 */
	addEventListener(elementId, eventType, callback) {
		const element = document.getElementById(elementId);
		if (element) {
			element.addEventListener(eventType, callback);
		}
	}
}

document.addEventListener('DOMContentLoaded', () => {
	window.MyOwnCDN = new MOC();
});
