<?php

namespace App\Repository;

use App\Models\User;
use App\Exceptions\UserCheckExistsException;
use Exception;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    /**
     * @param string $email
     * @return bool
     */
    public function checkUserByEmail(string $email): bool
    {
        return (new User)->where('email', $email)->exists();
    }

    /**
     * @param int $id
     * @return User
     * @throws Exception
     */
    public function getUserById(int $id): User
    {
        $user = (new User)->find($id);

        if (!$user) {
            throw new Exception("Пользователь с ID $id не найден");
        }

        return $user;
    }

    /**
     * @param array $userData
     * @return User
     * @throws UserCheckExistsException
     * @throws Exception
     */
    public function saveUser(array $userData): User
    {
        try {
            if ($this->checkUserByEmail($userData['email'])) {
                throw new UserCheckExistsException('Пользователь с таким email уже существует');
            }

            return (new User)->create([
                'name' => $userData['username'] ?? $userData['login'],
                'email' => $userData['email'],
                'password' => $userData['password_hash'] ?? $userData['password'],
                'deposit' => $userData['deposit'] ?? 0,
            ]);

        } catch (UserCheckExistsException $e) {
            Log::error('Ошибка сохранения пользователя: ' . $e->getMessage());
            throw $e;

        } catch (Exception $e) {
            Log::error('Неожиданная ошибка при сохранении пользователя: ' . $e->getMessage());
            throw new Exception("Ошибка при сохранении пользователя: " . $e->getMessage());
        }
    }

    /**
     * @param User $user
     * @param float $amount
     * @return void
     */
    public function updateDeposit(User $user, float $amount): void
    {
        $user->deposit = $amount;
        $user->save();
    }
}
