<?php

namespace App\Services;

use App\Exception\UserCheckExistsException;
use App\Models\User;
use Exception;

class UserService
{
    private Database $database;

    public function __construct(Database $db)
    {
        $this->database = $db;
    }

    /**
     * @throws UserCheckExistsException
     * @throws Exception
     */
    public function createUser(array $userData): User
    {

        $repository = new UserRepository($this->database);

        $user = new User($userData);
        try {
            $repository->saveUser($user);
        } catch (UserCheckExistsException $e) {
            throw new Exception("Ошибка в создании пользователя: " . $e->getMessage());
        }

        return $user;
    }
}
