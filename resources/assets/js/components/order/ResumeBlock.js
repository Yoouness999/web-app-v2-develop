import {getInt} from './utils';

/**
 * Order resume block
 */
export default function orderResumeBlock() {
    const $block = $('.order-resume.following');
    if (!$block.length) {
        return;
    }

    const $parent = $block.parent('.order-resume-wrapper');

    /* Make resume block always visible */
    const $section = $block.parents('section');
    let blockMaxTop = 127;

    $(window).scroll(function () {
        let blockMaxBottom = $section.height() - $block.height() - 15;
        let scrollTop = $(this).scrollTop();

        // set minimum size of the column
        if ($block.outerHeight() > $parent.height()) {
            $parent.height($block.outerHeight());
        }

        if (scrollTop >= blockMaxTop && scrollTop <= blockMaxBottom) {
            $block.removeClass('bottom').addClass('fixed');
        } else if ($(this).scrollTop() > blockMaxBottom) {
            $block.removeClass('fixed').addClass('bottom');
        } else {
            $block.removeClass('fixed').removeClass('bottom');
        }
    });
}
