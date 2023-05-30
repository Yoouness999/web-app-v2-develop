import {angular} from '../../bootstrap';
import BaseController from '../../shared/controllers/BaseController';
import {getInt} from "../order/utils";

/**
 * Display the Pickup Services form
 */
export default class QuestionsController extends BaseController {
    /**
     * @ngInject
     */
    constructor($scope, $state, $filter, $uibModal, ApiProfile, globals, $timeout) {
        super($scope, $state, $filter, $uibModal, ApiProfile, globals, $timeout);

        //this.answers = globals.answers || [];
        this.questions = globals.questions || [];
        this.$form = $('#formQuestions');
        this.model = null;
        this.formErrors = null;
        this.formSuccess = false;
        this.selectedFloor = 0;
        this.volume = 0.00;
        this.isFragile = false;

        this.$scope.$watch(() => this.ngShow, (visible) => {
            if (visible) {
                this.formErrors = null;
                this.formSuccess = false;
            }
        });

        // update answers
        this.$scope.$watch(() => this.answers, (answers) => {
            if (answers) {
                if(answers.volume && !isNaN(answers.volume)) {
                    this.volume = answers.volume;
                } else {
                    this.volume = 0.00;
                }
                if(answers.isFragile) {
                    this.isFragile = true;
                } else {
                    this.isFragile = false;
                }
                this.answers = answers;
            }
        }, true);

        //this.$timeout(() => this.prefill(this.answers), 500);
    }

    /**
     * @param answers
     */
    /*prefill(answers) {
        if (answers) {
            this.model = answers;
            this.$form.find('.continue').hide();

            Object.keys(this.model).forEach((key) => {
                Object.keys(this.model[key]).forEach((id) => {
                    const $nextQuestion = this.$form.find(`.question[data-id="${id}"]`);

                    $nextQuestion.find('input[type="text"]').removeClass('active');
                    $nextQuestion.find('input[type="radio"]').prop('checked', false);
                    $nextQuestion.fadeIn('fast');
                });
            });
        }
    }*/

    /**
     * @param e
     * @param answer
     */
    onAnswerChange(e, item, target) {
        this.answers.completed = false;
        let $this = $(e.currentTarget);
        if(target) {
            $this = $(target);
        }

        const $question = $this.parents('.question');
        let $nextQuestion;


        /* Hide following questions */
        if($question.data('slug') != 'fragile') {
            $question.addClass('active');
        }
        $question.nextAll('.question').removeClass('active');
        $question.nextAll('.question').each($.proxy(function (i, hiddenQuestion) {
            const $hiddenQuestion = $(hiddenQuestion);
            if(this.answers[$hiddenQuestion.data('type')] && this.answers[$hiddenQuestion.data('type')][$hiddenQuestion.data('id')]) {
                delete this.answers[$hiddenQuestion.data('type')][$hiddenQuestion.data('id')];
            }
        }, this));
        if (item.questionType === 'boolean') {
            let floor = this.selectedFloor;
            if($question.data('slug') == 'handling' || $question.data('slug') == 'fragile') {
                floor = 0;
            }
            const $booleanInput = $question.find('input[type="radio"][value="'+item.questionValue+'"]');
            let val = $booleanInput.val();
            if (val=='yes' || val=='no') {
                $this.parent().find('.answer-list-'+val+' > span > [name^="targets"]').each($.proxy(function (i, input) {
                    const $input = $(input);
                    let from = getInt($input.data('value-number-from'));
                    let to = getInt($input.data('value-number-to'));
                    let floor_value = getInt($input.data('floor-value'));
                    if (this.volume > from && this.volume <= to && floor_value == floor) {
                        /* Update the question data to use them later */
                        $question.data('answer-appointment', $input.data('appointment'));
                        $question.data('answer-label', $input.data('label'));
                        $nextQuestion = this.$form.find('.question[data-id="' + $input.val() + '"]');
                        if(!this.answers.boolean) {
                            this.answers.boolean = {};
                        }
                        this.answers.boolean[$question.data('id')] = val;
                        if($question.data("slug") == 'parking') {
                            this.answers.completed = true;
                        }
                        return false;
                    } else {
                        //$question.data('answer-appointment', 0);
                        //$question.data('answer-label', $input.data('label'));
                    }
                }, this));
            }
        } else if (item.questionType === 'number') {
            let val = $this.parents('.increment-wrapper').find('input').val();
            $this.parents('.increment-wrapper').find('input').addClass('active');
            if(isNaN(val)) {
                val = 0;
            } else if (item.increment) {
                if (item.increment === 'add') {
                    val++;
                } else {
                    val--;
                }
            }

            if (val < -2) {
                val = -2;
            } else if(val > 14) {
                val = 14;
            }
            // update text field
            $this.parents('.increment-wrapper').find('input').val(val);

            /* Answer is a number, we need to find the matching range */
            $this.parents('.answer-number').find('[name^="targets"]').each($.proxy(function (i, input) {
                const $input = $(input);
                let from = getInt($input.data('value-number-from'));
                let to = getInt($input.data('value-number-to'));
                let floor_value = getInt($input.data('floor-value'));
                this.selectedFloor = val;
                /* Careful for this kind of values : from: 1, to: 0, the to is infinite. */
                if (this.volume > from && this.volume <= to && floor_value == val) {
                    /* Update the question data to use them later */
                    $question.data('answer-appointment', $input.data('appointment'));
                    $question.data('answer-label', this.trans($input.data('label')));
                    if(!this.answers.number) {
                        this.answers.number = {};
                    }
                    this.answers.number[$question.data('id')] = val;
                    $nextQuestion = this.$form.find('.question[data-id="' + $input.val() + '"]');
                    return false;
                } else {
                    //$question.data('answer-appointment', 0);
                    //$question.data('answer-label', this.trans($input.data('label')));
                }

            }, this));
        }

        if ($nextQuestion && $nextQuestion.length) {
            this.$form.find('.continue').removeClass('active');

            $nextQuestion.find('input[type="text"]').removeClass('active').val(0);
            $nextQuestion.find('input[type="radio"]').prop('checked', false);
            if($nextQuestion.data('slug') == 'fragile') {
                if(this.isFragile) {
                    this.onAnswerChange(e, {
                        'id': $nextQuestion.data('id'),
                        'questionType': $nextQuestion.data('type'),
                        'questionValue': 'yes'
                    }, $nextQuestion.find(".anwser-yes")[0]);
                } else {
                    this.onAnswerChange(e, {
                        'id': $nextQuestion.data('id'),
                        'questionType': $nextQuestion.data('type'),
                        'questionValue': 'no'
                    }, $nextQuestion.find(".anwser-no")[0]);
                }
            } else {
                $nextQuestion.addClass('active');
            }
        } else {
            this.$form.find('.continue').addClass('active');
        }
    }

    /**
     * Reset the answers and run callback
     */
    onCancel() {
        // reset answers
        //this.answers = Object.assign({}, {});
        // this.$timeout(() => this.prefill(this.answers), 1000);

        $('html,body').animate({scrollTop: $('.manager-search').offset().top - 20});

        this.callback({from: 'questions-cancel',floor: this.selectedFloor});
    }

    /**
     * Save the answers via AJAX and store the new answers in globals
     */
    onSubmit() {
        if(!this.answers.completed) {
            this.setError('incomplete', 'Please answers all questions to proceed further.');
        } else {
            this.formSuccess = true;
            // update global reference
            this.globals.answers = this.answers;
            $('html,body').animate({scrollTop: $('.manager-search').offset().top - 20});
            this.callback({from: 'questions', floor: this.selectedFloor});
        }
    }

    /**
     * SetError handler
     */
    setError(key, value) {
        if (!this.formErrors) {
            this.formErrors = {};
        }

        this.formErrors[key] = value;
    }

    /**
     * Translate a string
     *
     * @param str
     * @returns {*}
     */
    trans(str) {
        let translation = this.$filter('translate')(str);

        if (translation === str) {
            translation = this.$filter('labels')(str);
        }

        return translation;
    }
}
