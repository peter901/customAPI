<?php

class TaskGateway{

    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnetion();
    }

    public function getAll(): array 
    {
        $sql = "select * from task order by name";

        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}