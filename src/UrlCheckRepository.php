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

        $stmt->bindParam(':url_id', $urlCheck->getUrlId());
        $stmt->bindParam(':status_code', $urlCheck->getStatusCode());
        $stmt->bindParam(':h1', $urlCheck->getH1());
        $stmt->bindParam(':title', $urlCheck->getTitle());
        $stmt->bindParam(':description', $urlCheck->getDescription());
        $stmt->bindParam(':created_at', $urlCheck->getDateTime());
        $stmt->execute();
        $id = (int)$this->conn->lastInsertId();
        $urlCheck->setId($id);
    }
}
