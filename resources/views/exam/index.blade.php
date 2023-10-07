@extends('layouts.rootLayout')

@section('content')
	<div class="mb-1 flex flex-col items-center">
		@if (!$feature)
			<div class="mb-10 flex w-full justify-between">
				<h1
					class="tw-text-red-600 text-xl font-semibold">
					Exam</h1>
				<button
					class="rounded-sm bg-green-600 text-2xl font-semibold text-white duration-150 hover:opacity-70">
					<a class="inline-block h-full w-full px-4 py-1"
						href="?feature=create">+</a>
				</button>
			</div>
			<div
				class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
				@forelse ($exams as $exam)
					<div @class([
						'flex flex-col rounded border bg-contain bg-no-repeat px-4 pb-2 pt-10 text-white shadow-lg' => true,
						'bg-it-pattern' => $exam->exam_type === 'it',
						'bg-language-pattern' => $exam->exam_type === 'language',
						'bg-other-pattern' => $exam->exam_type === 'other',
					])>
						<h2 title="{{ $exam->exam_name }}"
							class="inline-block overflow-hidden text-ellipsis whitespace-nowrap">
							{{ $exam->exam_name }}</h2>
						<p title="{{ $exam->exam_description }}">
							Description:
							{{ $exam->exam_description ? $exam->exam_description : 'No description' }}
						</p>
						<p>Duration:
							{{ $exam->exam_duration / 60 / 1000 }}
							minutes</p>
						<p>Created at:
							{{ $exam->created_at->format('d/m/Y m:h:s') }}
						</p>
						<a
							class="my-1 mt-4 block rounded-md bg-green-500 py-1 text-center text-white duration-150 hover:bg-teal-600 hover:font-semibold"
							href="exams/{{ $exam->exam_id }}">Start</a>
					</div>
				@empty
					<p class="text-2xl font-semibold">EMPTY
					</p>
				@endforelse
			</div>
			{{-- {!! json_encode($exams) !!} --}}
		@else
			{{-- create exam --}}
			<h1
				class="tw-text-red-600 text-xl font-semibold">
				Create Exam</h1>
			<form action="{{ route('exams.store') }}"
				method="POST" enctype="multipart/form-data"
				class="my-2 flex flex-col items-center justify-between rounded-md border p-4">
				@csrf
				<div class="mb-2 flex items-center">
					<label class="mr-1">Exam
						type:</label>
					<select name="exam_type"
						class="border outline-none">
						<option value="it">it</option>
						<option value="language">language</option>
						<option value="other">other</option>
					</select>
				</div>
				<div class="mb-2 flex items-center">
					<label class="mr-1">Exam
						status:</label>
					<select name="exam_status"
						class="border outline-none">
						<option value="draft">draft</option>
						<option value="published">published</option>
						<option value="archived">archived</option>
					</select>
				</div>
				<div class="mb-2 flex items-center">
					<label class="mr-1">Exam
						duration:</label>
					<select name="exam_duration"
						class="border outline-none">
						<option value="3600000">60 minutes</option>
						<option value="7200000">120 minutes
						</option>
					</select>
				</div>
				<textarea name="exam_description" cols="30"
				 rows="10" placeholder="Exam description..."
				 class="border p-4 outline-none"></textarea>
				<input type="file" name="file"
					class="mt-4" id="file">
				@if (session('error'))
					<p class="font-semibold text-red-600">
						{{ session('error') }}</p>
				@endif
				<button type="submit"
					class="mt-1 rounded-sm bg-green-600 px-4 py-1 font-semibold text-white duration-150 hover:opacity-70">Create</button>
			</form>
		@endif
	</div>
@endsection
