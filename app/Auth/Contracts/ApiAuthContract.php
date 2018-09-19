<?php

namespace App\Auth\Contracts;

interface ApiAuthContract
{
    public function login(string $username = '', string $password = ''): bool;

    public function logout();

    public function roles(string $userId = ''): array;

    public function permissions(string $userId = ''): array;

    public function getCurrentId(): string;

    public function setCurrentId(string $currentId = '');

    public function createToken(string $username = ''): string;

    public function verifyToken(string $token = null): bool;
}
