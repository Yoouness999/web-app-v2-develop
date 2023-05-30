import I18n from '../utils/I18n';

export default function LaravelLangFilter() {
    const language = window.__app.lang || 'en';
    const source = Object.assign({}, window.__labels);

    const labels = new I18n(source, language);
    return function (key, data = null) {
        if (data) {
            return labels.format(key, data, null, ['--', '--']);
        }

        return labels.get(key);
    };
}