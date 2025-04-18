<?php

namespace App\Http\Controllers;

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
        $computers = $this->computerRepository->findById(1);

        dd($computers);
    }
}
