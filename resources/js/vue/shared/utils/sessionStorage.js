/**
 * @param {string} keyName
 * @param {object} keyValue
 */
export const setItem = (keyName, keyValue) =>
    sessionStorage.setItem(keyName, JSON.stringify(keyValue));

/**
 * @param {string} keyName
 */
export const removeItem = keyName => sessionStorage.removeItem(keyName);

/**
 * @param {string} keyName
 * @returns {object} Value of specified key
 */
export const getItem = keyName => JSON.parse(sessionStorage.getItem(keyName));
