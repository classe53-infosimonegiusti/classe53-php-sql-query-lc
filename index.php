<?php

/* METTI QUI I VALORI DEL TUO MYSQL! */

define("DB_SERVERNAME", 'localhost');
define("DB_USERNAME", 'root');
define("DB_PASSWORD", 'root');
define("DB_NAME", 'university');

$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn && $conn->connect_error) {
    echo "Connessione fallita: " . $conn->connect_error;
}

$nomeDaCercare = $_GET['ciccio'];

/* SOGGETTA A SQL INJECTION CHE CAUSANO DATA LEAKS*/
/* NON USARE MAI QUESTO PEZZO DI CODICE SE NON PER SCOPI DIDATTICI!!!! *?


/*
$query = "SELECT * FROM students WHERE name = '{$nomeDaCercare}';";

//SELECT * FROM students WHERE name = ''; select * from degrees where 1=1 OR name = '';
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {

    while ($currentRow = $result->fetch_assoc()) {
        echo "Studente: " . $currentRow['name'] . ' - ' . $currentRow['surname'] . ' - ' . $currentRow['email'] . '<br>'; 
    }
} else if ($result) {
    echo "0 risultati";
} else {
    echo "Query error!!!";
}
*/


//VERSIONE SICURA CON BINDING DEI PARAMETRI

// prepare and bind
$stmt = $conn->prepare("SELECT * FROM students WHERE name = (?)");
$stmt->bind_param("s",$nomeDaCercare);
$stmt->execute();
$result=$stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($currentRow = $result->fetch_assoc()) {
        echo "Studente: " . $currentRow['name'] . ' - ' . $currentRow['surname'] . ' - ' . $currentRow['email'] . '<br>'; 
    }
} else if ($result) {
    echo "0 risultati";
} else {
    echo "Query error!!!";
}

$stmt->close();




/* SOGGETTA A SQL INJECTION CHE POTENZIALMENTE DANNO ACCESSO COMPLETO AL DB*/
/* NON USARE MAI QUESTO PEZZO DI CODICE SE NON PER SCOPI DIDATTICI!!!! *?


//'; DROP DATABASE university; select * from degrees where 1=1 OR name = '

/*
$query = "SELECT * FROM students WHERE name = '{$name}'";

// Execute multi query
if ($conn->multi_query($query)) {
    do {
        // Store first result set
        if ($result = $conn->store_result()) {
            while ($row = $result->fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result -> free_result();
        }
        // if there are more result-sets, the print a divider
        if ($conn->more_results()) {
            printf("-------------\n");
        }
        //Prepare next result set
    } while ($conn->next_result());
}
*/



$conn->close();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="GET">
        <input name="ciccio" type="text" placeholder="Inserisci il nome dello studente">
        <button type="submit">Cerca!</button>
    </form>
</body>
</html>