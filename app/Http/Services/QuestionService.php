<?php
namespace App\Http\Services;

use App\Models\Question;

class QuestionService {
    protected $question;
    
    public function __construct(
        Question $question
    )
    {
        $this->question = $question;
    }

    public function findByQuizId($id)
    {
        return $this->question->where('quiz_id', $id)->get();
    }
}


