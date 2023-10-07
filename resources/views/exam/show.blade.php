@extends('layouts.rootLayout')

@section('content')
	<h1
		class="tw-text-red-600 mb-10 text-2xl font-semibold">
		Exam:
		<span class="italic">{{ $exam->exam_name }}</span>
	</h1>
	<div class="flex justify-between">
		<section class="mr-2">
			<div class="flex items-center">
				<label for="auto-next-question">Auto next
					question&nbsp;
				</label>
				<input type='checkbox' id='auto-next-question'
					class="input-auto-switch border outline-none">
			</div>
			<div class="flex items-center">
				<label for="">Auto next
					question after&nbsp;</label>
				<input type='number' value="1"
					min="0"
					class="input-timer border outline-none"
					max="5">(s)
			</div>
		</section>
		<section
			class="flex flex-1 flex-col items-center">
			<h2 class="text-xl font-semibold">
				{{ $current_question->question_text }}
			</h2>
			{{-- options --}}
			<ul class="flex flex-col gap-y-2 py-2">
				@forelse (json_decode($current_question->options) as $option)
					<a @class([
						'flex cursor-pointer rounded-lg border px-4 py-2' => true,
						'bg-red-600 text-white' =>
							($answer_query != $current_question->answer &&
								$answer_query == $option) ||
							(isset($doneQuestions[$current_question->question_id]['answer']) &&
								$doneQuestions[$current_question->question_id]['answer'] ===
									$option &&
								$option !== $current_question->answer),
						'bg-green-600 text-white' =>
							($answer_query == $current_question->answer &&
								$answer_query == $option) ||
							(isset($doneQuestions[$current_question->question_id]['answer']) &&
								$option === $current_question->answer),
						'hover:bg-blue-500 hover:text-white' => !$answer_query,
					])
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
		{{-- list questions index btn --}}
		<section
			class="flex max-w-[20vw] flex-wrap gap-4 rounded-lg border p-4">
			@forelse ($questions as $key => $question)
				<div @class([
					'flex h-10 w-10 items-center justify-center rounded-md border duration-150' => true,
					'bg-red-600 text-white' =>
						isset($doneQuestions[$question->question_id]['answer']) &&
						$doneQuestions[$question->question_id]['answer'] !== $question->answer,
					'bg-green-600 text-white' =>
						isset($doneQuestions[$question->question_id]['answer']) &&
						$doneQuestions[$question->question_id]['answer'] == $question->answer,
					'bg-blue-600 text-white' =>
						$current_question->question_id == $question->question_id,
					'text-black hover:bg-blue-400' =>
						!$current_question->question_id == $question->question_id,
				])>
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
@section('script')
	<script>
		const AUTO_NEXT_QUESTION_AFTER =
			'auto-next-question-after'
		const AUTO_NEXT_QUESTION_ENABLED =
			'auto-next-question-enabled'
		const inputTimer = document.querySelector(
			'.input-timer');
		const autoSwitch = document.querySelector(
			'.input-auto-switch');
		inputTimer.onchange = (e) => {
			window.localStorage.setItem(
				AUTO_NEXT_QUESTION_AFTER, e
				.target
				.value)
		}
		autoSwitch.onchange = (e) => {
			window.localStorage.setItem(
				AUTO_NEXT_QUESTION_ENABLED, e
				.target
				.checked)
		}


		inputTimer.value = window.localStorage.getItem(
			AUTO_NEXT_QUESTION_AFTER || 1)
		autoSwitch.checked = JSON.parse(window
			.localStorage
			.getItem(
				AUTO_NEXT_QUESTION_ENABLED || true))


		let questions = {!! json_encode($questions) !!}
		// console.log(questions)
		let searchParams = new URLSearchParams(
			window.location.search);
		const questionQuery = searchParams.get(
			'question')
		const answerQuery = searchParams.get('answer')
		const currentQuestionIndex = questions.findIndex(
			question => question.question_id ==
			questionQuery)
		if (answerQuery) {
			if (currentQuestionIndex < questions.length -
				1 && autoSwitch.checked) {
				setTimeout(() => {
						const location = window
							.location;
						const nextID =
							questionQuery ?
							questions[
								currentQuestionIndex +
								1].question_id :
							questions[
								currentQuestionIndex +
								1].question_id + 1
						const newUrl = location
							.origin + location
							.pathname +
							'?question=' + nextID
						window.location.href =
							newUrl;
					}, Number(inputTimer.value) *
					1000);
			}
		}
		if (!questionQuery) {
			const newUrl = location
				.origin + location
				.pathname +
				'?question=' + questions[0].question_id
			window.location.href =
				newUrl;
		}
	</script>
@endsection
