/**
 * Various helper functions.
 *
 * @since 1.0.0
 */

/* global MOCJS */

'use strict';

/**
 * Get link from localized object.
 *
 * @param {string} str
 * @return {*|string} String
 */
export const getLink = (str) => {
	return MOCJS.links[str] || '';
};
