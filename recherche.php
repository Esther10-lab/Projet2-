<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des candidats</title>
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .form-row select {
            width: 100px;
            padding: 8px;
            top: 100px;
        }

        .form-container {
            width: 60%;
            margin: 20px auto;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <fieldset>
                <legend><b>Liste des joueurs d'un club pour une année donnée</b></legend>
                
                <div class="form-row">
                    <label for="club">Club:</label>
                    <select name="club" id="club">
                        <?php
                        try {
                            $db = new PDO("mysql:host=localhost;dbname=lfp-fbf", "root", "");
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $db->prepare("SELECT DISTINCT club FROM inscription");
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = isset($_POST['club']) && $_POST['club'] == $row['club'] ? 'selected' : '';
                                echo "<option value='". $row["club"]. "' $selected>". $row["club"]. "</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Échec de la connexion : " . $e->getMessage();
                            die();
                        }
                        ?>
                    </select>

                    <label for="annee" style="margin-left: 20px;">Année:</label>
                    <select id="annee" name="annee">
                        <?php
                        try {
                            $db = new PDO("mysql:host=localhost;dbname=lfp-fbf", "root", "");
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $db->prepare("SELECT DISTINCT annee FROM inscription");
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = isset($_POST['annee']) && $_POST['annee'] == $row['annee'] ? 'selected' : '';
                                echo "<option value='". $row["annee"]. "' $selected>". $row["annee"]. "</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Échec de la connexion : " . $e->getMessage();
                            die();
                        }
                        ?>
                    </select>
                    <h3>LISTE DES JOUEURS</h3>
<table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Categorie</th>

                <?php
        // Vérifier si le formulaire a été soumis
        if (isset($_POST["rechercher"])) {
            $club = $_POST["club"];
            $annee = $_POST["annee"];

            try {
            
                $db = new PDO("mysql:host=localhost;dbname=lfp-fbf", "root", "");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                 
                $stmt = $db->prepare("
                    SELECT joueur.nom, joueur.prenom, inscription.categorie
                    FROM joueur
                    JOIN inscription ON joueur.idjoueur = inscription.idjoueur
                    WHERE inscription.club = :club
                    AND inscription.annee = :annee
                ");
                $stmt->bindParam(':club', $club);
                $stmt->bindParam(':annee', $annee);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupération de tous les résultats

                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>". $row['nom']. "</td>";
                    echo "<td>". $row['prenom']. "</td>";
                    echo "<td>". $row['categorie']. "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";

            } catch (PDOException $e) {
                echo "Échec de la connexion : " . $e->getMessage();
                die();
            }
        }
        ?>
        
            </tr>
        </thead> 
        <tbody>
                    
        </table>
        </form>
        <td><br><br>
        <input type="submit" name="rechercher" value="Rechercher">
        </td>
        </tr>
                    
                </div>
            </fieldset>
        </form>
        </div>
</body>
</html>
        