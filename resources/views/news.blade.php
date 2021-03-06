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
			{{-- {{dd($errors)}} --}}
			@if($errors->any())
				<p class="error_message">{{$errors->first()}}</p>
			@endif
			<form id="post_form" action="{{ URL('api/posts/new') }}" method="post" enctype="multipart/form-data">
				<h3 class="centered">Create A New Post</h3>
				<input required class="input_text_box form-control" type="text" name="post_title" placeholder="Title Your Post" value="{{ old('post_title') }}">
				<textarea required class="input_text_box form-control" type="text" name="post_message" placeholder="Post Message Here">{{ old('post_message') }}</textarea>
				<div class="image_post">
					<p>
						<u>Select Image(s) To Upload:</u>
					</p>
					<input type="file" name="file[]" id="file" multiple="multiple">
					<br>
				</div>
				<input class="submit_button btn btn-primary" type="submit" name="submit" value="Post">
				<input type="hidden" value="{{ csrf_token() }}" name="_token">
			</form>
		</div>
		<div id="selector">
			Select A Month To See All Posts From Then
			<select id="month_selector" onchange="getPostsForMonth()">
				<option value="0">No Sorting</option>
			</select>
		</div>
		<div id="posts_container_special_admin">
			
		</div>
		<div id="posts_container_admin">
			<div id="loading_icon">
				<img src="{{ URL('/storage/loading/cloading.gif') }}" />
			</div>
		</div>
	@else
		<div id="selector">
			Select A Month To See All Posts From Then
			<select id="month_selector" onchange="getPostsForMonth()">
				<option value="0">No Sorting</option>
			</select>
		</div>
		<div id="posts_container_special">
			
		</div>
		<div id="posts_container">
			<div id="loading_icon">
				<img src="{{ URL('/storage/loading/cloading.gif') }}" />
			</div>
		</div>
	@endauth
@endsection

@section('script-location')
	<script type="text/javascript">
		$(document).ready(function()
		{
		    $.ajax({
		        url: "{{ URL('/api/posts/ten') }}",
		        type: "GET",
		        success: function(data)
		        {
		        	showPosts(data);
		        	showPostsAdmin(data);
		        	addSortOptions();
		        },
		    });
		});
		function showPosts(data)
		{
			$('#loading_icon').hide();
			data.forEach(function(item, key) {
				if(item['post'].hidden == 0)
				{
					var height = 150 + 100 * Math.floor(item['images'].length/6);

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

					$(post).append(title);
					$(post).append(message);
					if(item['images'].length != 0)
					{
						var image_container = document.createElement("div");
							$(image_container).attr('class', 'post_images');
							$(image_container).css('height', height+'px');
						var images = [];
							item['images'].forEach(function(picture, lock) {
								var image = document.createElement("img");
									$(image).attr('src', "{{ URL('') }}"+picture.path);
									$(image).attr('class', 'post_image');
									$(image).attr('id', 'post_image_'+item['post'].id);
								images[lock] = image;
							});
						$(image_container).append(images);
						$(post).append(image_container);
					}
					if(item['post'].special == 0)
						$('#posts_container').append(post);
					else
						$('#posts_container_special').append(post);
				}
			});

			if($('#posts_container').children().length >= 11)
			{
				var showMore = document.createElement("button");
					$(showMore).attr('class', 'btn btn-info btn_centered centered');
					$(showMore).attr('id', 'show_more');
					$(showMore).html("Show More Posts");
					$(showMore).attr('onclick', 'getTenMore()');

				$('#posts_container').append(showMore);
			}
		}
		function showPostsAdmin(data)
		{
			$('.loading_icon').hide();

			data.forEach(function(item, key) {
				var height = 150 + 100 * Math.floor(item['images'].length/6);
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
				var edit_button = document.createElement("button");
					$(edit_button).attr('class', 'btn btn-warning edit_post');
					$(edit_button).attr('id', 'edit_post_'+item['post'].id);
					$(edit_button).attr('onclick', 'editPost('+item['post'].id+')');
					$(edit_button).html('Edit Post');
				var delete_button = document.createElement("button");
					$(delete_button).attr('class', 'btn btn-danger delete_post');
					$(delete_button).attr('onclick', 'deletePost('+item['post'].id+')');
					$(delete_button).html('Delete Post');

				if(item['post'].hidden == 0)
				{
					var hide_button = document.createElement("button");
						$(hide_button).attr('class', 'btn btn-info hide_post');
						$(hide_button).attr('id', 'hide_button_'+item['post'].id);
						$(hide_button).attr('onclick', 'hidePost('+item['post'].id+')');
						$(hide_button).html('Hide Post');
				}
				else
				{
					var hide_button = document.createElement("button");
						$(hide_button).attr('class', 'btn btn-info hide_post');
						$(hide_button).attr('id', 'hide_button_'+item['post'].id);
						$(hide_button).attr('onclick', 'showPost('+item['post'].id+')');
						$(hide_button).html('Show Post');
				}

				if(item['post'].special == 0)
				{
					var special_button = document.createElement("button");
						$(special_button).attr('class', 'btn btn-info special_post');
						$(special_button).attr('id', 'special_button_'+item['post'].id);
						$(special_button).attr('onclick', 'specialPost('+item['post'].id+')');
						$(special_button).html('Make Post Special');
				}
				else
				{
					var special_button = document.createElement("button");
						$(special_button).attr('class', 'btn btn-info special_post');
						$(special_button).attr('id', 'special_button_'+item['post'].id);
						$(special_button).attr('onclick', 'unspecialPost('+item['post'].id+')');
						$(special_button).html('Make Post Un-Special');
				}

				$(post).append(title);
				$(post).append(message);
				$(post).append(edit_button);
				$(post).append(delete_button);
				$(post).append(hide_button);
				$(post).append(special_button);

				if(item['images'].length != 0)
				{
					var image_container = document.createElement("div");
						$(image_container).attr('class', 'post_images');
						$(image_container).attr('id', 'post_images_'+item['post'].id);
						$(image_container).css('height', height+'px');
					var images = [];
						item['images'].forEach(function(picture, lock) {
							var image = document.createElement("img");
								$(image).attr('src', "{{ URL('') }}"+picture.path);
								$(image).attr('class', 'post_image');
								$(image).attr('id', 'post_image_'+key+'_'+lock);
							images[lock] = image;
						});
					$(image_container).append(images);
					$(post).append(image_container);
				}

				if(item['post'].special == 0)
					$('#posts_container_admin').append(post);
				else
					$('#posts_container_special_admin').append(post);
			});

			if($('#posts_container_admin').children().length >= 11)
			{
				var showMore = document.createElement("button");
					$(showMore).attr('class', 'btn btn-info btn_centered centered');
					$(showMore).attr('id', 'show_more');
					$(showMore).html('Show More Posts');
					$(showMore).attr('onclick', 'getTenMoreAdmin()');
					
				$('#posts_container_admin').append(showMore);
			}
		}
		function showMonthPosts(data)
		{
			showPosts(data);
		}
		function showMonthPostsAdmin(data)
		{
			showPostsAdmin(data);
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

			var submit_edit_button = document.createElement("button");
				$(submit_edit_button).attr('class', 'btn btn-primary submit_button');
				$(submit_edit_button).attr('type', 'submit');
				$(submit_edit_button).html('Submit Your Changes');

			var input_form = document.createElement("form");
				$(input_form).attr('method', 'POST');
				$(input_form).attr('action', "{{ URL('/api/posts/edit') }}"+'/'+id);
				$(input_form).attr('enctype', 'multipart/form-data');

			var csrf = document.createElement("input");
				$(csrf).attr('type', 'hidden');
				$(csrf).attr('value', '{{csrf_token()}}');
				$(csrf).attr('name', '_token');

			var input_files = document.createElement("input");
				$(input_files).attr('type', 'file');
				$(input_files).attr('multiple', 'multiple');
				$(input_files).attr('id', 'post_images_input');
				$(input_files).attr('name', 'post_images_input[]');

			$(input_form).append(input_title);
			$(input_form).append(input_message);
			$(input_form).append(csrf);
			$(input_form).append(input_files);

			if(images != null && images != undefined)
			{
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
				$(input_form).append(select_delete_files);
			}
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

				var csrf = document.createElement("input");
					$(csrf).attr('type', 'hidden');
					$(csrf).attr('value', '{{csrf_token()}}');
					$(csrf).attr('name', '_token');

				$(input_form).append(csrf);
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
		function getTenMore()
		{
			var lastID = $('#posts_container').children()[$('#posts_container').children().length - 2].id.replace('post_', '');
			$('#show_more').remove();
			$.ajax({
		        url: "{{ URL('/api/posts/more') }}"+'/'+lastID,
		        type: "GET",
		        success: function(data)
		        {
		        	showPosts(data);
		        },
		    });
		}
		function getTenMoreAdmin()
		{
			var lastID = $('#posts_container_admin').children()[$('#posts_container_admin').children().length - 2].id.replace('post_', '');
			$('#show_more').remove();
			$.ajax({
		        url: "{{ URL('/api/posts/more') }}"+'/'+lastID,
		        type: "GET",
		        success: function(data)
		        {
		        	showPostsAdmin(data);
		        },
		    });
		}
		function addSortOptions()
		{
			$.ajax({
		        url: "{{ URL('/api/posts/months') }}",
		        type: "GET",
		        success: function(data)
		        {
		        	Object.keys(data).forEach(function(item){
		        		var selection = document.createElement("option");
		        			$(selection).attr('value', item);
		        			$(selection).html(data[item]);
		        		$('#month_selector').append(selection);
		        	});
		        },
		    });
		}
		function getPostsForMonth()
		{
			$('#loading_icon').show();
			var selected = $('#month_selector').val();
			$(document.getElementsByClassName('post')).remove();
			$(document.getElementById('show_more')).remove();

			if(selected == 0)
			{
				$.ajax({
			        url: "{{ URL('/api/posts/ten') }}",
			        type: "GET",
			        success: function(data)
			        {
			        	$('#loading_icon').hide();
			        	showPosts(data);
			        	showPostsAdmin(data);
			        },
			    });
			}
			else
			{
				$.ajax({
			        url: "{{ URL('/api/posts/monthly_posts') }}"+'/'+selected,
			        type: "GET",
			        success: function(data)
			        {
			        	$('#loading_icon').hide();
			        	showMonthPosts(data);
			        	showMonthPostsAdmin(data);			        	
			        },
			    });
			}
		}
		function hidePost(id)
		{
			if(confirm("Hiding this will cause it to not appear in the list, do you still wish to continue?"))
			{
				$.ajax({
			        url: "{{ URL('/api/posts/hide') }}"+'/'+id,
			        type: "POST",
			        cache: false,
			        data: { _token: '{{ csrf_token() }}'},
			        success: function(data)
			        {
			        	$('.error_message').remove();

			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Post Successfully Hidden");

			        	$('#hide_button_'+id).attr('onclick', 'showPost('+id+')');
			        	$('#hide_button_'+id).html('Show');
			        	$('#post_form').prepend(error);
			        },
			        error: function(error_mess)
			        {
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Post Not Hidden, Error Occurred");

			        	$('#post_form').prepend(error);
			        }
			    });
			}
		}
		function showPost(id)
		{
			if(confirm("Showing this will cause it to appear in the list, do you still wish to continue?"))
			{
				$.ajax({
			        url: "{{ URL('/api/posts/show') }}"+'/'+id,
			        type: "POST",
			        cache: false,
			        data: { _token: '{{ csrf_token() }}'},
			        success: function(data)
			        {
			        	$('.error_message').remove();
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Post Successfully Shown");

			        	$('#hide_button_'+id).attr('onclick', 'hidePost('+id+')');
			        	$('#hide_button_'+id).html('Hide');
			        	$('#post_form').prepend(error);
			        },
			        error: function(data)
			        {
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Post Not Shown, Error Occurred");

			        	$('#post_form').prepend(error);
			        }
			    });
			}
		}
		function specialPost(id)
		{
			if(confirm("Making This Post Special Will Make It Appear At The Top of The List, Continue?"))
			{
				$.ajax({
			        url: "{{ URL('/api/posts/special') }}"+'/'+id,
			        type: "POST",
			        cache: false,
			        data: { _token: '{{ csrf_token() }}'},
			        success: function(data)
			        {
			        	$('.error_message').remove();

			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Post Successfully Made Special!");

			        	$('#special_button_'+id).attr('onclick', 'unspecialPost('+id+')');
			        	$('#special_button_'+id).html('Make Post Un-Special');
			        	$('#post_create').prepend(error);
			        },
			        error: function(error_mess)
			        {
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Post Not Made Special, Error Occurred");

			        	$('#post_create').prepend(error);
			        }
			    });
			}
		}
		function unspecialPost(id)
		{
			if(confirm("Making This Post Not Special Will Make It Not Appear At The Top of The List, Continue?"))
			{
				$.ajax({
			        url: "{{ URL('/api/posts/unspecial') }}"+'/'+id,
			        type: "POST",
			        cache: false,
			        data: { _token: '{{ csrf_token() }}'},
			        success: function(data)
			        {
			        	$('.error_message').remove();
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Post Successfully Made Un-Special!");

			        	$('#special_button_'+id).attr('onclick', 'specialPost('+id+')');
			        	$('#special_button_'+id).html('Make Post Special');
			        	$('#post_create').prepend(error);
			        },
			        error: function(data)
			        {
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Post Not Made Un-Special, Error Occurred");

			        	$('#post_create').prepend(error);
			        }
			    });
			}
		}
	</script>
@endsection