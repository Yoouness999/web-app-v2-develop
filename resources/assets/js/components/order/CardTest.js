import {$} from "../../bootstrap";

export default function cardTest() {
    /* Test tool */
    $('.test-payment').each(function () {
        const $payment = $(this);

        $payment.find('a').click(function () {
            const $this = $(this);
            const params = $this.data();

            $payment.find('li').removeClass('active');
            $this.parent('li').addClass('active');

            $('#card_number').val(params.cardNumber).trigger('change').trigger('blur');
            $('#security_code').val(params.securityCode).trigger('change').trigger('blur');
            $('#card_name').val(params.name).trigger('change').trigger('blur');
            $('#iban').val(params.iban).trigger('change').trigger('blur');
            $('#iban_owner').val(params.ibanOwner).trigger('change').trigger('blur');

            if ($('#iban').val() === '') {
                if (typeof params.securityCode != "undefined") {
                    $('#payment_type_credit-card').prop('checked', true).trigger('change').trigger('blur');
                } else {
                    $('#payment_type_credit-card').prop('checked', true).trigger('change').trigger('blur');
                }
            } else {
                $('#payment_type_sepa').prop('checked', true).trigger('change').trigger('blur');
            }

            if (params.expirationDate) {
                const date = params.expirationDate.split('/');

                params.expirationMonth = date[0];
                params.expirationYear = date[1];

                $('#expiration_month').val(params.expirationMonth).trigger('change').trigger('blur');
                $('#expiration_year').val(params.expirationYear).trigger('change').trigger('blur');
            }

            return false;
        });
    });
}