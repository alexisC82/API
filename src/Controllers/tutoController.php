<?php

namespace tutoAPI\Controllers;

use tutoAPI\Models\TutoManager;
use tutoAPI\Models\Tuto;
use tutoAPI\Controllers\abstractController;

class tutoController extends abstractController
{

    public function show($id)
    {

        // Données issues du Modèle

        $manager = new TutoManager();

        $tuto = $manager->find($id);

        // Template issu de la Vue

        return $this->jsonResponse($tuto, 200);
    }

    public function index($page) {
        $manager = new TutoManager();

        switch($page) {
          case 1:
            $a = 1;
            $b = 4;
            break;
          case 2:
            $a = 5;
            $b = 8;
            break;
            case 3:
              $a = 9;
              $b = 12;
              break;
        }

        $tutos = $manager->findAllPagination($a, $b);

        return $this->jsonResponse($tutos, 200);
    }

    public function add()
    {
        // Ajout d'un tuto
      $tuto = new Tuto();
      $manager = new TutoManager();

      $now = new \DateTime();
      $dateString = date( 'Y-m-d', $now->getTimestamp());

      $tuto->setTitle($_POST['title']);
      $tuto->setDescription($_POST['description']);
      $tuto->setCreatedAt($_POST['createdAt']);
      $tuto->setCreatedAt($dateString);

      $tuto = $manager->add($tuto);

      return $this->jsonResponse($tuto, 201);
    }

    public function update($id) {

      $manager = new TutoManager();
      $tuto = $manager->find($id);

      parse_str(file_get_contents('php://input'), $_PATCH);
      var_dump($_PATCH);

      foreach ($_PATCH as $key => $value){
        if (!empty($key) and $key == "title"){
          $tuto->setTitle($_PATCH['title']);
        }
        elseif (!empty($key) and $key == "description"){
          $tuto->setDescription($_PATCH['description']);
        }

      }

      $newTuto = $manager->update($tuto);
      return $this->jsonResponse($newTuto, 200);
    }

    public function delete($id) {
        // Données issues du Modèle
        $manager = new TutoManager();

        $tuto = $manager->find($id);
        $manager->delete($id);

        return $this->jsonResponse($tuto, 200);
    }


}
