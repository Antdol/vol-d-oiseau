<?php

require_once "Utilities.php";
require_once "VilleRepo.php";
require_once "LogRepo.php";
require_once "config.php";

header("Content-Type: application/json");

$villeRepo = new VilleRepo(CONFIG);
$logRepo = new LogRepo(CONFIG);

$data = [];

if (!empty($_POST)) {
    $ville1 = $villeRepo->getLatAndLongById($_POST["ville1-id"]);
    $ville2 = $villeRepo->getLatAndLongById($_POST["ville2-id"]);
    $distance = Utilities::calculateDistance(
        (float) $ville1["latitude"],
        (float) $ville1["longitude"],
        (float) $ville2["latitude"],
        (float) $ville2["longitude"]
    );
    $data["distance"] = round($distance);
    $logRepo->insertLog($_POST["ville1-id"], $_POST["ville2-id"], $data["distance"]);
}

echo json_encode($data);
