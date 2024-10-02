<?php

namespace App;

class UrlCheck
{
    private ?int $id = null;
    private ?int $url_id = null;
    private ?int $status_code = null;
    private ?string $h1 = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $created_at = null;

    public static function create(int $urlId, string $time = null): UrlCheck
    {
        $url = new UrlCheck();
        $url->setUrlId($urlId);
        if ($time !== null) {
            $url->setDateTime($time);
        }
        return $url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlId(): ?int
    {
        return $this->url_id;
    }

    public function getDateTime(): ?string
    {
        return $this->created_at;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUrlId(int $urlId): void
    {
        $this->url_id = $urlId;
    }
    public function exists(): bool
    {
        return !is_null($this->getId());
    }

    public function setDateTime(string $time): void
    {
        $this->created_at = $time;
    }

    public function setCurrentTime(): void
    {
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function getStatusCode(): ?int
    {
        return $this->status_code;
    }

    public function setStatusCode(?int $status_code): void
    {
        $this->status_code = $status_code;
    }

    public function getH1(): ?string
    {
        return $this->h1;
    }

    public function setH1(?string $h1): void
    {
        $this->h1 = $h1;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
