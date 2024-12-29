<?php

namespace app\Repositories;

use App\Models\User;

class UserRepository {
  
  public function getAllUsers()
  {
    return User::all();
  }

  public function findUserById($id)
  {
    return User::find($id);
  }

  public function createUser(array $data)
  {
    return user::create($data);
  }

  public function updateUser(User $user, array $data)
  {
    return $user->update($data);
  }

  public function deleteUser(User $user)
  {
    return $user->delete();
  }
}