<?php

require_once "VilleRepo.php";
require_once "config.php";

header("Content-Type: application/json");

$villeRepo = new VilleRepo(CONFIG);

$data = [];
$result = [];

if (!empty($_GET)) {

    $result = $villeRepo->getFirstTenLike($_GET["search"]);
}

$data["liste"] = json_encode($result);

echo $data["liste"];
