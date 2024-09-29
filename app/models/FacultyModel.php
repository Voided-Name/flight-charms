<?php

namespace app\models;

use Flight;

class FacultyModel
{
  public static function getUnverifiedFaculty()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM users JOIN userdetails ON users.id=userdetails.user_id JOIN FACULTY ON userdetails.user_id=FACULTY.user_id WHERE users.is_verified = '0' AND users.role = '3' ORDER BY users.created_at ASC");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
