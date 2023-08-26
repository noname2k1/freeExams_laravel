@extends('layouts.rootLayout')

@section('content')
	<h1
		class="tw-text-red-600 mb-10 text-2xl font-semibold">
		Exam:
		<span class="italic">{{ $exam->exam_name }}</span>
	</h1>
	<div class="flex justify-between">
		<section
			class="flex flex-1 flex-col items-center justify-center">
			<h2 class="text-xl font-semibold">
				{{ $current_question->question_text }}
			</h2>

			{{-- {{ $current_question->options }} --}}
			<ul class="flex flex-col gap-y-2 py-2">
				@forelse (json_decode($current_question->options) as $option)
					<a
						class="{{ $answer_query != $current_question->answer && $answer_query == $option ? 'bg-red-600 text-white' : '' }} {{ $answer_query == $current_question->answer && $answer_query == $option ? 'bg-green-600 text-white' : '' }} {{ $answer_query ? '' : 'hover:bg-blue-500 hover:text-white' }} flex cursor-pointer rounded-lg border px-4 py-2"
						href="?question={{ $question_query }}&answer={{ $option }}"><span>{{ $option }}</span></a>
				@empty
					<p>No option</p>
				@endforelse
				@if (
					$answer_query &&
						$answer_query !=
							$current_question->answer)
					<span class="px-4 py-2">
						Correct answer:
						<strong>{{ $current_question->answer }}</strong>
					</span>
				@endif
			</ul>
		</section>
		{{-- list questions --}}
		<section class="flex gap-4 rounded-lg border p-4">
			@forelse ($questions as $key => $question)
				<div
					class="{{ $current_question->question_id == $question->question_id ? 'bg-blue-600 text-white' : 'text-black hover:bg-blue-400' }} flex h-10 w-10 items-center justify-center rounded-md border duration-150">
					<a
						href="?question={{ $question->question_id }}"
						class="flex h-full w-full items-center justify-center"><span
							class="font-semibold">{{ $key + 1 }}</span></a>
				</div>
			@empty
			@endforelse
		</section>
	</div>
@endsection
