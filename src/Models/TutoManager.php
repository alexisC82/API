<?php

namespace tutoAPI\Models;

use tutoAPI\Services\Manager;

class TutoManager extends Manager
{

    public function find($id)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        // Instanciation d'un tuto
        $tuto = new Tuto();
        $tuto->setId($result["id"]);
        $tuto->setTitle($result["title"]);
        $tuto->setDescription($result["description"]);
        $tuto->setCreatedAt($result["createdAt"]);

        // Retour
        return $tuto;
    }

    public function findAll()
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos');
        $sth->execute();

        $tutos = [];

        while($row = $sth->fetch(\PDO::FETCH_ASSOC)){

            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;

        }

        return $tutos;

    }

    public function findAllPagination($a , $b)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos WHERE id BETWEEN :a AND :b');
        $sth->bindValue(':a', $a);
        $sth->bindValue(':b', $b);
        $sth->execute();

        $tutos = [];

        while($row = $sth->fetch(\PDO::FETCH_ASSOC)){

            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;

        }

        return $tutos;

    }

    public function add(Tuto $tuto) {

        // Connexion à la BDD
        $dbh = static::connectDb();

        $title = $tuto->getTitle();
        $description = $tuto->getDescription();
        $createdAt = $tuto->getCreatedAt();

        // Requête
        $sth = $dbh->prepare('INSERT INTO tutos (title, description, createdAt) VALUES (:title, :description, :createdAt)');
        $sth->bindValue(':title', $title);
        $sth->bindValue(':description', $description);
        $sth->bindValue(':createdAt', $createdAt);
        $sth->execute();

        // Retour
        $id = $dbh->lastInsertId();
        $tuto->setId($id);
        return $tuto;

    }

    public function update(Tuto $tuto) {
      // Connexion à la BDD
      $dbh = static::connectDb();

      $id = $tuto->getId();
      $title = $tuto->getTitle();
      $description = $tuto->getDescription();
      $createdAt = $tuto->getCreatedAt();

      // Requête
      $sth = $dbh->prepare('UPDATE tutos SET title = :title, description = :description, createdAt = :createdAt WHERE id = :id');
      $sth->bindValue(':id', $id);
      $sth->bindValue(':title', $title);
      $sth->bindValue(':description', $description);
      $sth->bindValue(':createdAt', $createdAt);
      $sth->execute();

      // Retour
      return $tuto;

    }

    public function delete($id) {
        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('DELETE FROM tutos WHERE id = :id');
        $sth->bindValue(':id', $id);
        $sth->execute();
    }
}
