@extends('arxmin::layouts.admin')


@section('content')
<div class="container-fluid" ng-controller="editorController">
    <?= Former::open()
        ->id('EditorForm')
        ->secure()
        ->rules(['title' => 'required'])
        ->action('#')
        ->class('form')
        ->method('post'); ?>
    <div class="row">
        <div class="col-sm-9 scrollable">
            <?php
            echo FormHelper::group(lg('Title'), FormHelper::text('title', $item['title']));
            echo FormHelper::group(lg('Slug'), FormHelper::text('slug', $item['slug']));
            echo FormHelper::group(lg('Content'), Form::textarea('content', $item['content'], ['id' => 'wisywig', 'class' => 'wysiwig', 'rows' => 20, 'columns' => 30]));
            ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Custom Fields</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-box-tool" href="<?php echo url('arxmin/modules/datamanager/data/build/' . $item->form()->id); ?>" data-toggle="tooltip" data-original-title="Edit fields">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <button class="btn btn-box-tool" type="button" data-widget="collapse" data-toggle="tooltip" data-original-title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-horizontal">
                        <div ng-model="input" fb-form="default" fb-default="defaultValue"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-3 scrollable">
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">Publish</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" type="button" data-widget="collapse" data-toggle="tooltip" data-original-title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <ul class="list-unstyled">
                        <li>
							<p>
								<i class="fa fa-fw fa-eye"></i> <strong><?php echo __('Status') ?></strong>
								<?php if ($item->is_public && $item->published_at && $item->published_at <= date('Y-m-d H:i:s', time())) echo __('Published');
								else echo __('Draft'); ?>
							</p>
                        </li>
                        <li>
                            <p><i class="fa fa-fw fa-calendar"></i> <strong><?php echo __('Updated at') ?></strong> <?php echo $item->form()->updated_at->format('d M, Y @ H:i'); ?></p>
                        </li>
						<li>
							<?= FormHelper::group(__('Visibility'), FormHelper::select('is_public', [0 => __('Private'), 1 => __('Public')], $item['is_public'], ['class' => 'form-control'])); ?>
						</li>
						<li>
							<?= FormHelper::group(__('Pusblished'), FormHelper::text('published_at', $item['published_at'], ['id' => 'published_at'])); ?>
						</li>
                    </ul>
                </div>
                <div class="box-footer">
                    <button class="btn btn-success" type="submit">
                        <i class="fa fa-check"></i> <?= __("Submit") ?>
                    </button>
                    <a class="btn btn-info" href="<?= moduleUrl('data/redirect/' . $item->id); ?>" target="_blank">
                        <i class="fa fa-eye"></i> <?= __("View") ?>
                    </a>
                    <a class="btn btn-danger" href="<?= url('arxmin/modules/datamanager/data/delete/' . $item->form()->id) ?>" data-confirm="<?= __('Are you sure?') ?>">
                        <i class="fa fa-trash"></i> <?= __("Delete") ?>
                    </a>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Page Attributes</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" type="button" data-widget="collapse" data-toggle="tooltip" data-original-title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
					{!! FormHelper::group('Template', FormHelper::select('template', $templates, $item['template'], ['class' => 'form-control'])) !!}

					{!! FormHelper::group(__('Highlight'), FormHelper::select('is_highlighted', [0 => __('Normal'), 1 => __('Highlighted')], $item['is_highlighted'], ['class' => 'form-control'])) !!}

                    @if(count(Arxmin::getLocales('select')) > 1)
						{!! FormHelper::group('Language', $langs[$item->lang]) !!}

						<div class="form-group">
							<label>Translations</label><br />
							<ul>
								@foreach ($langs as $key => $lang)
									@if ($key != $item->lang)
										<li>
											{!! $lang !!} :
											@if ($postLinked = $item->postsLinked()->where('lang', $key)->first())
												<a class="btn btn-link" href="{!! moduleUrl('data/edit/' . $postLinked->id)  !!}"><i class="fa fa-edit"></i> {!! str_limit($postLinked->title, 32)  !!}</a>
											@else
												<a class="btn btn-link" href="{!! moduleUrl('data/create/' . $item->type . '/' . $key . '/' . $item->id)  !!}"><i class="fa fa-plus"></i> add</a>
											@endif
										</li>
									@endif
								@endforeach
							</ul>
						</div>
                    @endif
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Categories</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" type="button" data-widget="collapse" data-toggle="tooltip" data-original-title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::select('categories[]', $categories, $item->categories()->get()->pluck('id'), ['id' => 'categories', 'class' => 'form-control', 'multiple']) !!}
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Tags</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" type="button" data-widget="collapse" data-toggle="tooltip" data-original-title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::select('tags[]', $tags, $item->tags()->get()->pluck('id'), ['id' => 'tags', 'class' => 'form-control', 'multiple']) !!}
                </div>
            </div>
        </div>
    </div>
    <?= Former::close(); ?>
</div><!-- .container-fluid-->
@stop


@section('css')
	@parent
	<?= Asset::css([
		moduleAsset('/css/datamanager.css'),
		moduleAsset('/plugins/jquery-colorbox/colorbox.css'),
		moduleAsset('/plugins/select2/css/select2.min.css'),
	]) ?>
    <link rel="stylesheet" href="/packages/zofe/rapyd/assets/datetimepicker/datetimepicker3.css"/>
@stop


@section('js')
	@parent
	<?= Asset::js([
		moduleAsset('js/form-builder.js'),
		moduleAsset('js/form-validator.js'),
		moduleAsset('js/form-rules.js'),
		moduleAsset('/plugins/jquery-colorbox/jquery.colorbox.js'),
		moduleAsset('/plugins/ckeditor/ckeditor.js'),
		moduleAsset('/plugins/select2/js/select2.full.min.js'),
	]) ?>
	<script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>
	<script src="/packages/zofe/rapyd/assets/datetimepicker/bootstrap-datetimepicker.js"></script>
	@include('datamanager::components.custom')

	<script>
		'use strict';

		$(function () {
			$(document).on('click', '[data-confirm]', function (e) {
				var message = $(this).data('confirm') || 'Are you sure?';
				return confirm(message);
			});

			$('input[name="title"]').on('keydown', function (e) {
				var $el = $(this);
				var timeout = $el.data('timeout');

				if (timeout) {
					clearTimeout(timeout);
				}



				$el.data('timeout', setTimeout(function () {
					var $slug = $('input[name="slug"]');

					if(!$slug.val()){
						var value = $el.val();
						value = slugify(value);
						$slug.val(value);
					}

				}, 500));
			});

			function slugify(str) {
				str = str.replace(/^\s+|\s+$/g, ''); // trim
				str = str.toLowerCase();

				// remove accents, swap ñ for n, etc
				var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
				var to = "aaaaaeeeeeiiiiooooouuuunc------";
				for (var i = 0, l = from.length; i < l; i++) {
					str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
				}

				str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
					.replace(/\s+/g, '-') // collapse whitespace and replace by -
					.replace(/-+/g, '-'); // collapse dashes

				return str;
			}

			$('#tags').select2({
				placeholder: 'Choose a tag',
				tags:        true
			});

			$('#categories').select2({
				placeholder: 'Choose a category',
				tags:        true
			});

			$('.lb.lb-iframe').colorbox({
				iframe:   true,
				width:    '100%',
				height:   '100%',
				onClosed: function () {
					var conf = confirm("Would you like to refresh the page to see the changes ?");

					if (conf == true) {
						conf = confirm("Would you like to save your data before refresh ?");

						if (conf == true) {
							var scope = angular.element($('[ng-controller="editorController"]')).scope();
							var success = scope.submit();

							if (success) {
								window.location.reload();
							}
						} else {
							window.location.reload();
						}
					}
				}
			});

			$('.lb.lb-preview').colorbox({
				iframe: true,
				width:  '100%',
				height: '100%'
			});

			$('#published_at').datetimepicker({
				language: 'en',
				todayBtn: 'linked',
				autoclose: true
			});
		});

		// Init Ckeditor
		CKEDITOR.replace('content', {
			language: '<?= App::getLocale() ?>',
			height:   450,
			skin:     'bootstrapck',
			removeButtons: '',
			extraPlugins : 'iframe,iframedialog,justify,table,colordialog,youtube,colorbutton,oembed,smiley,lineutils'
		});

		var app = angular.module('formEditor', [
			'builder',
			'builder.components',
			'validator.rules'
		]);

		app.controller('editorController', ['$scope', '$http', '$builder', '$validator', formbuilderController]);


		function formbuilderController($scope, $http, $builder, $validator) {
			$scope.alertStatus = false;

			$scope.input = [];
			$scope.defaultValue = {};

			$scope.form = $builder.forms['default'];
			$scope.fields = window.__app.scope.fields;

			for (var key in $scope.fields) {
				$builder.addFormObject('default', $scope.fields[key]);
			}

			$scope.data = window.__app.scope.data;

			if ($scope.data.meta) {
				for (var i = 0, len = $scope.form.length; i < len; i++) {
					var field = $scope.form[i];

					if (Object.keys($scope.data.meta).indexOf(field.name) > -1) {
						$scope.defaultValue[field.id] = $scope.data.meta[field.name];
					}
				}
			}

			$scope.importForm = function () {
				Object.keys($scope.formImport).forEach(function (key) {
					var field = $scope.formImport[key];
					$builder.addFormObject('default', field);
				});
			};

			// Populate date
			$scope.submit = function () {
				$scope.status = 'wait';

				var formDataArray = $('#EditorForm').serializeArray();
				var formData = {};

				for (var i = 0; i < formDataArray.length; ++i) {
					formData[formDataArray[i].name] = formDataArray[i].value;
				}

				var params = {
					headers: {'Cache-Control': 'no-cache'},
					params:  {
						url:  window.__app.api_url + 'data/' + $scope.data.id + '/update',
						data: formData
					}
				};

				$http.post(params)
					.then(function (data, status, headers, config) {
						console.log('-- Success', data);
						$scope.alertStatus = 'success';

						window.location.reload();
					}, function (data, status, headers, config) {
						console.log('-- Errors', data);
						$scope.alertStatus = 'error';
					});

				return false;
			};
		}

		// bootstrap the app (async)
		angular.element(document).ready(function () {
			angular.bootstrap(document, ['formEditor']);
		});
	</script>
@stop
