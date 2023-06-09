<?php
namespace Former\Framework;

use Former\TestCases\FormerTests;

class TwitterBootstrap5Test extends FormerTests
{

	public function setUp(): void
	{
		parent::setUp();

		$this->former->framework('TwitterBootstrap5');
		$this->former->horizontal_open()->__toString();
	}

	////////////////////////////////////////////////////////////////////
	////////////////////////////// MATCHERS ////////////////////////////
	////////////////////////////////////////////////////////////////////

	public function hmatch($label, $field)
	{
		return '<div class="mb-3 row">'.$label.'<div class="col-lg-10 col-sm-8">'.$field.'</div></div>';
	}

	public function vmatch($label, $field)
	{
		return '<div class="mb-3">'.$label.$field.'</div>';
	}

	////////////////////////////////////////////////////////////////////
	//////////////////////////////// TESTS /////////////////////////////
	////////////////////////////////////////////////////////////////////

	public function testFrameworkIsRecognized()
	{
		$this->assertNotEquals('TwitterBootstrap', $this->former->framework());
		$this->assertEquals('TwitterBootstrap5', $this->former->framework());
	}

	public function testVerticalFormFieldsDontInheritHorizontalMarkup()
	{
		$this->former->open_vertical();
		$field = $this->former->text('foo')->__toString();
		$this->former->close();

		$match = $this->vmatch('<label for="foo" class="form-label">Foo</label>',
			'<input class="form-control" id="foo" type="text" name="foo">');

		$this->assertEquals($match, $field);
	}

	public function testHorizontalFormWithDefaultLabelWidths()
	{
		$field = $this->former->text('foo')->__toString();
		$match = $this->hmatch('<label for="foo" class="col-form-label col-lg-2 col-sm-4">Foo</label>',
			'<input class="form-control" id="foo" type="text" name="foo">');

		$this->assertEquals($match, $field);
	}

	public function testPrependIcon()
	{
		$this->former->open_vertical();
		$icon  = $this->former->text('foo')->prependIcon('thumbs-up')->__toString();
		$match = $this->vmatch('<label for="foo" class="form-label">Foo</label>',
			'<div class="input-group">'.
			'<span class="input-group-text"><i class="fa fa-thumbs-up"></i></span>'.
			'<input class="form-control" id="foo" type="text" name="foo">'.
			'</div>');

		$this->assertEquals($match, $icon);
	}

	public function testAppendIcon()
	{
		$this->former->open_vertical();
		$icon  = $this->former->text('foo')->appendIcon('thumbs-up')->__toString();
		$match = $this->vmatch('<label for="foo" class="form-label">Foo</label>',
			'<div class="input-group">'.
			'<input class="form-control" id="foo" type="text" name="foo">'.
			'<span class="input-group-text"><i class="fa fa-thumbs-up"></i></span>'.
			'</div>');
		$this->assertEquals($match, $icon);
	}

	public function testTextFieldsGetControlClass()
	{
		$this->former->open_vertical();
		$field = $this->former->text('foo')->__toString();
		$match = $this->vmatch('<label for="foo" class="form-label">Foo</label>',
			'<input class="form-control" id="foo" type="text" name="foo">');

		$this->assertEquals($match, $field);
	}

	public function testButtonSizes()
	{
		$this->former->open_vertical();
		$buttons = $this->former->actions()->lg_submit('Submit')->submit('Submit')->sm_submit('Submit')->xs_submit('Submit')->__toString();
		$match   = '<div>'.
			'<input class="btn-lg btn" type="submit" value="Submit">'.
			' <input class="btn" type="submit" value="Submit">'.
			' <input class="btn-sm btn" type="submit" value="Submit">'.
			' <input class="btn-xs btn" type="submit" value="Submit">'.
			'</div>';

		$this->assertEquals($match, $buttons);
	}

	public function testCanOverrideFrameworkIconSettings()
	{
		// e.g. using other Glyphicon sets
		$icon1  = $this->app['former.framework']->createIcon('facebook', null, array(
			'tag'	 => 'span',
			'set'    => 'social',
			'prefix' => 'glyphicon',
		))->__toString();
		$match1 = '<span class="social glyphicon-facebook"></span>';

		$this->assertEquals($match1, $icon1);

		// e.g using Font-Awesome circ v3.2.1
		$icon2  = $this->app['former.framework']->createIcon('flag', null, array(
			'tag'    => 'i',
			'set'    => '',
			'prefix' => 'icon',
		))->__toString();
		$match2 = '<i class="icon-flag"></i>';

		$this->assertEquals($match2, $icon2);
	}

	public function testCanCreateWithErrors()
	{
		$this->former->open_vertical();
		$this->former->withErrors($this->validator);

		$required = $this->former->text('required')->__toString();
		$matcher  =
			'<div class="mb-3 is-invalid">'.
			'<label for="required" class="form-label">Required</label>'.
			'<input class="form-control is-invalid" id="required" type="text" name="required">'.
			'<div class="invalid-feedback">The required field is required.</div>'.
			'</div>';

		$this->assertEquals($matcher, $required);
	}

	public function testAddScreenReaderClassToInlineFormLabels()
	{
		$this->former->open_inline();

		$field = $this->former->text('foo')->__toString();

		$match =
			'<div class="mb-3">'.
			'<label for="foo" class="visually-hidden">Foo</label>'.
			'<input class="form-control" id="foo" type="text" name="foo">'.
			'</div>';

		$this->assertEquals($match, $field);
		$this->assertEquals($match, $field);

		$this->former->close();
	}

	public function testHeightSettingForFields()
	{
		$this->former->open_vertical();

		$field = $this->former->lg_text('foo')->__toString();
		$match =
			'<div class="mb-3">'.
			'<label for="foo" class="form-label">Foo</label>'.
			'<input class="input-lg form-control" id="foo" type="text" name="foo">'.
			'</div>';
		$this->assertEquals($match, $field);

		$this->resetLabels();
		$field = $this->former->sm_select('foo')->__toString();
		$match =
			'<div class="mb-3">'.
			'<label for="foo" class="form-label">Foo</label>'.
			'<select class="input-sm form-select" id="foo" name="foo"></select>'.
			'</div>';
		$this->assertEquals($match, $field);

		$this->former->close();
	}

	public function testAddFormControlClassToInlineActionsBlock()
	{
		$this->former->open_inline();
		$buttons = $this->former->actions()->submit('Foo')->__toString();
		$match   = '<div class="mb-3 row">'.
			'<input class="btn" type="submit" value="Foo">'.
			'</div>';

		$this->assertEquals($match, $buttons);

		$this->former->close();
	}

	public function testButtonsAreNotWrapped()
	{
		$button  = $this->former->text('foo')->append($this->former->button('Search'))->wrapAndRender();
		$matcher = '<button class="btn" type="button">Search</button>';

		$this->assertStringContainsString($matcher, $button);
	}
}
