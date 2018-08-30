@extends('layouts.app')

@section('navbar-navigation')
<a class='tab' href="{{ url('contact') }}">Contact Us</a>
<a class='tab' href="{{ url('news') }}">What We've Been Up To</a>
<a class='tab' href="{{ url('offers') }}">What We Offer</a>
<a class='tab' href="{{ url('location') }}">Where To Find Us</a>
@endsection

@section('content')
	<div id="philosophy_container">
		&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Keekionga Farm II is located in Jefferson, ME, only a short drive away from the scenic Damariscotta Lake State Park. This second generation farm is in a prime location between a number of farmer's who all work together for the greater good, and that is too our philosophy here at Keekionga Farm, doing for others as you would have them do for you. With that in tact we are able to produce a wide assortment of meats from pork, beef, chicken, including eggs, lamb, and even the rarer mangalitsa prok meat that was a Hungarian breed of domestic pig. The mangalitsa pork is more of a creamy, robust flavor, intensely marbled with fat, although it is still a healthy option, it is only a higher quality of meat.
		<br><br>
		&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Here at the farm, which was started in 1991, we have been growing steadily, whether it be by animals, buildings, and newly, some vegetables and fruits, to serve the community the best it's seen. From our araucana chickens, which produce "easter egg" eggs, and for most of our chickens, that means the color blue. When it comes to our more rare breed, the mangalitsa pig, we pride ourselves on having some of the only ones in Maine, as they can be very hard to aqcuire as to how rare they truly are. These pigs offer a more unsaturated fat content than regular pigs, about 8% more, while having about 12% lower saturated fat. This all means that the pig tastes better, and is better for you, as saturated fats can build up and "saturate", while the unsaturated fats are more like oils, and are healthier for you.
		<br><br>
		&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp We hope to see you come by the farm some time for a visit, you are always welcome, just go over and check the "where to find us" page! And if not, just take a look around the website to see if something catches your eye. Whether it be our involvement in the community from looking at our "what we've been up to page" page, looking at our "what we offer" page to see our pricing options and what we currently stock as well as the possibility of sending us an e-mail with what you would like, or you could contact us directly by finding our information on the "contact" page. We thank you for your time spent learning a bit more about us, and hope to do business with you soon!
	</div>
@endsection