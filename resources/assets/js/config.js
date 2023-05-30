window.dataLayer = window.dataLayer || [];

/**
 * Configuration object
 * @note `config` is a reference to window.__app
 * @type {Object}
 */
export default Object.assign(window.__app, {
    debug: false,
    labels: Object.assign({}, window.__app.labels || {}, window.__labels || {}),
    //sheldonCooperSays: 'Scissors cuts paper, paper covers rock, rock crushes lizard, lizard poisons Spock, Spock smashes scissors, scissors decapitates lizard, lizard eats paper, paper disproves Spock, Spock vaporizes rock, and as it always has, rock crushes scissors.'
}, window.__app);
