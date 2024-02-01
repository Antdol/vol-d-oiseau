<?php

require_once "config.php";
require_once "VilleRepo.php";

$villeRepo = new VilleRepo(CONFIG);

// Open csv file
$handle;
try {
    $handle = fopen("villes.csv", "r");
} catch (Exception $e) {
    exit("Could not open file.");
}

$i = 0;
while (($line = fgetcsv($handle)) !== false) {
    if ($i == 0) {
        $i++;
        continue;
    }
    $insertData = [$line[1], $line[10], $line[4], $line[3], $line[14], $line[15], $line[12]];
    $villeRepo->insertVille($insertData);
}

fclose($handle);
exit("success");
