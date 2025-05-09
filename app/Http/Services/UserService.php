<?php
namespace App\Http\Services;

use App\Models\User;

class UserService {
    protected $user;

    public function __construct(User $user)
    {
        $this->user= $user;
    }

    public function findAll($q)
    {
        return $this->user->filter($q)->get();
    }

    public function findMany($ids)
    {
        return $this->user->whereIn('id', $ids)->get();
    }
}