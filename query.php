<?php
// Connessione al database
include ('mysql.php');
$tipo =$_GET["sql"];
// Query per recuperare i dati
switch ($tipo) {
    case "elenco":
        $sql = "call fivb.TournamentCalendar(".$_GET["anno"].", '".$_GET["gender"]."');";
        break;
    case "entrylist":
        $sql = "call fivb.entry_list4(".$_GET["id"].");";
        //echo $sql;
        break;            
    case "tournament":
        $sql = "SELECT * FROM viewtournament WHERE no=".$_GET["id"];
        break;            
    }
$result = $con->query($sql);

// Costruzione dell'output HTML
$output="";
switch ($tipo) {
    case "elenco":
        if ($result->num_rows > 0) {
            $output= "<tr><th>ID</th><th>Inizio</th><th>Tipo</th><th>Nome</th><th>Nazione</th></tr>";
            while($row = $result->fetch_assoc()) {
                $datatorneo=date_format(date_create($row["StartDate"]),"d/m/Y");
                $output= $output."<tr onclick='location.href=\"entrylist.html?id=".$row["no"]."\"'><td>" . $row["no"] . "</td><td>" . $datatorneo . "</td><td>" . $row["Name"] . "</td><td>" . $row["Title"] . "</td><td>" . $row["country"] . "</td></tr>";
            }
        } else {
            $output= "Nessun risultato";
        }
        echo $output;
        break;
    case "entrylist":
        if ($result->num_rows > 0) {
            $output= "<tr><th>Rank</th><th>Player1</th><th>Player2</th><th>Team</th><th>Punti</th><th>Tabellone</th></tr>";
            while($row = $result->fetch_assoc()) {
                $output= $output. "<tr><td>" . $row["entryRank"] . "</td><td>" . $row["player1"] . "</td><td>" . $row["player2"] . "</td><td>" . $row["teamname"] . "</td><td>" . $row["Totale"] . "</td><td>" . $row["tabellone"] . "</td></tr>";
            }
        } else {
            $output= "Nessun risultato";
        }
        echo $output;
        break;
    case "tournament":
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $output= $output. $row["name"]."|".$row["title"]."|".$row["description"]."|".$row["gender"]."|".$row["StartDate"]; 
            }
        } else {
            $output = "Nessun risultato";
        }
        echo $output;
        break;            
}    
// Chiusura della connessione al database
$con->close();
?>
