<?php

class HealthRepository
{
    public function __construct(private PDO $db)
    {
    }

    public function databaseIsAvailable(): bool
    {
        $stmt = $this->db->prepare('SELECT 1');
        $stmt->execute();

        return (int) $stmt->fetchColumn() === 1;
    }
}
