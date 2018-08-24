@extends('layouts.app')

@section('navbar-navigation')
<a href="{{ url('contact') }}">Contact Us</a>
<a href="{{ url('philosophy') }}">What We're About</a>
<a href="{{ url('news') }}">What We've Been Up To</a>
<a href="{{ url('offers') }}">What We Offer</a>
@endsection

@section('script-location')
{{-- <script>
function myMap() {
	var latLong = {lat: 44.2229, lng: -69.4473}
    var mapOptions = {
        center: latLong,
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.HYBRID,
    }
	var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    var marker = new google.maps.Marker({position: latLong, map: map});
}
</script> --}}
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJPQWlKzRu_tS5Sy3vTD-9fX31TO_cQbc&callback=myMap" type="text/javascript"></script> --}}
@endsection

@section('content')
<div style="width: 80%; display: block; position: absolute;">
	<div id="map" style="width: 100%; height: 85vh; margin: auto; margin-left: 2%; padding: 1px; border: solid gray 3px; border-radius: 3px; box-shadow: 0px 0px 15px 3px #CCC">
		<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m8!1m3!1d250669.6097608921!2d-69.65250665824252!3d44.28554299383115!3m2!1i1024!2i768!4f13.1!4m6!3e0!4m0!4m3!3m2!1d44.222899999999996!2d-69.4473!5e0!3m2!1sen!2sus!4v1533566367322" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
	</div>
</div>
<div style="width: 20%; display: block; position: absolute; left: 80%">
	<div style="text-align: center;">
		<u><h3><strong>Address</strong></h3></u>
		<h4>233 Valley Rd.<br>
		Jefferson ME<br>
		04348<br><br>
		<a href="https://goo.gl/maps/sk9Xc9iU1ov" target="_blank">Directions To Here</a></h4>
	</div>
	<br>
	<p style="margin-left: 10%; text-align: center; margin-right: 3%">
		<strong>Located just a couple miles from the very scenic and widely know Damariscotta Lake State Park, Keekionga Farm II is a short drive through an old Maine town called Jefferson. On the way to the new farm you will see Maine's beautiful countryside which we use to our advantage when letting our animals range around our fenced in property allowing the animals to be moslty grass fed with grain supplements to make them healthy and strong.</strong>
	</p>
</div>
@endsection