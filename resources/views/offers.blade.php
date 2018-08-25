@extends('layouts.app')

@section('navbar-navigation')
<a class='tab' href="{{ url('contact') }}">Contact Us</a>
<a class='tab' href="{{ url('philosophy') }}">What We're About</a>
<a class='tab' href="{{ url('news') }}">What We've Been Up To</a>
<a class='tab' href="{{ url('location') }}">Where To Find Us</a>
@endsection

@section('content')

@endsection