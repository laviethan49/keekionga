@extends('layouts.app')

@section('navbar-navigation')
<a class='tab' href="{{ url('contact') }}">Contact Us</a>
<a class='tab' href="{{ url('philosophy') }}">What We're About</a>
<a class='tab' href="{{ url('offers') }}">What We Offer</a>
<a class='tab' href="{{ url('location') }}">Where To Find Us</a>
@endsection

@section('content')
	@auth
		<div id="post_create">
			@if($errors->any())
				<h2><p class="error_message">{{$errors->first()}}</p></h2>
			@endif
			<form id="post_form" action="{{ URL::to('upload_post') }}" method="post" enctype="multipart/form-data">
				<h3 class="centered">Create A New Post</h3>
				<input class="input_text_box form-control" type="text" name="post_title" placeholder="Title Your Post" value="{{ old('post_title') }}">
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
	@endauth
		<div id="posts_container">
			<div id="loading_icon">
				<img src="{{ URL('/storage/loading/cloading.gif') }}" />
			</div>
		</div>
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
		$(document).ready(function()
		{
		    $.ajax({
		        url: "{{ URL('/api/posts/all') }}",
		        type: "GET",
		        cache: false,
		        success: function(data)
		        {
		        	showPosts(data);
		        },
		    });
		});
		function showPosts(data)
		{
			$('#loading_icon').hide();
			data.forEach(function(item, key) {
				var post = document.createElement("div");
					$(post).attr('class', 'post');
					$(post).attr('id', 'post_'+key);
				var title = document.createElement("div");
					$(title).attr('class', 'post_title centered');
					$(title).attr('id', 'post_title_'+key);
					$(title).html(item['post'].title);
				var message = document.createElement("div");
					$(message).attr('class', 'post_message');
					$(message).attr('id', 'post_message_'+key);
					$(message).html(item['post'].message);
				var image_container = document.createElement("div");
					$(image_container).attr('class', 'post_images');
					$(image_container).css('height', (150 + 50 * Math.floor(item['images'].length/8))+'px');
					var images = [];
					item['images'].forEach(function(picture, lock) {
						var image = document.createElement("img");
							$(image).attr('src', "{{ URL('') }}"+picture.path);
							$(image).attr('class', 'post_image');
							$(image).attr('id', 'post_image_'+key+'_'+lock);
						images[lock] = image;
					});
				$(image_container).append(images);
				$(post).append(title);
				$(post).append(message);
				$(post).append(image_container);
				$('#posts_container').append(post);
			});
		}
	</script>
@endsection