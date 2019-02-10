<?php

declare(strict_types=1);

namespace Hoop\Domain;

final class Highlight
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $player_id;

    public function __construct(int $id, string $title, string $description, int $player_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->player_id = $player_id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getPlayerId(): int
    {
        return $this->player_id;
    }

    /**
     * @param int $player_id
     */
    public function setPlayerId(int $player_id): void
    {
        $this->player_id = $player_id;
    }
}