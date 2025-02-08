<?php

use App\Models\User;

beforeEach(function () {
    // Se necessário, crie um usuário para testar o login
    $this->user = User::factory()->create([
        'email' => 'testuser@example.com',
        'password' => bcrypt('password123'), // ou use Hash::make() se preferir
    ]);
});

it('can login with valid credentials', function () {
    // Simula um login com dados válidos
    $response = $this->postJson('/user/login', [
        'email' => 'testuser@example.com',
        'password' => 'password123',
    ]);

    // Verifica se a resposta foi bem-sucedida
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'token',
        'user' => [
            'id',
            'email',
            'name',
        ],
    ]);
});

it('fails login with invalid credentials', function () {
    // Tenta logar com credenciais inválidas
    $response = $this->postJson('/user/login', [
        'email' => 'wronguser@example.com',
        'password' => 'wrongpassword',
    ]);

    // Verifica se a resposta foi de erro
    $response->assertStatus(401);
    $response->assertJson([
        'error' => 'Unauthorized',
    ]);
});
