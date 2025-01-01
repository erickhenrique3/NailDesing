<?php

namespace Domain\Auth\Contracts;

use Domain\Auth\DTOs\LoginDTO;

interface AuthContract
{
  public function exec (LoginDTO $input);
}