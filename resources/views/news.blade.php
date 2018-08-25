@extends('layouts.app')

@section('navbar-navigation')
<a class='tab' href="{{ url('contact') }}">Contact Us</a>
<a class='tab' href="{{ url('philosophy') }}">What We're About</a>
<a class='tab' href="{{ url('offers') }}">What We Offer</a>
<a class='tab' href="{{ url('location') }}">Where To Find Us</a>
@endsection

@section('content')
	@auth
		<div class="post">
			@if($errors->any())
				<h2><p class="error_message">{{$errors->first()}}</p></h2>
			@endif
			<form action="{{ URL::to('upload_post') }}" method="post" enctype="multipart/form-data">
				<h3 class="centered">Create A New Post</h3>
				<input class="input_text_box form-control" type="text" name="post_title" placeholder="Title Your Post" value="{{ old('title') }}">
				<textarea class="input_text_box form-control" type="text" name="post_message" placeholder="Post Message Here">{{ old('post_message') }}</textarea>
				<div class="image_post">
					<p>
						<u>Select Image(s) To Upload:</u>
					</p>
					<input type="file" name="file[]" id="file_1">
					<br>
					<input type="button" name="add_image" onclick="addImageUpload()" value="Add Another Image">
					<input type="button" name="remove_image" onclick="removeImageUpload()" value="Remove Last Image">
				</div>
				<input class="submit_button" type="submit" name="submit" value="Post">
				<input type="hidden" value="{{ csrf_token() }}" name="_token">
			</form>
		</div>
	@else
	@endauth
@endsection

@section('script-location')
	<script type="text/javascript">
		function addImageUpload()
		{
			var elemelon = document.createElement("input");
				$(elemelon).attr('type', 'file');
				$(elemelon).attr('name', 'file[]');
			$("#file_1").after(elemelon);
			$(elemelon).before("<br>");
		}
		function removeImageUpload()
		{
			var elemelons = document.getElementsByName('file[]'),
				elemelon = elemelons[elemelons.length - 1];

			if(elemelons.length > 1)
			{
				$(elemelon).prev().remove();
				$(elemelon).remove();
			}
		}
	</script>
@endsection