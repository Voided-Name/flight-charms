<?php

namespace app\middlewares;

use flight\Engine;
use Flight;

class guard
{
  public function after()
  {
    Flight::render('layout', []);
  }
  public static function requireRole($requiredRole)
  {
    session_start();
    if (!isset($_SESSION['rolename']) || $_SESSION['rolename'] != $requiredRole) {
      // Redirect to unauthorized page or login if role doesn't match
      Flight::redirect(Flight::request()->base . '/unauthorized');
      exit();
    }
  }
}
