<?php

class LogRepo
{
    private $db;

    public function __construct($config)
    {
        try {
            $this->db = new PDO($config["dsn"], $config["user"], $config["password"]);
        } catch (Exception $e) {
            exit("Could not connect to DB");
        }
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAll()
    {
        $query = "SELECT a.nom as ville1, b.nom as ville2, requested_at, distance FROM log
            INNER JOIN ville a
            ON log.ville1_id = a.ville_id
            INNER JOIN ville b
            ON log.ville2_id = b.ville_id
            ORDER BY requested_at DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastTen()
    {
        $query = "SELECT a.nom as ville1, b.nom as ville2, requested_at, distance FROM log
            INNER JOIN ville a
            ON log.ville1_id = a.ville_id
            INNER JOIN ville b
            ON log.ville2_id = b.ville_id
            ORDER BY requested_at DESC
            LIMIT 10";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertLog($ville1_id, $ville2_id, $distance)
    {
        $query = "INSERT INTO log(log_id, ville1_id, ville2_id, distance) 
            VALUES(UUID(), :ville1_id, :ville2_id, :distance)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("ville1_id", $ville1_id, PDO::PARAM_STR);
        $stmt->bindValue("ville2_id", $ville2_id, PDO::PARAM_STR);
        $stmt->bindValue("distance", $distance, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
