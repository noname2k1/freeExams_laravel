@extends('layouts.rootLayout')

@section('content')
	<h1 class="tw-text-red-600">Post</h1>
	{{-- @forelse ($posts as $post)
		<h2>{{ $post->option_text }}</h2>
	@empty
		<p>no post</p>
	@endforelse --}}
	<p>{{ $body }}</p>
@endsection
