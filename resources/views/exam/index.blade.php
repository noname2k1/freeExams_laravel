@extends('layouts.rootLayout')

@section('content')
	<h1 class="tw-text-red-600 font-semibold text-xl">Exam</h1>
	<a href="?feature=create">Create exam</a>
	@forelse ($exams as $exam)
		<h2>{{ $exam->exam_name }}</h2>
	@empty
		<p>no exam</p>
	@endforelse
	@if ($feature)
		<form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="file" name="file" id="file">
			<button type="submit">Create</button>
		</form>
	@else
	@endif
@endsection
