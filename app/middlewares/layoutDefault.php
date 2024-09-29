<?php

namespace app\middlewares;

use flight\Engine;
use Flight;

class layoutDefault
{
  public function after()
  {
    Flight::render('layout', []);
  }
}
