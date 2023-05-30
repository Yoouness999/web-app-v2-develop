@extends('layouts.default')

@section('navbar-default')
	<nav class="navbar navbar-default navbar-fixed-top no-transition">
@stop

@section('content')
<section class="section">
	<div class="container">
		<h1>Testing</h1>
		<h2>Order process</h2>
		<p>You can access to different pages of the process by this links:</p>
		<ul>
			<li><a href="/test/order-redirect-calculator" target="_blank">Calculator</a></li>
			<li><a href="/test/order-redirect-storage" target="_blank">1. Storage</a></li>
			<li><a href="/test/order-redirect-services" target="_blank">2. Services</a></li>
			<li><a href="/test/order-redirect-appointment" target="_blank">3. Appointment</a></li>
			<li><a href="/test/order-redirect-billing" target="_blank">4. Billing</a></li>
			<li><a href="/test/order-redirect-review" target="_blank">5. Review</a></li>
			<li><a href="/test/order-redirect-submit" target="_blank">Submit</a></li>
		</ul>
		<h2>API</h2>
		<ul>
			<li><a href="/test/api-login" target="_blank">Create token (login)</a></li>
			<li><a href="/test/api-user" target="_blank">Get user infos</a></li>
		</ul>
	</div>
</section>
@stop