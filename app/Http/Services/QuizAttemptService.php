<?php

namespace App\Http\Services;

use App\Models\QuizAttempt;

class QuizAttemptService
{
    protected $quizAttempt;
    public function __construct(QuizAttempt $quizAttempt)
    {
        $this->quizAttempt = $quizAttempt;
    }

    public function store($quizId, $userIds)
    {
        $data = [];

        foreach ($userIds as $userId) {
            $data[] = [
                'quiz_id' => $quizId,
                'user_id' => $userId,
            ];
        }

        $this->quizAttempt->upsert($data, uniqueBy: ['quiz_id', 'user_id']);
    }


    public function findAll($filters)
    {
        return $this->quizAttempt->filters($filters)->get();
    }


    public function findFirst($filters)
    {
        return $this->quizAttempt->filters($filters)->first();
    }
}
