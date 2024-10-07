<?php

namespace App;

class UrlCheckRepository
{
    private \PDO $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function findByUrlId(int $urlId): array
    {
        $checks = [];
        $sql = "SELECT * FROM url_checks WHERE url_id = :url_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':url_id', $urlId);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $urlCheck = UrlCheck::create($row['url_id'], $row['created_at']);
            $urlCheck->setId($row['id']);
            $urlCheck->setStatusCode($row['status_code']);
            $urlCheck->setH1($row['h1']);
            $urlCheck->setTitle($row['title']);
            $urlCheck->setDescription($row['description']);
            $checks[] = $urlCheck;
        }

        return $checks;
    }

    public function create(UrlCheck $urlCheck): void
    {
        $sql = "INSERT INTO url_checks (url_id, status_code, h1, title, description, created_at) 
                VALUES (:url_id, :status_code, :h1, :title, :description, :created_at)";
        $stmt = $this->conn->prepare($sql);

        $urlId = $urlCheck->getUrlId();
        $stmt->bindParam(':url_id', $urlId);
        $statusCode = $urlCheck->getStatusCode();
        $stmt->bindParam(':status_code', $statusCode);
        $h1 = $urlCheck->getH1();
        $stmt->bindParam(':h1', $h1);
        $title = $urlCheck->getTitle();
        $stmt->bindParam(':title', $title);
        $description = $urlCheck->getDescription();
        $stmt->bindParam(':description', $description);
        $dateTime = $urlCheck->getDateTime();
        $stmt->bindParam(':created_at', $dateTime);
        $stmt->execute();
        $id = (int)$this->conn->lastInsertId();
        $urlCheck->setId($id);
    }
}
