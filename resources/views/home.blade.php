@extends('layouts.rootLayout')

@section('content')
	Home page
	@forelse ($posts as $post)
		<h1>{{ $post->id }}</h1>
	@empty
		<h1>No posts</h1>
	@endforelse
@endsection
