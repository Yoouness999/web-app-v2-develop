import {config} from "../../bootstrap";

const profilePassword = function () {
    const $form = $('#password form');
    if (!$form.length) {
        return;
    }

    // @see http://jqueryvalidation.org
    let validations = {
        errorPlacement: function (error, element) {
            if (element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').addClass('has-error');
        },
        onfocusout(element) {
            if ($(element).is(':input')) {
                $(element).valid();
            }
        },
        unhighlight(element/*, errorClass, validClass*/) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        submitHandler:  function (form) {
            form.submit();
        },
    };

    $form.validate($.extend(validations, {
        rules: {
            /*'password_current': {
                minlength: 8,
            },*/
            'password': {
                minlength: 8,
            },
            'password_confirmation': {
                equalTo: 'input[name="password"]',
                minlength: 8,
            },
        },
    }));
};

export default profilePassword;
