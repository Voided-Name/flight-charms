<?php

namespace app\controllers;

use flight\Engine;
use Flight;

Flight::path(__DIR__ . '/../../');

use app\middlewares\guard;
use app\models\AlumniModel;
use app\models\EmployerModel;
use app\models\FacultyModel;
use app\controllers\baseController;

class facultyController
{
  protected Engine $app;

  public function __construct($app)
  {
    $this->app = $app;
  }

  public function index()
  {
    $_SESSION['facultyPage'] = "dashboard";

    Flight::render('header', [], 'header');
    Flight::render('faculty/sidebar', [], 'sidebar');
    $this->app->render('faculty/home', ['username' => $_SESSION['username']], 'home');
  }

  public function postAnnouncement()
  {
    $_SESSION['facultyPage'] = "postAnnouncement";

    Flight::render('header', [], 'header');
    Flight::render('faculty/sidebar', [], 'sidebar');
    $this->app->render('faculty/postAnnouncement', ['username' => $_SESSION['username']], 'home');
  }

  public function postAnnouncementMethod()
  {
    $title = strip_tags(Flight::request()->data->announcement_title);
    $body = strip_tags(Flight::request()->data->announcement_details);
    $user = $_SESSION['userid'];

    $db = Flight::db();
    $stmt = $db->prepare('INSERT INTO announcements (announcement_title, announcement_body, announcement_date, announcement_author) VALUES (:announcement_title, :announcement_body, :announcement_date, :userid)');
    $status = $stmt->execute(['announcement_title' => $title, 'announcement_body' => $body, 'announcement_date' => date('Y-m-d H:i:s'), 'userid' => $user]);

    Flight::redirect(Flight::request()->base . "/dashboard/faculty/postAnnouncement");
  }

  public function postAnnouncementManage()
  {
    $_SESSION['facultyPage'] = "announcement";

    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM announcements ORDER BY announcement_date DESC');
    $status = $stmt->execute();
    $announcementData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $authorDataList = [];

    bdump($announcementData);

    foreach ($announcementData as $announcementDataInstance) {
      if (!array_key_exists($announcementDataInstance['announcement_author'], $authorDataList)) {
        $stmt = $db->prepare('SELECT * FROM userdetails WHERE user_id = :authorid');
        $status = $stmt->execute(['authorid' => $announcementDataInstance['announcement_author']]);
        $authorData = $stmt->fetch(\PDO::FETCH_ASSOC);
        $authorName = $authorData['last_name'] . ', ' .  $authorData['first_name'];
        $authorDataList[$announcementDataInstance['announcement_author']] = $authorName;
      }
    }


    Flight::view()->set('announcementData', $announcementData);
    Flight::view()->set('authorDataList', $authorDataList);

    Flight::render('header', [], 'header');
    Flight::render('faculty/sidebar', [], 'sidebar');
    $this->app->render('faculty/announcementManage', ['username' => $_SESSION['username']], 'home');
  }

  public function editAnnouncement()
  {

    $title = strip_tags(Flight::request()->data->announcement_title);
    $body = strip_tags(Flight::request()->data->announcement_title);
    $announcementID = Flight::request()->data->editAnnouncementBtn;

    $db = Flight::db();
    $stmt = $db->prepare('UPDATE announcements SET announcement_title = :announcement_title, announcement_body = :announcement_body WHERE announcement_id = :announcement_id');
    $status = $stmt->execute(['announcement_title' => $title, 'announcement_body' => $body, 'announcement_id' => $announcementID]);

    Flight::redirect(Flight::request()->base . "/dashboard/faculty/postAnnouncementManage");
  }

  public function deleteAnnouncement()
  {

    $announcementID = Flight::request()->data->deleteAnnouncementBtn;

    $db = Flight::db();
    $stmt = $db->prepare('DELETE FROM announcements WHERE announcement_id = :announcement_id');
    $status = $stmt->execute(['announcement_id' => $announcementID]);

    Flight::redirect(Flight::request()->base . "/dashboard/faculty/postAnnouncementManage");
  }
}
