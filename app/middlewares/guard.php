<?php

namespace app\middlewares;

use Flight;

class guard
{
  private $requiredRole;
  public function before()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start(); // Ensure session is started
    }
    if (!isset($_SESSION['rolename']) || $_SESSION['rolename'] != $this->requiredRole) {
      // Redirect to unauthorized page or login if role doesn't match
      Flight::redirect(Flight::request()->base . '/unauthorized');
      exit();
    }
  }

  public function __construct($requiredRole)
  {
    $this->requiredRole = $requiredRole;
  }
}
