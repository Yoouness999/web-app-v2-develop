import {clipboard} from '../../bootstrap';

export default function profileSponsorship() {
    const $form = $('#sponsorship form');
    if (!$form.length) {
        return;
    }

    // @see https://clipboardjs.com/
    $('.js-clipboard').each(function () {
        const $this = $(this);
        const instance = new clipboard('.js-clipboard');

        $this.data('_clipboard', instance);
    });

    // @see https://github.com/DubFriend/jquery.repeater
    $('.js-repeater').each(function () {
        const $this = $(this);
        const options = $.extend({
            initEmpty: false,
            isFirstItemUndeletable: true,
        }, $this.data());

        $this.repeater(options);
    });

    // @see http://jqueryvalidation.org
    let validations = {
        focusInvalid: false,
        errorPlacement: function (error, element) {
            /*if (element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }*/
        },
        highlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').addClass('has-error');
        },
        onfocusout(element) {
            $(element).valid();
        },
        unhighlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        invalidHandler: function (form, validator) {
            if (!validator.numberOfInvalids()) {
                return;
            }

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top - 250,
            }, 200);
        },
        submitHandler:  function (form) {
            form.submit();
        },
    };

    $form.validate(validations);
}