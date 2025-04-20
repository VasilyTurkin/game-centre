<?php

namespace App\Services;

use App\Exceptions\UserCheckExistsException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * @param array $userData
     * @return User
     * @throws UserCheckExistsException
     * @throws Exception
     */
    public function createUser(array $userData): User
    {
        try {
            if ((new User)->where('email', $userData['email'])->exists()) {
                throw new UserCheckExistsException('Пользователь с таким email уже существует');
            }

            return (new User)->create([
                'login' => $userData['login'],
                'email' => $userData['email'],
                'userName' => $userData['userName'] ?? null,
                'password' => $userData['password'],
                'deposit' => $userData['deposit'] ?? 0,
            ]);

        } catch (UserCheckExistsException $e) {
            Log::error('Ошибка создания пользователя: ' . $e->getMessage());
            throw $e;

        } catch (Exception $e) {
            Log::error('Неожиданная ошибка при создании пользователя: ' . $e->getMessage());
            throw new Exception("Ошибка в создании пользователя: " . $e->getMessage());
        }
    }
}
