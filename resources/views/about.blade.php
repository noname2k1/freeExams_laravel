@extends('layouts.rootLayout')

@section('content')
	about page
	@forelse ($posts as $post)
		<h1>{{ $post->id }}</h1>
	@empty
		<h1>No posts</h1>
	@endforelse
@endsection
