<?php

namespace App\Http\Controllers;

use App\Http\Services\QuizAttemptService;
use App\Http\Services\QuizService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $quizAttemptService;
    protected $quizService;

    public function __construct(UserService $userService,
     QuizAttemptService $quizAttemptService, QuizService $quizService)
    {
        $this->userService = $userService;
        $this->quizAttemptService = $quizAttemptService;
        $this->quizService = $quizService;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $users = $this->userService->findAll($request->query('q'));
            return response()->json(['users' => $users]);
        }
    }

   
}
