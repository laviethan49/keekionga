@extends('layouts.app')

@section('navbar-navigation')
<a class='tab' href="{{ url('contact') }}">Contact Us</a>
<a class='tab' href="{{ url('philosophy') }}">What We're About</a>
<a class='tab' href="{{ url('news') }}">What We've Been Up To</a>
<a class='tab' href="{{ url('location') }}">Where To Find Us</a>
@endsection

@section('content')
	@auth
		<form id="product_form" method="post" action="{{ URL('api/products/new') }}" class="product_form">
			@if($errors->any())
				<p class="error_message">{{$errors->first()}}</p>
			@endif
		  <div class="form-group product_form_input">
		    <label for="group">Group</label>
		    <input list="group_choices" type="text" class="form-control" id="group" value="{{ old('group_input') }}" name="group_input" aria-describedby="groupHelp" placeholder="Group" required>
		    <small id="groupHelp" class="form-text text-muted centered">What group does this product fall under?</small>
		    <datalist id="group_choices">
		    	
		    </datalist>
		  </div>
		  <div class="form-group product_form_input">
		    <label for="product">Product</label>
		    <input type="text" class="form-control" id="product" value="{{ old('product_input') }}" name="product_input" placeholder="Product" required>
		  </div>
		  <div class="form-group product_form_input">
		    <label for="unit">Unit</label>
		    <input type="text" class="form-control" id="unit" value="{{ old('unit_input') }}" name="unit_input" aria-describedby="unitHelp" placeholder="Unit" required>
		    <small id="unitHelp" class="form-text text-muted centered">Unit describing how much we sell at a time</small>
		  </div>
		  <div class="form-group product_form_input">
		    <label for="price">Price</label>
		    <input type="number" class="form-control" id="price" value="{{ old('price_input') }}" name="price_input" placeholder="Price" required step=".01">
		  </div>
		  <div class="form-group description-form-input">
		    <label for="description">Description</label>
		    <textarea class="form-control" id="description" name="description_input" placeholder="Description" required>{{ old('description_input') }}</textarea>
		  </div>
		  <button type="submit" class="btn btn-primary submit_button">Add Product</button>
		  <input type="hidden" value="{{ csrf_token() }}" name="_token">
		</form>
		<div id="products_container_admin">
			<div id="loading_icon">
				<img src="{{ URL('/storage/loading/cloading.gif') }}" />
			</div>
		</div>
	@else
		<div id="products_container">
			@if($errors->any())
				<h2><p class="error_message">{{$errors->first()}}</p></h2>
			@endif
			<div id="loading_icon">
				<img src="{{ URL('/storage/loading/cloading.gif') }}" />
			</div>
		</div>
		<button class="btn btn_centered btn-info" id="inquiry_email_btn" onclick="makeEmailDiv()">
			Send An Inquiry For Items Selected
		</button>
	@endauth
@endsection

@section('script-location')
	<script type="text/javascript">
		$(document).ready(function()
		{
			$.ajax({
		        url: "{{ URL('/api/products/groups') }}",
		        type: "GET",
		        cache: false,
		        success: function(data)
		        {
		        	var group_select = document.getElementById('group_choices');
		        	data.forEach(function(item, key) {
		        		var group_option = document.createElement("option");
		        			$(group_option).attr('value', item);
		        		$(group_select).append(group_option);
		        	});
		        },
		    });

		    $.ajax({
		        url: "{{ URL('/api/products/all') }}",
		        type: "GET",
		        cache: false,
		        success: function(data)
		        {
					$('#loading_icon').hide();
		        	showProducts(data);
		        	showProductsAdmin(data);
		        },
		    });
		});
		function showProducts(data)
		{
			var container = document.getElementById('products_container');
			var product_containers = document.createElement("div");
				$(product_containers).attr('class', 'product_container');
			var product_title = document.createElement('div');
				$(product_title).attr('class', 'product_title');
				$(product_title).attr('id', 'product_title_');
				$(product_title).html("Product");
			var product_unit = document.createElement('div');
				$(product_unit).attr('class', 'product_unit');
				$(product_unit).attr('id', 'product_unit_');
				$(product_unit).html("Unit Sold By");
			var product_description = document.createElement('div');
				$(product_description).attr('class', 'product_description');
				$(product_description).attr('id', 'product_description_');
				$(product_description).html("Description");
			var product_price = document.createElement('div');
				$(product_price).attr('class', 'product_price');
				$(product_price).attr('id', 'product_price_');
				$(product_price).html("Price");
			var product_amount = document.createElement('div');
				$(product_amount).attr('class', 'product_amount');
				$(product_amount).attr('id', 'product_amount_');
				$(product_amount).html("Amount Wanted");
			var product_total = document.createElement('div');
				$(product_total).attr('class', 'product_total_');
				$(product_total).attr('id', 'product_total_');
				$(product_total).html("Total For Item");

			$(product_containers).append(product_title);
			$(product_containers).append(product_unit);
			$(product_containers).append(product_description);
			$(product_containers).append(product_price);
			$(product_containers).append(product_amount);
			$(product_containers).append(product_total);

			$(container).append(product_containers);

			for(var i = 0; i < Object.keys(data).length; i++)
			{
				var item = Object.keys(data)[i];

				var amountOfItems = countShownItems(data[item]);

				if(amountOfItems != 0)
				{
					var product_containers = document.createElement("div");
						$(product_containers).attr('class', 'product_container product_group');
						$(product_containers).html(item);

					$(container).append(product_containers);

					data[item].forEach(function(product, key) {
						if(product.hidden == 0)
						{
							var product_containers = document.createElement("div");
								$(product_containers).attr('class', 'product_container product');

							var product_title = document.createElement('div');
								$(product_title).attr('class', 'product_title');
								$(product_title).attr('id', 'product_title_'+product.id);
								$(product_title).html(product.product);

							var product_unit = document.createElement('div');
								$(product_unit).attr('class', 'product_unit');
								$(product_unit).attr('id', 'product_unit_'+product.id);
								$(product_unit).html(product.unit);

							var product_description = document.createElement('div');
								$(product_description).attr('class', 'product_description');
								$(product_description).attr('id', 'product_description_'+product.id);
								$(product_description).html(product.description);

							var product_price = document.createElement('div');
								$(product_price).attr('class', 'product_price');
								$(product_price).attr('id', 'product_price_'+product.id);
								$(product_price).html('$'+product.price);

							var product_amount = document.createElement('input');
								$(product_amount).attr('class', 'product_amount_input');
								$(product_amount).attr('id', 'product_amount_'+product.id);
								$(product_amount).attr('type', 'number');
								$(product_amount).attr('min', 0);
								$(product_amount).attr('value', 0);
								$(product_amount).attr('oninput', 'total('+product.id+')');

							var product_total = document.createElement('input');
								$(product_total).attr('class', 'product_total');
								$(product_total).attr('disabled', 'disabled');
								$(product_total).attr('id', 'product_total_'+product.id);
								$(product_total).attr('value', '$0');

							$(product_containers).append(product_title);
							$(product_containers).append(product_unit);
							$(product_containers).append(product_description);
							$(product_containers).append(product_price);
							$(product_containers).append(product_amount);
							$(product_containers).append(product_total);

							$(container).append(product_containers);
						}
					});
				}
			}
			var product_containers = document.createElement("div");
				$(product_containers).attr('class', 'product_container product_totals');
				$(product_containers).attr('id', 'product_total_total');
				$(product_containers).html('Estimated Total For Items Selected: $0');

			var stipulation = document.createElement("div");
				$(stipulation).attr('class', 'centered');
				$(stipulation).html('*There may be a negotiable price for shipping, please contact us for more info');

			// var emailList

			$(container).append(product_containers);
			$(container).append(stipulation);
		}
		function showProductsAdmin(data)
		{
			var container = document.getElementById('products_container_admin');
			var product_containers = document.createElement("div");
				$(product_containers).attr('class', 'product_container');
			var product_title = document.createElement('div');
				$(product_title).attr('class', 'product_title');
				$(product_title).attr('id', 'product_title_');
				$(product_title).html("Product");
			var product_unit = document.createElement('div');
				$(product_unit).attr('class', 'product_unit');
				$(product_unit).attr('id', 'product_unit_');
				$(product_unit).html("Unit Sold By");
			var product_description = document.createElement('div');
				$(product_description).attr('class', 'product_description');
				$(product_description).attr('id', 'product_description_');
				$(product_description).html("Description");
			var product_price = document.createElement('div');
				$(product_price).attr('class', 'product_price');
				$(product_price).attr('id', 'product_price_');
				$(product_price).html("Price");
			var product_fixture = document.createElement('div');
				$(product_fixture).attr('class', 'product_fixture');
				$(product_fixture).attr('id', 'product_fixture_');
				$(product_fixture).html("Edit, Delete, or Hide Product");

			$(product_containers).append(product_title);
			$(product_containers).append(product_unit);
			$(product_containers).append(product_description);
			$(product_containers).append(product_price);
			$(product_containers).append(product_fixture);

			$(container).append(product_containers);

			for(var i = 0; i < Object.keys(data).length; i++)
			{
				var item = Object.keys(data)[i];

				var product_containers = document.createElement("div");
						$(product_containers).attr('class', 'product_container product_group');
						$(product_containers).html(item);

				$(container).append(product_containers);

				data[item].forEach(function(product, key) {
					if(product.hidden == 0)
					{
						var product_containers = document.createElement("div");
							$(product_containers).attr('class', 'product_container');
							$(product_containers).attr('id', 'product_container_'+product.id);

						var product_title = document.createElement('div');
							$(product_title).attr('class', 'product_title');
							$(product_title).attr('id', 'product_title_'+product.id);
							$(product_title).html(product.product);

						var product_unit = document.createElement('div');
							$(product_unit).attr('class', 'product_unit');
							$(product_unit).attr('id', 'product_unit_'+product.id);
							$(product_unit).html(product.unit);

						var product_description = document.createElement('div');
							$(product_description).attr('class', 'product_description');
							$(product_description).attr('id', 'product_description_'+product.id);
							$(product_description).html(product.description);

						var product_price = document.createElement('div');
							$(product_price).attr('class', 'product_price');
							$(product_price).attr('id', 'product_price_'+product.id);
							$(product_price).html('$'+product.price);

						var product_amount = document.createElement('input');
							$(product_amount).attr('class', 'product_amount_input');
							$(product_amount).attr('id', 'product_amount_'+product.id);
							$(product_amount).attr('type', 'number');
							$(product_amount).attr('value', 0);
							$(product_amount).attr('oninput', 'total('+product.id+')');

						var product_total = document.createElement('input');
							$(product_total).attr('class', 'product_total');
							$(product_total).attr('disabled', 'disabled');
							$(product_total).attr('id', 'product_total_'+product.id);
							$(product_total).attr('value', '$0');

						var product_edit = document.createElement("button");
							$(product_edit).attr('class', 'product_edit btn btn-warning');
							$(product_edit).attr('id', 'product_edit_'+product.id);
							$(product_edit).attr('onclick', 'editProduct('+product.id+')');
							$(product_edit).html('Edit');

						var product_delete = document.createElement("button");
							$(product_delete).attr('class', 'product_delete btn btn-danger');
							$(product_delete).attr('id', 'product_delete_'+product.id);
							$(product_delete).attr('onclick', 'deleteProduct('+product.id+')');
							$(product_delete).html('Delete');

						var product_hide = document.createElement("button");
							$(product_hide).attr('class', 'product_hide btn btn-info');
							$(product_hide).attr('id', 'product_hide_'+product.id);
							$(product_hide).attr('onclick', 'hideProduct('+product.id+')');
							$(product_hide).html('Hide');

						$(product_containers).append(product_title);
						$(product_containers).append(product_unit);
						$(product_containers).append(product_description);
						$(product_containers).append(product_price);
						$(product_containers).append(product_edit);
						$(product_containers).append(product_delete);
						$(product_containers).append(product_hide);

						$(container).append(product_containers);
					}
					else
					{
						var product_containers = document.createElement("div");
							$(product_containers).attr('class', 'product_container');
							$(product_containers).attr('id', 'product_container_'+product.id);

						var product_title = document.createElement('div');
							$(product_title).attr('class', 'product_title');
							$(product_title).attr('id', 'product_title_'+product.id);
							$(product_title).html(product.product);

						var product_unit = document.createElement('div');
							$(product_unit).attr('class', 'product_unit');
							$(product_unit).attr('id', 'product_unit_'+product.id);
							$(product_unit).html(product.unit);

						var product_description = document.createElement('div');
							$(product_description).attr('class', 'product_description');
							$(product_description).attr('id', 'product_description_'+product.id);
							$(product_description).html(product.description);

						var product_price = document.createElement('div');
							$(product_price).attr('class', 'product_price');
							$(product_price).attr('id', 'product_price_'+product.id);
							$(product_price).html('$'+product.price);

						var product_amount = document.createElement('input');
							$(product_amount).attr('class', 'product_amount_input');
							$(product_amount).attr('id', 'product_amount_'+product.id);
							$(product_amount).attr('type', 'number');
							$(product_amount).attr('value', 0);
							$(product_amount).attr('oninput', 'total('+product.id+')');

						var product_total = document.createElement('input');
							$(product_total).attr('class', 'product_total');
							$(product_total).attr('disabled', 'disabled');
							$(product_total).attr('id', 'product_total_'+product.id);
							$(product_total).attr('value', '$0');

						var product_edit = document.createElement("button");
							$(product_edit).attr('class', 'product_edit btn btn-warning');
							$(product_edit).attr('id', 'product_edit_'+product.id);
							$(product_edit).attr('onclick', 'editProduct('+product.id+')');
							$(product_edit).html('Edit');

						var product_delete = document.createElement("button");
							$(product_delete).attr('class', 'product_delete btn btn-danger');
							$(product_delete).attr('id', 'product_delete_'+product.id);
							$(product_delete).attr('onclick', 'deleteProduct('+product.id+')');
							$(product_delete).html('Delete');

						var product_show = document.createElement("button");
							$(product_show).attr('class', 'product_hide btn btn-info');
							$(product_show).attr('id', 'product_hide_'+product.id);
							$(product_show).attr('onclick', 'showProduct('+product.id+')');
							$(product_show).html('Show');

						$(product_containers).append(product_title);
						$(product_containers).append(product_unit);
						$(product_containers).append(product_description);
						$(product_containers).append(product_price);
						$(product_containers).append(product_edit);
						$(product_containers).append(product_delete);
						$(product_containers).append(product_show);

						$(container).append(product_containers);
					}
				});
			}
		}
		function total(id)
		{
			var price = document.getElementById('product_price_'+id).innerHTML.replace('$', '');
			var amount = document.getElementById('product_amount_'+id).value
			var total = $(document.getElementById('product_total_'+id)).attr('value', '$'+((price*amount).toFixed(2)));
			updateMaxTotal();
		}
		function updateMaxTotal()
		{
			var totals = document.getElementsByClassName('product_total');
			var total = 0;
			for(var j = 0; j < totals.length; j++)
			{
				total += parseFloat(totals[j].value.replace('$', ''));
			}
			$(document.getElementById('product_total_total')).html('Estimated Total For Items Selected: $'+(total.toFixed(2)));
		}
		function editProduct(id)
		{
			var title = document.getElementById('product_title_'+id),
				unit = document.getElementById('product_unit_'+id),
				description = document.getElementById('product_description_'+id),
				price = document.getElementById('product_price_'+id),
				product = document.getElementById('product_container_'+id),
				edit_button = document.getElementById('product_edit_'+id),
				delete_button = document.getElementById('product_delete_'+id);

			$(title).hide();
			$(unit).hide();
			$(description).hide();
			$(price).hide();
			$(edit_button).hide();
			$(delete_button).hide();

			var input_title = document.createElement("input");
				$(input_title).attr('class', title.className);
				$(input_title).attr('id', 'product_title_input');
				$(input_title).attr('type', 'text');
				$(input_title).attr('name', 'product_title_input');
				$(input_title).attr('value', $(title).html());

			var input_unit = document.createElement("input");
				$(input_unit).attr('class', unit.className);
				$(input_unit).attr('id', 'product_unit_input');
				$(input_unit).attr('type', 'text');
				$(input_unit).attr('name', 'product_unit_input');
				$(input_unit).attr('value', $(unit).html());

			var input_price = document.createElement("input");
				$(input_price).attr('class', price.className);
				$(input_price).attr('id', 'product_price_input');
				$(input_price).attr('type', 'number');
				$(input_price).attr('step', '.01');
				$(input_price).attr('name', 'product_price_input');
				$(input_price).attr('value', parseFloat(price.innerHTML.replace('$', '')));

			var input_description = document.createElement("textarea");
				$(input_description).attr('class', 'product_description product_input_description');
				$(input_description).attr('id', 'post_description_input');
				$(input_description).attr('name', 'product_description_input');
				$(input_description).html($(description).html());

			var submit_edit_button = document.createElement("button");
				$(submit_edit_button).attr('class', 'btn btn-primary submit_button');
				$(submit_edit_button).attr('type', 'submit');
				$(submit_edit_button).html('Submit Your Changes');

			var input_form = document.createElement("form");
				$(input_form).attr('method', 'POST');
				$(input_form).attr('action', "{{ URL('/api/products/edit') }}"+'/'+id);

			var csrf = document.createElement("input");
				$(csrf).attr('type', 'hidden');
				$(csrf).attr('value', '{{csrf_token()}}');
				$(csrf).attr('name', '_token');

			$(input_form).append(input_title);
			$(input_form).append(input_unit);
			$(input_form).append(input_description);
			$(input_form).append(input_price);
			$(input_form).append(submit_edit_button);
			$(input_form).append(csrf);

			$(product).prepend(input_form);
		}
		function deleteProduct(id)
		{
			if(confirm("Are You Sure You Want To Delete This Product? You Cannot Recover It Once It's Deleted."))
			{
				var product = document.getElementById('product_container_'+id);

				var input_form = document.createElement("form");
					$(input_form).attr('method', 'POST');
					$(input_form).attr('action', "{{ URL('/api/products/delete') }}"+'/'+id);

				var csrf = document.createElement("input");
					$(csrf).attr('type', 'hidden');
					$(csrf).attr('value', '{{csrf_token()}}');
					$(csrf).attr('name', '_token');

				$(input_form).append(csrf);

				$(product).append(input_form);
				$(input_form).submit();
			}
		}
		function hideProduct(id)
		{
			if(confirm("Hiding this will cause it to not appear on the price list, do you still wish to continue?"))
			{
				$.ajax({
			        url: "{{ URL('/api/products/hide') }}"+'/'+id,
			        type: "POST",
			        cache: false,
			        data: { _token: '{{ csrf_token() }}'},
			        success: function(data)
			        {
			        	$('.error_message').remove();
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Product Successfully Hidden");

			        	$('#product_hide_'+id).attr('onclick', 'showProduct('+id+')');
			        	$('#product_hide_'+id).html('Show');
			        	$('#product_form').prepend(error);
			        },
			        error: function(error_mess)
			        {
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Product Not Hidden, Error Occurred");

			        	$('#product_form').prepend(error);
			        }
			    });
			}
		}
		function showProduct(id)
		{
			if(confirm("Showing this will cause it to appear on the price list, do you still wish to continue?"))
			{
				$.ajax({
			        url: "{{ URL('/api/products/show') }}"+'/'+id,
			        type: "POST",
			        cache: false,
			        data: { _token: '{{ csrf_token() }}'},
			        success: function(data)
			        {
			        	$('.error_message').remove();
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Product Successfully Shown");

			        	$('#product_hide_'+id).attr('onclick', 'hideProduct('+id+')');
			        	$('#product_hide_'+id).html('Hide');
			        	$('#product_form').prepend(error);
			        },
			        error: function(data)
			        {
			        	var error = document.createElement("p");
			        		$(error).attr('class', 'error_message');
			        		$(error).html("Product Not Shown, Error Occurred");

			        	$('#product_form').prepend(error);
			        }
			    });
			}
		}
		function makeEmailDiv()
		{
			$('#inquiry_email_btn').hide();
			var emailContents = document.createElement("div");
				$(emailContents).attr('class', 'email_form');

			var emailForm = document.createElement('form');
				$(emailForm).attr('method', 'post');
				$(emailForm).attr('id', 'email_form');
				$(emailForm).attr('action', '{{ URL('/api/products/email') }}');

			var userMail = document.createElement("input");
				$(userMail).attr('type', 'email');
				$(userMail).attr('required', 'required');
				$(userMail).attr('id', 'user_email');
				$(userMail).attr('name', 'user_email');
				$(userMail).attr('placeholder', 'E-Mail Address');
				$(userMail).attr('class', 'form-text text-muted');

			var userName = document.createElement("input");
				$(userName).attr('type', 'text');
				$(userName).attr('required', 'required');
				$(userName).attr('id', 'user_name');
				$(userName).attr('name', 'user_name');
				$(userName).attr('placeholder', 'Your Name');
				$(userName).attr('class', 'form-text text-muted');

			var userPhone = document.createElement("input");
				$(userPhone).attr('type', 'tel');
				$(userPhone).attr('required', 'required');
				$(userPhone).attr('id', 'user_phone');
				$(userPhone).attr('name', 'user_phone');
				$(userPhone).attr('placeholder', '(207)-867-5309');
				$(userPhone).attr('class', 'form-text text-muted');

			var userComment = document.createElement("textarea");
				$(userComment).attr('id', 'user_comment');
				$(userComment).attr('name', 'user_comment');
				$(userComment).attr('placeholder', 'Add An Optional Comment Here');
				$(userComment).attr('class', 'form-text text-muted');

			var sendButton = document.createElement("input");
				$(sendButton).attr('type', 'button');
				$(sendButton).attr('class', 'btn btn-primary submit_button');
				$(sendButton).attr('onclick', 'sendEmail()');
				$(sendButton).attr('value', 'Send E-Mail');

			var csrf = document.createElement("input");
				$(csrf).attr('type', 'hidden');
				$(csrf).attr('value', '{{csrf_token()}}');
				$(csrf).attr('name', '_token');

			$(emailForm).append(userMail);
			$(emailForm).append(userName);
			$(emailForm).append(userPhone);
			$(emailForm).append(userComment);
			$(emailForm).append(sendButton);
			$(emailForm).append(csrf);

			$(emailContents).append(emailForm);

			$('#products_container').append(emailContents);
		}
		function sendEmail()
		{
			var products = document.getElementsByClassName('product');
			var total = 0;
			var emailForm = document.getElementById('email_form');

			for(var i = 0; i < products.length; i++)
			{
				if(products[i].getElementsByClassName('product_amount_input')[0].value != 0)
				{
					var items = [];
					var item = products[i].getElementsByClassName('product_title')[0].innerHTML;
					var amount = products[i].getElementsByClassName('product_amount_input')[0].value;
					var price = products[i].getElementsByClassName('product_price')[0].innerHTML.replace('$', '');
					
					items = [amount, item];

					var itemDetails = document.createElement("input");
						$(itemDetails).attr('hidden', 'hidden');
						$(itemDetails).attr('value', items);
						$(itemDetails).attr('name', 'grocery_item[]');

					$(emailForm).append(itemDetails);

					total += amount * price;
				}
			}

			var itemInput = document.createElement("input");
				$(itemInput).attr('hidden', 'hidden');
				$(itemInput).attr('value', total);
				$(itemInput).attr('name', 'total');

			$(emailForm).append(itemInput);

			emailForm.submit();
		}
		function countShownItems(data)
		{
			var count = 0;
			data.forEach(function(item, key) {
				if(item.hidden == 0)
					count++;
			});

			return count;
		}
	</script>
@endsection