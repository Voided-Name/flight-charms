<?php

namespace app\models;

use Flight;

class FacultyModel
{
  public static function getVerifiedFaculty()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT users.id as user_id_alias, userdetails.*,  faculty.*, campuses.*, faculty_rankings.* FROM users LEFT JOIN userdetails ON users.id=userdetails.user_id LEFT JOIN faculty ON userdetails.user_id=faculty.user_id LEFT JOIN campuses on faculty.campus_id=campuses.campusID LEFT JOIN faculty_rankings ON faculty.acadrank_id=faculty_rankings.faculty_rank_id WHERE users.is_verified = '1' AND users.role = '3' ORDER BY users.created_at ASC;");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public static function getUnverifiedFaculty()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT users.id as user_id_alias, userdetails.*,  faculty.*, campuses.*, faculty_rankings.* FROM users LEFT JOIN userdetails ON users.id=userdetails.user_id LEFT JOIN faculty ON userdetails.user_id=faculty.user_id LEFT JOIN campuses on faculty.campus_id=campuses.campusID LEFT JOIN faculty_rankings ON faculty.acadrank_id=faculty_rankings.faculty_rank_id WHERE users.is_verified = '0' AND users.role = '3' ORDER BY users.created_at ASC;");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public static function getRejectedFaculty()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT users.id as user_id_alias, userdetails.*,  faculty.*, campuses.*, faculty_rankings.* FROM users LEFT JOIN userdetails ON users.id=userdetails.user_id LEFT JOIN faculty ON userdetails.user_id=faculty.user_id LEFT JOIN campuses on faculty.campus_id=campuses.campusID LEFT JOIN faculty_rankings ON faculty.acadrank_id=faculty_rankings.faculty_rank_id WHERE users.is_verified = '2' AND users.role = '3' ORDER BY users.created_at ASC;");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
