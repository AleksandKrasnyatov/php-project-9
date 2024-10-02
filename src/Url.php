<?php

namespace App;

class Url
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $created_at = null;
    private ?string $last_checked_at = null;
    private ?int $status = null;

    public static function create(string $name, string $time = null): Url
    {
        $url = new Url();
        $url->setName($name);
        if ($time !== null) {
            $url->setDateTime($time);
        }
        return $url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDateTime(): ?string
    {
        return $this->created_at;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function getLastCheckedAt(): ?string
    {
        return $this->last_checked_at;
    }

    public function setLastCheckedAt(?string $last_checked_at): void
    {
        $this->last_checked_at = $last_checked_at;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }
}
