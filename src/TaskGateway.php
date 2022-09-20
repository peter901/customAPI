<?php

class TaskGateway{

    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnetion();
    }

    public function get(string $id) 
    {
        $sql = "select * from task where id = :id";

        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(":id",$id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll(): array 
    {
        $sql = "select * from task order by name";

        $stmt = $this->conn->query($sql);

        $data = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['is_completed'] = (bool) $row['is_completed'];
            $data[] = $row;
        }

        return $data;
    }
}