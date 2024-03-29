<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "ajax_tuto");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_REQUEST["term"])){
    // Préparer une déclaration de sélection
    $sql = "SELECT * FROM countries WHERE name LIKE ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Lier des variables à l'instruction préparée en tant que paramètres
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Définir les paramètres
        $param_term = $_REQUEST["term"] . '%';
        
        // Tentative d'exécution de l'instruction préparée
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Vérifier le nombre de lignes dans le jeu de résultats
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["name"] . "</p>";
                }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Déclaration de clôture
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>