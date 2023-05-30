import {getInt} from './utils';

/**
 * Increment input
 */
export default function orderIncrementInput() {
    $('.increment-wrapper').each(function () {
        const $this = $(this);
        const $input = $this.find('input[type="text"]');
        const options = $.extend({
            max: 14,
            min: -2,
        }, $this.data());

        let interval = null;

        // Increment item count
        $this.find('.increment-add')
            .on('mousedown', function () {
                interval = setInterval(increment, 500);
            })
            .on('mouseup mouseleave', () => clearInterval(interval))
            .click(increment);

        // Decrement item count, cannot be under 0
        $this.find('.increment-remove')
            .on('mousedown', function () {
                interval = setInterval(decrement, 500);
            })
            .on('mouseup mouseleave', () => clearInterval(interval))
            .click(decrement);

        // Change item count, have to be a integer greater than 0
        $input
            .on('change', format)
            .on('keydown', keydown)
            .on('reset', reset);


        function decrement() {
            let val = getInt($input.val()) - 1;
            $input.val(val).trigger('change');
        }

        function increment() {
            let val = parseInt($input.val(), 10);

            if (val || val === 0) {
                val++;
            } else {
                val = 0;
            }

            $input.val(val).trigger('change');
        }

        function format() {
            const $el = $(this);

            let val = parseInt($el.val(), 10);

            if (val || val === 0) {
                if (val < options.min) {
                    val = options.min;
                } else if (options.max && val > options.max) {
                    val = options.max;
                }
            } else {
                val = '';
            }

            $el.val(val);

            // @note - Add "active" class if data-default-value is different than value or, if there is not data-default-value, if value is higher than min
            $el.toggleClass('active', val !== $el.data('default-value') || (!$el.data().hasOwnProperty('defaultValue') && val > options.min));

            // trigger "change" on wrapper
            $this.trigger('change');
        }

        function reset() {
            const $el = $(this);

            if ($el.data().hasOwnProperty('defaultValue')) {
                $el.val($el.data('default-value'));
            } else {
                $el.val(options.min);
            }

            $el.trigger('change');
        }

        function keydown(e) {
            if (e.keyCode === 38) {
                e.preventDefault();
                increment();
            } else if (e.keyCode === 40) {
                e.preventDefault();
                decrement();
            }
        }
    });
}