@extends('layouts.rootLayout')

@section('content')
	<div
		class="mb-1 flex items-center justify-between">
		<h1 class="tw-text-red-600 text-xl font-semibold">
			Exam</h1>
		@if (!$feature)
			<button
				class="rounded-sm bg-green-600 px-4 py-1 font-semibold text-white duration-150 hover:opacity-70"><a
					href="?feature=create">Create
					exam</a></button>
		@endif
	</div>
	@forelse ($exams as $exam)
		<h2><a
				href="exams/{{ $exam->exam_id }}">{{ $exam->exam_name }}</a>
		</h2>
	@empty
		<p>no exam</p>
	@endforelse
	@if ($feature)
		<form action="{{ route('exams.store') }}"
			method="POST" enctype="multipart/form-data"
			class="my-2 flex items-center justify-between rounded-md border p-4">
			@csrf
			<input type="file" name="file"
				id="file">
			<button type="submit"
				class="rounded-sm bg-green-600 px-4 py-1 font-semibold text-white duration-150 hover:opacity-70">Create</button>
		</form>
	@else
	@endif
@endsection
