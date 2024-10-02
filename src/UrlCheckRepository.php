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
            $checks[] = $urlCheck;
        }

        return $checks;
    }

    public function save(UrlCheck $urlCheck): void
    {
        if ($urlCheck->exists()) {
            $this->update($urlCheck);
        } else {
            $this->create($urlCheck);
        }
    }

    private function update(UrlCheck $urlCheck): void
    {
    }

    private function create(UrlCheck $urlCheck): void
    {
        $sql = "INSERT INTO url_checks (url_id, created_at) VALUES (:url_id, :created_at)";
        $stmt = $this->conn->prepare($sql);
        $urlId = $urlCheck->getUrlId();
        $created_at = $urlCheck->getDateTime();
        $stmt->bindParam(':url_id', $urlId);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->execute();
        $id = (int)$this->conn->lastInsertId();
        $urlCheck->setId($id);
    }
}
