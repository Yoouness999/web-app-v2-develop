import {getFloat, getInt} from "../order/utils";

/**
 * Directive that show the resume of selected Pickup Services
 * @return {function}
 * @constructor
 */
export default function Answers() {
    'ngInject';

    return {
        bindToController: true,
        controllerAs: 'ctrl',
        controller($scope, $filter, globals) {
            'ngInject';

            this.questions = globals.questions || [];
            this.$form = $('#formQuestions');
            this.appointment_total = 0.0;
            this.move_total = 0.0;
            this.floor0Appointment = 0.0;
            this.floor0MoveTotal = 0.0;
            this.busyDay = false;
            this.volume = 0.00;

            $scope.$watch(() => this.answers, (answers) => {
                if(answers.volume && !isNaN(answers.volume)) {
                    this.volume = answers.volume;
                } else {
                    this.volume = 0.00;
                }
                this.refreshResume(answers);
            }, true);

            this.refreshResume = (answers) => {
                this.$form = $('#formQuestions');
                //const $questionFormOpen = this.$form.find('.questions').filter(':visible').length > 0;
                const $model = $($('.order-resume .services').data('model'));
                const $modelEmpty = $($('.order-resume .services').data('model-empty'));
                let $services = [];
                let floor = 0;
                
                this.appointment_total = 0.0;
                if(answers['date']) {                          
                    Object.keys(answers['date']).forEach((id) => {
                        let appointment = answers['date'][id];
                        if(appointment) {
                            this.busyDay = appointment;
                        } else {
                            this.busyDay = false;
                        }
                    });
                }

                this.move_total = 0.0;
                this.floor0Appointment = 0.0;
                this.floor0MoveTotal = 0.0;
                this.$form.find('.question .answer-number > input[data-floor-value="0"]').each($.proxy(function (i, input) {
                    const $input = $(input);
                    let from = getInt($input.data('value-number-from'));
                    let to = getInt($input.data('value-number-to'));
                    if (this.volume > from && this.volume <= to) {
                        this.floor0Appointment = getFloat($input.data('appointment')) * 1.21;
                        this.floor0MoveTotal = this.floor0Appointment;
                        return false;
                    }
                }, this));
                if(answers['number']) {
                    Object.keys(answers['number']).forEach((id) => {
                        const $questions = this.$form.find('.question[data-id="'+id+'"]');
                        if($questions.length > 0) {
                            const $question = $($questions[0]);
                            let appointment = 0.0;
                            const $numberInput = $question.find('input[type="text"]');
                            if ($numberInput.length && $numberInput.val()) {
                                appointment += getFloat($question.data('answer-appointment'));
                                floor = answers['number'][id];
                            }
                            if (!isNaN(appointment)) {
                                let $service;
                                if (appointment > 0) {
                                    appointment = appointment * 1.21;
                                    this.move_total += appointment;
                                    appointment = getFloat(appointment);
                                    this.appointment_total +=appointment;
                                    appointment = appointment.toFixed(2).replace('.', ',');
                    
                                    $service = $model.clone();
                                    //$service.find('.service-appointment').text(appointment);
                                    $service.find('.service-label').text($question.data('answer-label').replace('{floor}', floor));
                                } else {
                                    $service = $modelEmpty.clone();
                                    //$service.find('.service-appointment').text(this.trans('services.appointment.free'));
                                    $service.find('.service-label').text($question.data('answer-label').replace('{floor}', floor));
                                }
                                $services.push($service);
                            }
                        }                        
                    });
                }
                
                if(answers['boolean']) {
                    Object.keys(answers['boolean']).forEach((id) => {
                        const $questions = this.$form.find('.question[data-id="'+id+'"]');
                        if($questions.length > 0) {
                            const $question = $($questions[0]);
                            
                            let floor0Value = 0.0;
                            let val = answers['boolean'][id];
                            $questions.find('.answer-list-'+val+' > span > [name^="targets"]').each($.proxy(function (i, input) {
                                const $input = $(input);
                                let from = getInt($input.data('value-number-from'));
                                let to = getInt($input.data('value-number-to'));
                                let floor_value = getInt($input.data('floor-value'));
                                if (this.volume > from && this.volume <= to && floor_value == 0) {
                                    floor0Value = getFloat($input.data('appointment'));
                                    return false;                                    
                                }
                            }, this));

                            if(!isNaN(floor0Value) && floor0Value > 0) {
                                if ($question.data('slug') == 'carriers') {
                                    floor0Value = floor0Value * 1.21;
                                    this.floor0MoveTotal += floor0Value;
                                //For handling and fragile appointment is considered as percentage value.
                                } else if($question.data('slug') == 'handling' || $question.data('slug') == 'fragile') {
                                    floor0Value = this.floor0MoveTotal * (floor0Value/100);
                                } else if($question.data('slug') == 'parking') {
                                    floor0Value = floor0Value * 1.21;                                    
                                }
                                floor0Value = getFloat(floor0Value);
                                this.floor0Appointment += floor0Value;
                            }

                            let appointment = 0.0;
                            const $booleanInput = $question.find('input[type="radio"]').filter(':checked');
                            if ($booleanInput.length > 0 || $question.data('slug') == 'fragile') {
                                appointment = getFloat($question.data('answer-appointment'));
                            }
                            
                            if (!isNaN(appointment)) {
                                let $service;
                                if (appointment > 0) {
                                    if ($question.data('slug') == 'carriers') {
                                        appointment = appointment * 1.21;
                                        this.move_total += appointment;
                                    //For handling and fragile appointment is considered as percentage value.
                                    } else if($question.data('slug') == 'handling' || $question.data('slug') == 'fragile') {
                                        appointment = this.move_total * (appointment/100);
                                    } else if($question.data('slug') == 'parking') {
                                        appointment = appointment * 1.21;
                                    }
                                    appointment = getFloat(appointment);
                                    this.appointment_total +=appointment;
                                    appointment = appointment.toFixed(2).replace('.', ',');
                    
                                    $service = $model.clone();
                                    //$service.find('.service-appointment').text(appointment);
                                    $service.find('.service-label').text($question.data('answer-label').replace('{floor}', floor));
                                } else {
                                    $service = $modelEmpty.clone();
                                    //$service.find('.service-appointment').text(this.trans('services.appointment.free'));
                                    $service.find('.service-label').text($question.data('answer-label').replace('{floor}', floor));
                                }
                                $services.push($service);
                            }
                        }
                    });
                }
                if(this.busyDay) {
                    this.appointment_total += (this.move_total * (10/100));
                    this.floor0Appointment += (this.floor0MoveTotal * (10/100));
                }
                
                let economy = parseFloat(this.floor0Appointment).toFixed(2).replace('.', ',');
                $('.order-resume').find('.economy .value').text(economy);

                let appointment_total_text = parseFloat(this.appointment_total).toFixed(2).replace('.', ',');

                $('.order-resume .appointment .value').text(appointment_total_text);
                if($services) {
                    $('.order-resume .services.service-items').html($services);
                }
            };

            /**
             * Translate a string
             *
             * @param str
             * @returns {*}
             */
            this.trans = function (str) {
                let translation = $filter('translate')(str);

                if (translation === str) {
                    translation = $filter('labels')(str);
                }

                return translation;
            };
        },
        link() {
            /* Make resume block always visible */
            const $block = $('.order-resume');
            const $section = $block.parents('section');
            let blockMaxTop = 320;

            $(window).scroll(function () {
                let blockMaxBottom = getInt($section.height()) - getInt($block.height()) - 15;
                let scrollTop = $(this).scrollTop();

                if (scrollTop >= blockMaxTop && scrollTop <= blockMaxBottom) {
                    $block.removeClass('bottom').addClass('fixed');
                } else if ($(this).scrollTop() > blockMaxBottom) {
                    $block.removeClass('fixed').addClass('bottom');
                } else {
                    $block.removeClass('fixed').removeClass('bottom');
                }
            });
        },
        restrict: 'E',
        scope: {
            answers: '=data',
            buttonVisible: '=buttonVisible',
            callback: '&onClick',
        },
        templateUrl: '/assets/html/answers.html',
    };
}