/**
 * Simple I18n wrapper around a global object.
 * @example
 * import I18n from '@js/features/I18n.js';
 *
 * const i18n = new I18n({
 *     'foo': 'bar',
 * }, 'en');
 *
 * i18n.add({'baz': 'Hello {{word}}!'});
 *
 * alert(i18n.get('foo')); // return 'bar'
 * alert(i18n.format('foo', {word: 'wold'}); // return 'Hello world!'
 */
export default class I18n {
    /**
     * @example
     * const i18n = new I18n({
     *     'foo': 'bar',
     * });
     *
     * @param {Object} labels
     * @param {String} defaultLanguage (default: 'en')
     */
    constructor(labels = {}, defaultLanguage = 'en') {
        this._language = defaultLanguage;
        this._labels = {};
        this._labels[this._language] = labels;
    }

    /**
     * Set labels in current language
     * @example
     * i18n.labels = {
     *     'foo': 'bar',
     * };
     * @param {Object} value
     */
    set labels(value) {
        this._labels[this._language] = value;
    }

    /**
     * Get labels in current language
     * @return {Object}
     */
    get labels() {
        return this._labels[this._language];
    }

    /**
     * Set the current language
     * @example
     * i18n.language = 'en';
     * @param {String} value
     */
    set language(value) {
        this._language = value;
    }

    /**
     * Get the current language
     * @return {String}
     */
    get language() {
        return this._language;
    }

    /**
     * Add labels to a given language
     * @example
     * i18n.add({
     *     'foo': 'bar',
     * }, 'en');
     * @param {Object} labels
     * @param {String} language (default: this._language)
     */
    add(labels, language = null) {
        if (!language) {
            language = this._language;
        }

        this._labels[language] = Object.assign(this._labels[language] || {}, labels);
    }

    /**
     * Decode HTML Entities
     * @param {String} source
     * @return {String}
     */
    static decodeHtml(source) {
        const txt = document.createElement('textarea');
        txt.innerHTML = source;
        return txt.value;
    }

    /**
     * Retrieve a label
     * @example
     * i18n.fetch('en.foo'); // return 'bar'
     * @param {String} key
     * @return {*}
     */
    fetch(key) {
        key = key.split('.');

        let source = this._labels;

        for (let i = 0, len = key.length; i < len && source; i++) {
            source = source[key[i]];
        }

        return source;
    }

    /**
     * Minimalist template engine@example
     * i18n.add('baz', 'Hello {{word}}!');
     * i18n.format('baz', {word: 'world'}, 'en'); // return 'Hello world'
     * @param {String} key
     * @param {Object} data
     * @param {String} language (default: this._language)
     * @param {Array} options
     * @return {String}
     */
    format(key, data, language = null, options = ['{{', '}}']) {
        if (!language) {
            language = this._language;
        }

        let template = this.get(key, language);

        for (let p in data) {
            template = template.replace(new RegExp(`${options[0]}${p}${options[1]}`, 'g'), data[p]);
        }

        return template;
    }

    /**
     * Get a specific label
     * @example
     * i18n.get('foo', 'en'); // return 'bar'
     * @param {String} key
     * @param {String} language (default: this._language)
     * @return {*}
     */
    get(key, language = null) {
        if (!language) {
            language = this._language;
        }

        let content = this.fetch(`${language}.${key}`);

        if (!content) {
            return key;
        }

        if (typeof content === 'string') {
            return I18n.decodeHtml(content);
        }

        return content;
    }
}
