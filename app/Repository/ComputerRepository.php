<?php

namespace App\Repository;

use App\Models\Computer;
use Illuminate\Http\Request;

class ComputerRepository
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return Computer[]
     */
    public function getAll(): array
    {
        return Computer::all()->all();
    }

    public function findById(int $id): ?Computer
    {
        return Computer::find($id);
    }
}
