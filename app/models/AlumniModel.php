<?php

namespace app\models;

use Flight;

class AlumniModel
{
  public static function getUnverifiedAlumni()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT users.id AS user_id_alias, -- Aliasing users.id
       users.*, 
       userdetails.*, 
       alumni_graduated_course.*, 
       courses.*, 
       coursesmajor.*, 
       campuses.*
      FROM users
      LEFT JOIN userdetails ON users.id = userdetails.user_id
      LEFT JOIN alumni_graduated_course ON userdetails.user_id = alumni_graduated_course.user_id
      LEFT JOIN courses ON alumni_graduated_course.course_id = courses.courseID
      LEFT JOIN coursesmajor ON alumni_graduated_course.major_id = coursesmajor.major_id
      LEFT JOIN campuses ON alumni_graduated_course.campus = campuses.campusID
      WHERE users.is_verified = '0' 
        AND users.role = '1'
      ORDER BY users.created_at ASC;
    ");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
  public static function getRejectedAlumni()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT users.id AS user_id_alias, -- Aliasing users.id
       users.*, 
       userdetails.*, 
       alumni_graduated_course.*, 
       courses.*, 
       coursesmajor.*, 
       campuses.*
      FROM users
      LEFT JOIN userdetails ON users.id = userdetails.user_id
      LEFT JOIN alumni_graduated_course ON userdetails.user_id = alumni_graduated_course.user_id
      LEFT JOIN courses ON alumni_graduated_course.course_id = courses.courseID
      LEFT JOIN coursesmajor ON alumni_graduated_course.major_id = coursesmajor.major_id
      LEFT JOIN campuses ON alumni_graduated_course.campus = campuses.campusID
      WHERE users.is_verified = '2' 
        AND users.role = '1'
      ORDER BY users.created_at ASC;
    ");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
