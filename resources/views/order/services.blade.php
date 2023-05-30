<?php
/**
 * @var $order Order
 */
?>
@extends('layouts.default')

@section('navbar-default')
	<nav class="navbar navbar-default navbar-fixed-top  no-transition">
@stop

@section('content')
	<form class="order-services-form" action="<?= url('/order/services') ?>" method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

		@include('order.breadcrumb', ['step' => 2])

		<section class="section section-services text-center bg-gray-lighter-ultra">
			<div class="container">
				<h1><?= lg('order.services.title') ?></h1>

				<div class="row order-content-table">
					<div class="col-md-9 order-content-wrapper">
						<input type="hidden" name="order_volume" id="order-volume" value="<?= $order->plan->volume_m3 ?>" data-volume="<?= $order->plan->volume_m3 ?>"/>
						<div class="questions">
							@foreach ($questions as $question)
								<div class="question @if ($question->isFirst($order)) first @endif" data-id="<?= $question->id ?>" data-slug="<?= $question->slug ?>">
									<p class="image">
										<img src="<?= asset('assets/img/order/services/questions/' . $question->slug . '.svg') ?>" alt="" />
									</p>
									<p class="content">
										<?= lg('order.services.questions.' . $question->slug) ?>

                                        @if(!empty(lg('order.tooltips.services.' . $question->slug)))
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?= lg('order.tooltips.services.' . $question->slug) ?>"></i>
                                        @endif

										@if ($question->type == 'number')
											<span class="answer-number">
												<span class="increment-wrapper">
													<input type="text" name="answers[<?= $question->type ?>][<?= $question->id ?>]" autocomplete="off" data-default-value="" data-question-type="<?= $question->type ?>" />
                                                    <span class="increment-buttons">
														<button type="button" class="increment-add">+</button>
														<button type="button" class="increment-remove">-</button>
													</span>
												</span>

												@foreach ($question->answers(false, $order->plan->volume_m3, 'pickup')->get() as $answer)
													<input type="hidden" name="targets[<?= $answer->id ?>]" value="<?= $answer->getQuestionTargetId() ?>" data-value-number-from="<?= $answer->value_number_from ?>" data-value-number-to="<?= $answer->value_number_to ?>" data-floor-value="<?= $answer->floor_value ?>" data-appointment="<?= $answer->appointment ?>" data-appointment-alt="<?= $answer->appointment_alt ?>"  data-label="<?= lg('order.resume.services.' . $answer->slug) ?>" />
												@endforeach
											</span>
										@endif
									</p>

									@if ($question->type == 'boolean')
										<input type="radio" name="answers[<?= $question->type ?>][<?= $question->id ?>]" id="question-<?= $question->slug ?>-answer-yes" value="yes" data-question-type="<?= $question->type ?>" />
										<label class="answer-boolean anwser-yes" for="question-<?= $question->slug ?>-answer-yes">
											<?= lg('order.services.answers.yes') ?>
										</label>
										<span class="answer-list-yes hide">
											@foreach ($question->answers(true, $order->plan->volume_m3, 'pickup')->get() as $answer)
												<input type="hidden" name="targets[<?= $answer->id ?>]" value="<?= $answer->getQuestionTargetId() ?>" data-value-number-from="<?= $answer->value_number_from ?>" data-value-number-to="<?= $answer->value_number_to ?>" data-floor-value="<?= $answer->floor_value ?>" data-appointment="<?= $answer->appointment ?>" data-appointment-alt="<?= $answer->appointment_alt ?>" data-label="<?= lg('order.resume.services.' . $answer->slug) ?>" />
											@endforeach
										</span>
										<input type="radio" name="answers[<?= $question->type ?>][<?= $question->id ?>]" id="question-<?= $question->slug ?>-answer-no" value="no" data-question-type="<?= $question->type ?>" />
										<label class="answer-boolean anwser-no" for="question-<?= $question->slug ?>-answer-no">
											<?= lg('order.services.answers.no') ?>
										</label>
										<span class="answer-list-no hide">
											@foreach ($question->answers(false, $order->plan->volume_m3, 'pickup')->get() as $answer)
												<input type="hidden" name="targets[<?= $answer->id ?>]" value="<?= $answer->getQuestionTargetId() ?>" data-value-number-from="<?= $answer->value_number_from ?>" data-value-number-to="<?= $answer->value_number_to ?>" data-floor-value="<?= $answer->floor_value ?>" data-appointment="<?= $answer->appointment ?>" data-appointment-alt="<?= $answer->appointment_alt ?>" data-label="<?= lg('order.resume.services.' . $answer->slug) ?>" />
											@endforeach
										</span>
									@endif
								</div>
							@endforeach
						</div>

						<div class="economy">
							<p>
								<?= lg('order.services.economy') ?>
							</p>
							<p>
								<span class="value">0</span>€
							</p>
						</div>

						<p class="continue">
							<button class="btn btn-primary" type="submit"><?= lg('order.services.submit') ?></button>
						</p>
					</div>
					<div class="col-md-3 text-right order-resume-wrapper">
						<div class="order-resume following">
							<p class="title"><?= lg('order.resume.title') ?></p>
							<p class="plan"><?= $order->getPriceFormatedPerMonth() ?>€</p>
							<p class="appointment-title"><?= lg('order.resume.appointment') ?></p>
							<p class="appointment"><span class="value">0</span>€</p>
							<p class="notice"><?= lg('order.resume.notice') ?></p>
							<p class="services-title"><?= lg('order.resume.services-title') ?></p>
							<div class="services" data-model="<?= htmlspecialchars('<div><p class="service-label"></p><p><span class="service-appointment"></span></p></div>') ?>" data-model-empty="<?= htmlspecialchars('<div><p class="service-label"></p><p class="service-appointment">' . lg('order.services.appointment.free') . '</p></div>') ?>"></div>
						</div>
					</div>
				</div>

			</div>
		</section>

        <section class="section bg-gray-lighter-ultra">
            <div class="container">
                @include('order.faq', ['faqs' => array_slice(Label::extract('order')['faq'], 1, 2)])
            </div>
        </section>
	</form>
@stop
