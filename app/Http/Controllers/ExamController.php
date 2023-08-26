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
                            if (str_starts_with($element->getText(), '**')) {
                                $title = explode('**', $element->getText())[1];
                                array_push($titles, $title);
                            }
                            if (preg_match('/^\*[ABCDE]|^A|^B|^C|^D|^E/', $element->getText())) {
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
        $questions       = [];
        foreach ($titles as $key => $title) {
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
        $createdExam = Exam::create([
            'exam_name'        => $exam_name,
            'exam_description' => 'test',
            'exam_type'        => 'test',
            'exam_duration'    => 1000 * 60 * 60,
            'exam_status'      => 'draft',
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
            print_r($createdQuestion);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam) {
        //
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