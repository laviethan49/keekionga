@extends('layouts.app')

@section('navbar-navigation')
<a class='tab' href="{{ url('philosophy') }}">What We're About</a>
<a class='tab' href="{{ url('news') }}">What We've Been Up To</a>
<a class='tab' href="{{ url('offers') }}">What We Offer</a>
<a class='tab' href="{{ url('location') }}">Where To Find Us</a>
@endsection

@section('content')
<div style="width: 100%; display: block; position: absolute; height: 80vh">
	<div style="border: solid gray 3px; border-radius: 1px; box-shadow: 0px 0px 15px 3px #CCC; display: block; position: absolute; width: 30vw; height: 90vh; left: 60%; background-image: url('{{ asset('images/headshots/together.jpg') }}'); background-repeat: no-repeat; background-size: cover; margin-bottom: 1%">
	</div>
	<div style="text-align: center; display: block; position: absolute; margin-top: 1%; width: 55%;">
		<u><h2>Contact Us Directly</h2></u>
	</div>
	<div style="text-align: center; display: block; position: absolute; margin-top: 7%; left: 30%;">
		<strong><h4>Clayton Spinney II</h4></strong>
		E-mail: <a href="mailto:clayton.spinney@yahoo.com">clayton.spinney@yahoo.com</a><br>
		Phone: (207)-841-9731<br>
	</div>
	<div style="text-align: center; display: block; position: absolute; margin-top: 7%; left: 10%">
		<strong><h4>Melissa Spinney</h4></strong>
		E-mail: <a href="mailto:lsrawson@yahoo.com">lsrawson@yahoo.com</a><br>
		Phone: (207)-512-0878<br>
	</div>
	<div style="text-align: center; display: block; position: absolute; margin-top: 18%; width: 55%;">
		<u><h2>Mailing Address</h2></u>
		<br>
		<h2>Keekionga Farm II</h2>
		<h3>233 Valley Rd.</h3>
		<h3>Jefferson, ME - 04348</h3>
		<br>
		<h4><a href="{{ url('location') }}">(Find On Map)</a></h4>
	</div>
</div>
@endsection