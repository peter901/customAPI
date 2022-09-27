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
        $sql = "select * from task order by id";

        $stmt = $this->conn->query($sql);

        $data = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['is_completed'] = (bool) $row['is_completed'];
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO task (name, priority, is_completed) 
        VALUES (:name, :priority, :is_completed)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);

        if(empty($data["priority"])){

            $stmt->bindValue(":priority",null, PDO::PARAM_NULL);
        }else{
            $stmt->bindValue(":priority", $data["priority"], PDO::PARAM_INT);
        }

        $stmt->bindValue(":is_completed",$data["is_completed"] ?? false, PDO::PARAM_BOOL);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function update(array $data)
    {

    }
}