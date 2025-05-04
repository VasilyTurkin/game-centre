<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\ComputerRepository;

class TestController extends Controller
{
    private ComputerRepository $computerRepository;

    public function __construct(ComputerRepository $computerRepository)
    {
        $this->computerRepository = $computerRepository;
    }

    public function index(): void
    {
//        $userId = User::where('id', 43)->first();
//        dd($userId);

//        $users = User::all();
//        dd($users);

        $deposit = User::where('deposit', '>', 1000)
        ->orderBy('name')->take(10)->get();

        dd($deposit);

    }
}
