<?php

namespace App\Services;

use Domain\Auth\Repositories\UserRepository;

class UserService
{
  protected $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function getAllUsers(){
    return $this->userRepository->getAllUsers();
  }

  public function getUserById($id){
    return $this->userRepository->findUserById($id);
  }

  public function createUser($data){
    return $this->userRepository->createUser($data);
  }

  public function updateUser($user, array $data){
    return $this->userRepository->updateUser($user, $data);
  }

  public function deleteUser($user){
    return $this->userRepository->deleteUser($user);
  }
}