<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
</head>

<body>
    <?php
    //connexion à la BDD
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $base = "manon";
    $table = "proprietaire";
    $conn = mysqli_connect($host, $user, $passwd, $base);
    if (mysqli_connect_errno()) {
        echo "Erreur de connexion a MySQL: " . mysqli_connect_errno();
        exit(0);
    }
    mysqli_set_charset($conn, "utf8");
    ?>

    <form method="POST">
         <input type="text" name="recherche" id="recherche">
    <input type="submit" name="rechercher" value="Rechercher"><br /><br />
       

        <input type='submit' name='ajouter' value='Ajouter un proprietaire'><br/><br />

    <?php

    if (!empty($_REQUEST["rechercher"])) {
        $recherche = $_REQUEST["recherche"];


        /* Affichage complet de la table */
        $query = "        SELECT * FROM proprietaire WHERE prenom_proprietaire LIKE ('$recherche') 
                            or nom_proprietaire LIKE ('$recherche') 
                            or region_proprietaire LIKE ('$recherche') 
                            or telephone_proprietaire LIKE ('$recherche');";
        $result = mysqli_query($conn, $query) or die("Echec de requête3");


/*
        if($_REQUEST["recherche"] = " ")
        {
            $query = "SELECT * FROM proprietaire;";
            $result = mysqli_query($conn, $query) or die("Echec de requête3");
        }*/

        $nb_reponses = mysqli_num_rows($result);
        if ($nb_reponses <= 0) {
            echo "<br /> aucune personne ne correspond a ce nom";
        } else {
            /* Balayer chaque enregistrement de la table */
            echo "<table>";
            echo "<tr> 
            <th> nom </th>
            <th> prenom </th>
            <th> region </th>
            </tr>";
            while ($ligne = mysqli_fetch_array($result)) {
                echo "<form method ='get'>";

                //cookie
                echo "<input type='hidden' name='id_client' value='" . $ligne['id_proprietaire'] . "'>";
    
    
                echo "<tr>";
                echo "<td>" . $ligne['nom_proprietaire'] . "</td>";
                echo "<td>" . $ligne['prenom_proprietaire'] . "</td>";
                echo "<td>" . $ligne['region_proprietaire'] . "</td>";
                echo "<td> <input type='submit' name='acceder' value='Acceder'> </td>";
                echo "<td> <input type='submit' name='supprimer' value='Supprimer'></td>";

    
                echo "</tr>";
                echo "</form>"; 
            }
            echo "</table>\n";
            /* Libération du résultat */
            mysqli_free_result($result);
            /* Fermeture de la connexion */
            mysqli_close($conn);
        }
    } else {

        /* Affichage complet de la table */
        $query = "SELECT * FROM proprietaire;";
        $result = mysqli_query($conn, $query) or die("Echec de requête3");


        /* Balayer chaque enregistrement de la table */
        echo "<table>";
        echo "<tr> 
        <th> nom </th>
        <th> prenom </th> 
        <th> region </th>
        </tr>";

        while ($ligne = mysqli_fetch_array($result)) {
            echo "<form method ='get'>";

            //cookie
            echo "<tr>";

            
            echo "<input type='hidden' name='id_client' value='" . $ligne['id_proprietaire'] . "'>";


  
            echo "<td>" . $ligne['nom_proprietaire'] . "</td>";
            echo "<td>" . $ligne['prenom_proprietaire'] . "</td>";
            echo "<td>" . $ligne['region_proprietaire'] . "</td>";
            echo "<td> <input type='submit' name='acceder' value='Acceder'> </td>";
            echo "<td> <input type='submit' name='supprimer' value='Supprimer'></td>";


            echo "</tr>";
            echo "</form>";

        }
        echo "</table>";

        if (!empty($_REQUEST['acceder'])) {

            $_SESSION['id_client'] = $_REQUEST['id_client'];
            echo "<meta http-equiv='Refresh' content='0.01; url=dossierClient.php'>";
        }


        if (!empty($_REQUEST['supprimer'])) {

            $_SESSION['id_client'] = $_REQUEST['id_client'];
            $query = "DELETE FROM `proprietaire` WHERE `id_proprietaire`like ('$_SESSION[id_client]');";
            $result = mysqli_query($conn, $query) or die("Echec de requête3");
            echo "<meta http-equiv='Refresh' content='0.01; url=recherche.php'>";
        }

        if (!empty($_REQUEST['ajouter'])) {
            echo "<meta http-equiv='Refresh' content='0.01; url=newClient.php'>";
        }


    }


    ?>

</body>

</html>