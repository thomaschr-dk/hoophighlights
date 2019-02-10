<?php

declare(strict_types=1);

namespace Hoop\Repository;

use Hoop\Database\Database;

final class HighlightRepository implements Repository
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function find(int $id)
    {
        return $this->database->find($id, 'highlight');
    }

    public function findBy(array $params)
    {
        return $this->database->findBy('highlight', $params);
    }

    public function findAll()
    {
        return $this->database->findAll('highlight');
    }

    public function findAllByPlayerId(int $playerId)
    {
        /*$junctionRecords = $this->database->findBy('player_highlight', array('player_id' => $playerId, 'highlight_id' => 1));
        $highlightIds = [];

        foreach ($junctionRecords as $junctionRecord) {
            $highlightIds[] = $junctionRecord['highlight_id'];
        }*/

        $highlights = $this->database->findAll('highlight', array('player_id' => $playerId));

        return $highlights;
    }
}