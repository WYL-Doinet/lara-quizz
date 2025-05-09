<?php

namespace App\Http\Controllers;

use App\Http\Services\QuestionService;
use App\Http\Services\QuizAttemptService;
use App\Http\Services\QuizService;
use App\Http\Services\UserService;
use App\Models\Choice;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class QuizController extends Controller
{

    protected $quizService;
    protected $questionService;
    protected $quizAttemptService;
    protected $userService;

    public function  __construct(
        QuizService $quizService,
        QuestionService $questionService,
        QuizAttemptService $quizAttemptService,
        UserService $userService
    ) {
        $this->quizService = $quizService;
        $this->questionService = $questionService;
        $this->quizAttemptService = $quizAttemptService;
        $this->userService = $userService;
    }

    public function index()
    {
        $quizzes = $this->quizService->findAll();
        return Inertia::render('Quiz/Index', [
            'quizzes' => $quizzes
        ]);
    }

    public function show(Request $request, $id)
    {
        $quizAttempt = $this->quizAttemptService->findFirst([
            'quiz_id' => $id,
            'user_id' => $request->user()->id,
            'completed_at' => null
        ]);

        if (!$quizAttempt) {
            abort(404);
        }

        $quiz = $this->quizService->find($quizAttempt->quiz_id);
        $questions = $this->questionService->findByQuizId($quiz->id);

        return Inertia::render('Quiz/Show', [
            'quiz' => $quiz,
            'questions' => $questions,
            'quizAttempt' =>  $quizAttempt,
        ]);
    }

    public function answer(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $quizAttempt = $this->quizAttemptService->findFirst([
                'quiz_id' => $id,
                'user_id' => $request->user()->id,
                'completed_at' => null
            ]);


            $questions = $this->questionService->findByQuizId($quizAttempt->quiz_id)->pluck('id')->toArray();

            $choiceIds = $request->input('choice_ids');

            $choices =  Choice::whereIn('id', $choiceIds)->get()->makeVisible(['is_correct'])->toArray();


            $data = [];
            $score = 0;

            foreach ($choices  as $choice) {
                if (in_array($choice['question_id'], $questions)) {

                    $data[] = [
                        'quiz_attempt_id' => $quizAttempt->id,
                        'question_id' => $choice['question_id'],
                        'choice_id' => $choice['id'],
                    ];

                    if ($choice['is_correct']) {
                        $score = $score + 1;
                    }
                }
            }

            UserAnswer::insert($data);

            $quizAttempt->update([
                'score' =>  $score,
                'completed_at' => now(),
            ]);
            DB::commit();
            return redirect()->route('quiz.attempt');
        } catch (Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            abort(500, $e->getMessage());
        }
    }

    public function assign(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $userIds = $request->input('user_ids');
            $this->quizAttemptService->store($id, $userIds);
        }

        if ($request->isMethod('get')) {
            $userIds = $this->quizAttemptService->findAll(filters: ['quiz_id' => $id])->pluck('user_id');
            return Inertia::render('Quiz/Assign', [
                'users' => fn() =>  $this->userService->findMany($userIds)
            ]);
        }
    }


    public function attempt(Request $request)
    {
        $user = $request->user();
        $quizIds = $this->quizAttemptService->findAll(filters: ['user_id' => $user->id])->pluck('quiz_id');
        $quizzes =  Quiz::whereIn('id', $quizIds)
            ->addSelect([
                'score' => QuizAttempt::select('score')
                    ->where('user_id', $user->id)
                    ->whereColumn('quiz_id', 'quizzes.id')
                    ->take(1),
                'completed_at' => QuizAttempt::select('completed_at')
                    ->where('user_id', $user->id)
                    ->whereColumn('quiz_id', 'quizzes.id')
                    ->take(1)
            ])
            ->get();

        return Inertia::render('Quiz/Attempt', [
            'quizzes' => $quizzes,
        ]);
    }
}
