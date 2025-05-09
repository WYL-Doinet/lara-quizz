<?php

namespace App\Http\Services;

use App\Models\Quiz;

class QuizService
{

    protected $quiz;


    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;

    }

    public function findAll()
    {
        return $this->quiz->all();
    }

    public function find($id)
    {
        return $this->quiz->findOrFail($id);
    }

    public function findMany($ids)
    {
        return $this->quiz->whereIn('id', $ids)->get();
    }

}
