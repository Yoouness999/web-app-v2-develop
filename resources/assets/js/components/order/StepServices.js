import {getFloat, getInt, tpl} from './utils';

/**
 * Step 2 : Services
 */
export default function orderServices() {
    const $form = $('.order-services-form');
    let $selectedFloor = 0;
    if (!$form.length) {
        return;
    }

    /* Prevent user to submit form by hitting "enter" */
    $form.bind('keypress', function (e) {
        if (e.keyCode === 13) {
            return false;
        }
    });

    /* When choosing an answer, show the next question */
    $form.find('[name^="answers"]').change(function () {
        const $volume = $('.order-services-form input#order-volume').data('volume');
        const $this = $(this);
        const options = $this.data();
        const $question = $this.parents('.question');
        let $nextQuestion = null;

        /* Hide following questions */
        $this.parent('.question').addClass('active');
        $this.parents('.question').nextAll('.question').removeClass('active');

        if (options.questionType === 'boolean') {
            let floor = $selectedFloor;
            if($question.data('slug') == 'handling' || $question.data('slug') == 'fragile') {
                floor = 0;
            }
            let val = $this.val();
            if (val=='yes' || val=='no') {
                $this.parent().find('.answer-list-'+val+' > [name^="targets"]').each(function () {
                    const $input = $(this);
                    let from = getInt($input.data('value-number-from'));
                    let to = getInt($input.data('value-number-to'));
                    let floor_value = getInt($input.data('floor-value'));
                    if ($volume > from && $volume <= to && floor_value == floor) {
                        /* Update the question data to use them later */
                        $question.data('answer-appointment', $input.data('appointment'));
                        $question.data('answer-appointment-alt', $input.data('appointment-alt'));
                        $question.data('answer-label', $input.data('label'));
                        $nextQuestion = $form.find('.question[data-id="' + $input.val() + '"]');
                    } else {
                        $question.data('answer-label', $input.data('label'));
                    }
                    if($volume > from && $volume <= to && floor_value == 0) {
                        $question.data('floor0-answer-appointment', $input.data('appointment'));
                        $question.data('floor0-answer-appointment-alt', $input.data('appointment-alt'));
                    }
                });
            } else {
                return;
            }
        } else if (options.questionType === 'number') {
            let val = parseInt($this.val(), 10);

            if (val || val === 0) {
                /* Answer is a number, we need to find the matching range */
                $this.parents('.answer-number').find('[name^="targets"]').each(function () {
                    const $input = $(this);
                    let from = getInt($input.data('value-number-from'));
                    let to = getInt($input.data('value-number-to'));
                    let floor_value = getInt($input.data('floor-value'));
                    /* Careful for this kind of values : from: 1, to: 0, the to is infinite. */
                    if ($volume > from && $volume <= to && floor_value == val) {
                        /* Update the question data to use them later */
                        $question.data('answer-appointment', $input.data('appointment'));
                        $question.data('answer-appointment-alt', $input.data('appointment-alt'));
                        $question.data('answer-label', $input.data('label'));
                        $selectedFloor = floor_value;
                        $nextQuestion = $form.find('.question[data-id="' + $input.val() + '"]');
                    }
                    if($volume > from && $volume <= to && floor_value == 0) {
                        $question.data('floor0-answer-appointment', $input.data('appointment'));
                        $question.data('floor0-answer-appointment-alt', $input.data('appointment-alt'));
                    }
                });
            } else {
                return;
            }
        }

        if ($nextQuestion && $nextQuestion.length) {
            $form.find('.continue').removeClass('active');

            /* Reset next answers question */
            $nextQuestion.find('input[type="text"]').removeClass('active').val(0);
            $nextQuestion.find('input[type="radio"]').prop('checked', false);
            $nextQuestion.addClass('active');

            if ($nextQuestion.find('.increment-wrapper').length) {
                $nextQuestion.find('.increment-wrapper').find('input').trigger('reset');
            }
        } else {
            $form.find('.continue').addClass('active');
        }

        /* Update the resume bloc */
        orderServicesRefreshResume();
    });

    $form.submit(function (e) {
        e.preventDefault();

        // @note - Prevent multiple submit
        $form.find('button[type="submit"]').addClass('btn-loading');

        // /!\ disable unused inputs
        $form.find('.question.first').addClass('active');
        $form.find('.question:not(.active)').addClass('disabled').find(':input').prop('disabled', true);

        this.submit();
    });
}

function orderServicesRefreshResume() {
    const $form = $('.order-services-form');
    if (!$form.length) {
        return;
    }

    const $model = $($form.find('.order-resume .services').data('model'));
    const $modelEmpty = $($form.find('.order-resume .services').data('model-empty'));
    let appointment_total = 0.0;
    let floor0AppointmentTotal = 0.0;
    let floor0MoveTotal = 0.0;
    let move_total = 0.0;
    let $services = [];
    let floor = getInt($form.find('.question').filter(':visible').find('.answer-number input[type="text"]').val());

    $form.find('.question').filter(':visible').each(function () {
        const $question = $(this);
        let appointment = 0.0;
        let floor0Appointment = 0.0
        let appointmentAlt = 0.0;
        let floor0AppointmentAlt = 0.0
        
        const $booleanInput = $question.find('input[type="radio"]').filter(':checked');
        if ($booleanInput.length) {
            appointment = $question.data('answer-appointment');
            floor0Appointment = $question.data('floor0-answer-appointment');
            appointmentAlt = $question.data('answer-appointment-alt');
            floor0AppointmentAlt = $question.data('floor0-answer-appointment-alt');
        }

        const $numberInput = $question.find('input[type="text"]');
        if ($numberInput.length && $numberInput.val()) {
            appointment = $question.data('answer-appointment');
            floor0Appointment = $question.data('floor0-answer-appointment');
            appointmentAlt = $question.data('answer-appointment-alt');
            floor0AppointmentAlt = $question.data('floor0-answer-appointment-alt');
        }

        let $service;

        if (appointment || appointment === 0.0) {
            if (appointment > 0) {
                //appointment = appointment);
                if ($question.data('slug') == 'carriers' || $question.data('slug') == 'floors') {
                    appointment = appointment * 1.21;
                    move_total += appointment;
                //For handling and fragile appointment is considered as percentage value.
                } else if($question.data('slug') == 'handling' || $question.data('slug') == 'fragile') {
                    if(floor == 0) {
                        appointment = getFloat(appointmentAlt) * 1.21;
                    } else {
                        appointment = move_total * (appointment/100);
                    }
                } else if($question.data('slug') == 'parking') {
                    appointment = appointment * 1.21;
                }
                appointment = getFloat(appointment);
                appointment_total += appointment;
                appointment = appointment.toFixed(2).replace('.', ',');

                $service = $model.clone();
                //$service.find('.service-appointment').text(appointment);
                $service.find('.service-label').text(tpl($question.data('answer-label'), {floor}));
            } else {
                $service = $modelEmpty.clone();
                $service.find('.service-appointment').text("");
                $service.find('.service-label').text($question.data('answer-label'));
            }
            $services.push($service);
        }
        if(floor0Appointment || floor0Appointment == 0.0) {
            if (floor0Appointment > 0) {
                if ($question.data('slug') == 'carriers' || $question.data('slug') == 'floors') {
                    floor0Appointment = floor0Appointment * 1.21;
                    floor0MoveTotal += floor0Appointment;
                //For handling and fragile appointment is considered as percentage value.
                } else if($question.data('slug') == 'handling' || $question.data('slug') == 'fragile') {
                    floor0Appointment = getFloat(floor0AppointmentAlt) * 1.21;
                } else if($question.data('slug') == 'parking') {
                    floor0Appointment = floor0Appointment * 1.21;
                }
                floor0Appointment = getFloat(floor0Appointment);
                floor0AppointmentTotal += floor0Appointment;
            }
        }
    });

    let economy = parseFloat(floor0AppointmentTotal).toFixed(2).replace('.', ',');

    $form.find('.economy .value').text(economy);

    appointment_total = parseFloat(appointment_total).toFixed(2).replace('.', ',');

    $form.find('.order-resume .appointment .value').text(appointment_total);
    $form.find('.order-resume .services').html($services);
}