<?php

/**
 * VilleRepo
 * 
 * class to access the ville table in the ville_de_france DB
 * 
 */

class VilleRepo
{
    private PDO $db;

    /**
     * instantiate a new VilleRepo object
     * 
     * @param array $config associative array that must contains 3 keys: dsn, user, password
     */
    public function __construct(array $config)
    {
        try {
            $this->db = new PDO($config["dsn"], $config["user"], $config["password"]);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            exit("There was an error");
        }
    }

    /**
     * getAll
     * 
     * @return array associative array containing every city in the DB
     */
    public function getAll()
    {
        $query = "SELECT * FROM ville";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVilleById($id)
    {
        $query = "SELECT * FROM ville WHERE ville_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("id", $id, PDO::PARAM_STR);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVilleByName($name)
    {
        $query = "SELECT * FROM ville WHERE nom = :nom";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("nom", $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * @param string $nom Name of the city
     * @param int $dep_num Department number of the city
     * @return array array containing latitude and longitude of the city as string
     */
    public function getLatAndLongById($id)
    {
        $query = "SELECT latitude, longitude FROM ville WHERE ville_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("id", $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * getFirstTenLike
     * 
     * @param string $nameStart the beginning of the name of the cities to retrieve
     * 
     * @return array array of maximum length 10, containing cities with names starting with $nameStart
     */
    public function getFirstTenLike($nameStart)
    {
        $query = "SELECT ville_id, nom, dep_num, dep_nom FROM ville WHERE nom LIKE :nameStart ORDER BY nom LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("nameStart", $nameStart . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertVille(array $data)
    {
        $query = "INSERT INTO ville(ville_id, nom, code_p, dep_num, dep_nom, latitude, longitude, altitude)
            VALUES(UUID(), :nom, :code_p, :dep_num, :dep_nom, :latitude, :longitude, :altitude)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("nom", $data[0], PDO::PARAM_STR);
        $stmt->bindValue("code_p", $data[1], PDO::PARAM_STR);
        $stmt->bindValue("dep_num", $data[2], PDO::PARAM_INT);
        $stmt->bindValue("dep_nom", $data[3], PDO::PARAM_STR);
        $stmt->bindValue("latitude", $data[4], PDO::PARAM_STR);
        $stmt->bindValue("longitude", $data[5], PDO::PARAM_STR);
        $stmt->bindValue("altitude", $data[6], PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteVille($id)
    {
        $query = "DELETE FROM ville WHERE ville_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("id", $id, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
