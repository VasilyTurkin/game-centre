<?php

namespace App\Repository;

use App\Models\User;
use Exception;

class UserRepository
{
    public function checkUserByEmail(string $email): bool
    {
        $query = 'SELECT * FROM user WHERE email = :email LIMIT 1';
        $checkQuery = $this->pdo->prepare($query);
        $checkQuery->bindParam(':email', $email);
        $checkQuery->execute();

        return (bool)$checkQuery->fetch();
    }

    public function getUserById(int $id): User
    {
        $query = 'SELECT * FROM user WHERE id = :id LIMIT 1';
        $checkQuery = $this->pdo->prepare($query);
        $checkQuery->bindParam(':id', $id);
        $checkQuery->execute();

        $user = $checkQuery->fetch(PDO::FETCH_ASSOC);

        return new User($user);
    }

    /**
     * @throws Exception
     */
    public function saveUser(User $user): void
    {
        $login = $user->getLogin();
        $email = $user->getEmail();
        $passwordHash = $user->getPasswordHash();
        $username = $user->getName();
        $deposit = $user->getDeposit();

        $query = 'INSERT INTO user(login, email, password_hash, username, deposit)
                    VALUES (:login, :email, :password_hash, :username, :deposit)';
        $insertUser = $this->pdo->prepare($query);

        $insertUser->bindParam(':login', $login);
        $insertUser->bindParam(':email', $email);
        $insertUser->bindParam(':password_hash', $passwordHash);
        $insertUser->bindParam(':username', $username);
        $insertUser->bindParam(':deposit', $deposit);

        $insertUser->execute();
    }
}
