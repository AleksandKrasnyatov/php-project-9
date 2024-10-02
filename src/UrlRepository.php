<?php

namespace App;

class UrlRepository
{
    private \PDO $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getEntities(): array
    {
        $urls = [];
        $sql = "SELECT u.id, u.name, u.created_at, uc.created_at AS check_time, uc.status_code
                FROM urls u 
                LEFT JOIN url_checks uc 
                ON u.id = uc.url_id
                ORDER BY u.created_at DESC";
        $stmt = $this->conn->query($sql);

        while ($row = $stmt->fetch()) {
            if (array_key_exists($row['id'], $urls)) {
                $existUrl = $urls[$row['id']];
                if ($existUrl->getLastCheckedAt() > $row['check_time']) {
                    continue;
                }
            }
            $url = Url::create($row['name'], $row['created_at']);
            $url->setId($row['id']);
            $url->setLastCheckedAt($row['check_time']);
            $url->setStatus($row['status_code']);
            $urls[$row['id']] = $url;
        }

        return $urls;
    }

    public function find(int $id): ?Url
    {
        $sql = "SELECT * FROM urls WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            $url = Url::create($row['name'], $row['created_at']);
            $url->setId($row['id']);
            return $url;
        }

        return null;
    }

    public function findByName(string $name): ?Url
    {
        $sql = "SELECT * FROM urls WHERE name = :name";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $url = Url::create($row['name'], $row['created_at']);
            $url->setId($row['id']);
            return $url;
        }

        return null;
    }

    public function save(Url $url): void
    {
        if ($url->exists()) {
            $this->update($url);
        } else {
            $this->create($url);
        }
    }

    private function update(Url $url): void
    {
        $sql = "UPDATE urls SET name = :name, created_at = :created_at WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $id = $url->getId();
        $name = $url->getName();
        $created_at = $url->getDateTime();
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    private function create(Url $url): void
    {
        $sql = "INSERT INTO urls (name, created_at) VALUES (:name, :created_at)";
        $stmt = $this->conn->prepare($sql);
        $name = $url->getName();
        $created_at = $url->getDateTime();
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->execute();
        $id = (int)$this->conn->lastInsertId();
        $url->setId($id);
    }
}
