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
					<input type="file" name="file[]" id="file" multiple="multiple">
					<br>
					{{-- <input type="button" name="add_image" onclick="addImageUpload()" value="Add Another Image"> --}}
					{{-- <input type="button" name="remove_image" onclick="removeImageUpload()" value="Remove Last Image"> --}}
				</div>
				<input class="submit_button" type="submit" name="submit" value="Post">
				<input type="hidden" value="{{ csrf_token() }}" name="_token">
			</form>
		</div>
		<div id="posts_container_admin">
			<div class="loading_icon">
				<img src="{{ URL('/storage/loading/cloading.gif') }}" />
			</div>
		</div>
	@else
		<div id="posts_container">
			<div class="loading_icon">
				<img src="{{ URL('/storage/loading/cloading.gif') }}" />
			</div>
		</div>
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
		$(document).ready(function()
		{
		    $.ajax({
		        url: "{{ URL('/api/posts/all') }}",
		        type: "GET",
		        cache: false,
		        success: function(data)
		        {
		        	showPosts(data);
		        	showPostsAdmin(data);
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
					$(image_container).css('height', (150 + 100 * Math.floor(item['images'].length/6))+'px');
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
		function showPostsAdmin(data)
		{
			$('.loading_icon').hide();
			data.forEach(function(item, key) {
				var post = document.createElement("div");
					$(post).attr('class', 'post');
					$(post).attr('id', 'post_'+item['post'].id);
				var title = document.createElement("div");
					$(title).attr('class', 'post_title centered');
					$(title).attr('id', 'post_title_'+item['post'].id);
					$(title).html(item['post'].title);
				var message = document.createElement("div");
					$(message).attr('class', 'post_message');
					$(message).attr('id', 'post_message_'+item['post'].id);
					$(message).html(item['post'].message);
				var image_container = document.createElement("div");
					$(image_container).attr('class', 'post_images');
					$(image_container).attr('id', 'post_images_'+item['post'].id);
					$(image_container).css('height', (150 + 100 * Math.floor(item['images'].length/6))+'px');
					var images = [];
					item['images'].forEach(function(picture, lock) {
						var image = document.createElement("img");
							$(image).attr('src', "{{ URL('') }}"+picture.path);
							$(image).attr('class', 'post_image');
							$(image).attr('id', 'post_image_'+item['post'].id+'_'+lock);
						images[lock] = image;
					});
				var edit_button = document.createElement("button");
					$(edit_button).attr('class', 'btn-warning edit_post');
					$(edit_button).attr('id', 'edit_post_'+item['post'].id);
					$(edit_button).attr('onclick', 'editPost('+item['post'].id+')');
					$(edit_button).html('Edit Post');
				var delete_button = document.createElement("button");
					$(delete_button).attr('class', 'btn-danger delete_post');
					$(delete_button).attr('onclick', 'deletePost('+item['post'].id+')');
					$(delete_button).html('Delete Post');
				$(image_container).append(images);
				$(post).append(title);
				$(post).append(message);
				$(post).append(image_container);
				$(post).append(edit_button);
				$(post).append(delete_button);
				$('#posts_container_admin').append(post);
			});
		}
		function editPost(id)
		{
			var title = document.getElementById('post_title_'+id),
				message = document.getElementById('post_message_'+id),
				images = document.getElementById('post_images_'+id),
				post = document.getElementById('post_'+id),
				edit_button = document.getElementById('edit_post_'+id);

			$(title).hide();
			$(message).hide();
			$(images).hide();
			$(edit_button).hide();

			var input_title = document.createElement("input");
				$(input_title).attr('class', 'post_title post_input_title');
				$(input_title).attr('id', 'post_title_input');
				$(input_title).attr('type', 'text');
				$(input_title).attr('name', 'post_title_input');
				$(input_title).attr('value', $(title).html());

			var input_message = document.createElement("textarea");
				$(input_message).attr('class', 'post_message post_input_message');
				$(input_message).attr('id', 'post_message_input');
				$(input_message).attr('name', 'post_message_input');
				$(input_message).html($(message).html());

			var input_files = document.createElement("input");
				$(input_files).attr('type', 'file');
				$(input_files).attr('multiple', 'multiple');
				$(input_files).attr('id', 'post_images_input');
				$(input_files).attr('name', 'post_images_input[]');

			var select_delete_files = document.createElement("div");
				$(select_delete_files).attr('class', 'post_images');
				$(select_delete_files).css('height', (150 + 100 * Math.floor($(images).children().length/6))+'px');
				var children = images.children;
				var iterations = children.length;
				var selectables = [];
				for(var i = 0; i < iterations; i++)
				{
					var select_file = document.createElement("img");
						$(select_file).attr('src', children[i].src);
						$(select_file).attr('class', children[i].className);
						$(select_file).attr('id', 'post_selected_file_'+i);
						$(select_file).attr('name', 0);
						$(select_file).attr('onclick', 'selectFile('+i+')');
					selectables.push($(select_file));
				}
				$(select_delete_files).html(selectables);

			var submit_edit_button = document.createElement("button");
				$(submit_edit_button).attr('class', 'btn-primary submit_button');
				$(submit_edit_button).attr('type', 'submit');
				$(submit_edit_button).html('Submit Your Changes');

			var input_form = document.createElement("form");
				$(input_form).attr('method', 'POST');
				$(input_form).attr('action', "{{ URL('/api/posts/edit') }}"+'/'+id);
				$(input_form).attr('enctype', 'multipart/form-data');

			$(input_form).append(input_title);
			$(input_form).append(input_message);
			$(input_form).append(select_delete_files);
			$(input_form).append(input_files);
			$(input_form).append(submit_edit_button);

			$(post).append(input_form);
		}
		function deletePost(id)
		{
			if(confirm("Are You Sure You Want To Delete This Post?"))
			{
				var post = document.getElementById('post_'+id);

				var input_form = document.createElement("form");
					$(input_form).attr('method', 'POST');
					$(input_form).attr('action', "{{ URL('/api/posts/delete') }}"+'/'+id);

				$(post).append(input_form);
				$(input_form).submit();
			}
		}
		function selectFile(id)
		{
			var elmnt = document.getElementById('post_selected_file_'+id);
			if(elmnt.name == 0)
			{
				$(elmnt).css('opacity', .5);
				$(elmnt).attr('name', 1);
				var image_to_delete = document.createElement("input");
				$(image_to_delete).attr('hidden', 'hidden');
				$(image_to_delete).attr('name', 'images_to_delete[]');
				$(image_to_delete).attr('value', elmnt.src.replace('{{URL('')}}', ''));
				$(image_to_delete).attr('id', 'post_terminated_file_'+id);
				$(elmnt).after(image_to_delete);
			}
			else
			{
				$(elmnt).css('opacity', 1);
				$(elmnt).attr('name', 0);
				document.getElementById('post_terminated_file_'+id).remove();
			}
		}
	</script>
@endsection