<?php 


class Database {

    private string $host;
    private string $name;
    private string $user;
    private string $password;


    public function __construct(string $host, string $name,string $user,string $password)
    {
        $this->host = $host;
        $this->name = $name;
        $this->user = $user;
        $this->password = $password;
    }

    public function getConnetion(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";

        return new PDO($dsn, $this->user,$this->password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}