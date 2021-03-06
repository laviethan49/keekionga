@extends('layouts.app')

@section('content')
	<div>
		{{$name}} would like
		@foreach($list as $listItem)
			<br>
			{{ str_replace(',', ' ', $listItem) }},
		@endforeach
		<br><br>
		for a total of ${{ $total }}. {{ $name }} can be reached at {{ $phone }}.
		@if($comment != null)
		<br><br>
		They left a comment: "{{ $comment }}"
		@endif
	</div>
@endsection