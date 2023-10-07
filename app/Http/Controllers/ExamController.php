<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;

class ExamController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $feature = $request->query('feature') ?? '';
        $exams   = Exam::all();
        // print_r($exams);
        return view('exam.index', compact('exams', 'feature'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $file = $request->file('file');
        // $posts     = Post::all();
        $exam_name = '';
        $titles    = [];
        $options   = [];
        // dd($options);
        // $docxFilePath = public_path('temp/test.docx');
        if (!isset($file)) {
            $error = 'File is required';
            return redirect()->route('exams.index', [
                'feature' => 'create',
            ])->with('error', $error);
        }
        $phpWord  = IOFactory::createReader('Word2007')->load($file->path());
        $sections = $phpWord->getSections();
        foreach ($sections as $section) {
            foreach ($section->getElements() as $childElements) {
                if (method_exists($childElements, 'getElements')) {
                    $elements = $childElements->getElements();
                    foreach ($elements as $element) {
                        if (method_exists($element, 'getText')) {
                            if (str_starts_with($element->getText(), '--')) {
                                $exam_name = explode('--', $element->getText())[1];
                            }
                            if (!preg_match('/^[a-dA-D]\.|^--|\*.*$/', $element->getText())) {
                                $title = trim($element->getText());
                                $a     = str_replace("\xC2\xA0", '', $title);
                                if (!empty($a)) {
                                    // Xử lý tiếp theo với tiêu đề
                                    if (strcmp($title, "&nbsp;") > 0) {
                                        array_push($titles, $title);
                                    }
                                }
                            }
                            if (preg_match('/^\*[ABCDEabcd]|^[a-dA-D]\./', $element->getText())) {
                                $option = $element->getText();
                                array_push($options, $option);
                            }
                        } else if (method_exists($element, 'getContent')) {
                        }
                    }
                } else if (method_exists($childElements, 'getText')) {
                }
            }
        }

        $options_chunked = array_chunk($options, 4);

        $questions = [];
        // print_r($titles);
        // print_r($options_chunked);
        foreach ($titles as $key => $title) {
            if ($title != '&nbsp;') {
                $options = $options_chunked[$key];
                // find the answer from the options by start with *
                $answer  = '';
                $answers = array_filter($options, function ($option) {
                    return str_starts_with($option, '*');
                });
                // print_r($answers);
                if (!empty($answers)) {
                    $answer = explode('*', $answers[array_key_first($answers)])[1];
                }

                $mapperOptions = array_map(function ($option) {
                    return str_replace('*', '', $option);
                }, $options);
                $question = [
                    'question_text' => $title,
                    'options'       => json_encode($mapperOptions),
                    'answer'        => $answer,
                ];
                array_push($questions, $question);
            }
        }
        // print_r($questions);
        $createdExam = Exam::create([
            'exam_name'        => $exam_name,
            'exam_description' => $request->input('exam_description'),
            'exam_type'        => $request->input('exam_type'),
            'exam_duration'    => (int) $request->input('exam_duration'),
            'exam_status'      => $request->input('exam_status'),
            'created_by'       => 1,
        ]);
        foreach ($questions as $question) {
            // print_r(json_decode($question['options']));
            $createdQuestion = Question::create([
                'exam_id'       => $createdExam->exam_id,
                'question_text' => $question['question_text'],
                'options'       => $question['options'],
                'answer'        => $question['answer'],
            ]);
            // print_r($createdQuestion);
        }
        return redirect()->route('exams.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Exam $exam) {
        $question_query = $request->query('question') ?? '';
        $answer_query   = $request->query('answer') ?? '';

        $questions = Question::where('exam_id', $exam->exam_id)->get();
        if (!$request->session()->has('exam_id')) {
            $request->session()->put('exam_id', $exam->exam_id);
        }
        if ($question_query == '') {
            $current_question = $questions->first();
        } else {
            $current_question = Question::where('question_id', $question_query)->first();
        }

        if (!$request->session()->has('done_questions') || $exam->exam_id != $request->session()->get('exam_id')) {
            $request->session()->put('done_questions', []);
            $request->session()->put('exam_id', $exam->exam_id);
        }
        if ($answer_query != '') {
            $doneQuestionsFromSession = $request->session()->get('done_questions');
            $doneQuestions            = array_filter(
                $doneQuestionsFromSession,
                function ($doneQuestion) use ($question_query) {
                    return array_key_first($doneQuestion) != $question_query;
                }
            );
            $doneQuestions[$current_question->question_id] = [
                'question_id' => $question_query,
                'answer'      => $answer_query,
            ];

            $request->session()->put('done_questions', $doneQuestions);

        }
        return view('exam.show', compact('exam', 'questions', 'current_question', 'answer_query', 'question_query'), ['doneQuestions' => $request->session()->get('done_questions')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam) {
        //
    }
}