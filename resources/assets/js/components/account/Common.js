import {config} from "../../bootstrap";

const profileCommon = function () {
    if (config.locked) {
        $('.profile-nav').find(`a[href="#${config.locked}"]`).tab('show');
        $('.profile-nav').find('li:not(.active)').addClass('disabled');
        $(`.tab-pane:not(#${config.locked})`).find('button, input, select, textarea').addClass('disabled').prop('disabled', true);
        $(`.tab-pane:not(#${config.locked})`).find('a').addClass('disabled');
        $('#navbar-collapse-main').find('.navbar-left li:not(.active)').find('a').addClass('disabled').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
    }

    // @note Allow to open a specific tab by givin the hash
    if (document.location.hash) {
        $('.profile-nav').find('a[href="' + document.location.hash + '"]').tab('show');
    }

    $('.profile-nav a').on('shown.bs.tab', function (e) {
        $('.alert').remove();

        if (history.pushState) {
            history.pushState(null, null, e.target.hash);
        } else {
            document.location.hash = e.target.hash;
        }
    });
};

export default profileCommon;
