<?php

namespace app\models;

use Flight;

class EmployerModel
{
  public static function getVerifiedEmployer()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT 
      users.id AS user_id_alias, 
      users.*, 
      userdetails.*, 
      employer_users.*, 
      companies.*
    FROM 
      users
    LEFT JOIN 
      userdetails ON users.id = userdetails.user_id
    LEFT JOIN 
      employer_users ON userdetails.user_id = employer_users.user_id
    LEFT JOIN 
      companies ON employer_users.company_id = companies.company_id
    WHERE 
      users.is_verified = '1' 
      AND users.role = '2'
    ORDER BY 
      users.created_at ASC;
    ");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public static function getEmployer()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT 
      users.id AS user_id_alias, 
      users.*, 
      userdetails.*, 
      employer_users.*, 
      companies.*
    FROM 
      users
    LEFT JOIN 
      userdetails ON users.id = userdetails.user_id
    LEFT JOIN 
      employer_users ON userdetails.user_id = employer_users.user_id
    LEFT JOIN 
      companies ON employer_users.company_id = companies.company_id
    WHERE 
      users.role = '2'
    ORDER BY 
      users.created_at ASC;
    ");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public static function getUnverifiedEmployer()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT 
      users.id AS user_id_alias, 
      users.*, 
      userdetails.*, 
      employer_users.*, 
      companies.*
    FROM 
      users
    LEFT JOIN 
      userdetails ON users.id = userdetails.user_id
    LEFT JOIN 
      employer_users ON userdetails.user_id = employer_users.user_id
    LEFT JOIN 
      companies ON employer_users.company_id = companies.company_id
    WHERE 
      users.is_verified = '0' 
      AND users.role = '2'
    ORDER BY 
      users.created_at ASC;
    ");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public static function getRejectedEmployer()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT 
      users.id AS user_id_alias, 
      users.*, 
      userdetails.*, 
      employer_users.*, 
      companies.*
    FROM 
      users
    LEFT JOIN 
      userdetails ON users.id = userdetails.user_id
    LEFT JOIN 
      employer_users ON userdetails.user_id = employer_users.user_id
    LEFT JOIN 
      companies ON employer_users.company_id = companies.company_id
    WHERE 
      users.is_verified = '2' 
      AND users.role = '2'
    ORDER BY 
      users.created_at ASC;
    ");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
