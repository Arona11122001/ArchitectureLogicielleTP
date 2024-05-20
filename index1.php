<!DOCTYPE html>
<html>
<head>
    <title>Affichage des articles</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="head">
          <h1>Liste des articles</h1>
    </div>
    <div>
        <a href="afficher_articles.php">Accueil</a>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "passer";
        $dbname = "mglsi_news";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection echoué: " . $conn->connect_error);
        }
        $sql = "SELECT id, libelle FROM Categorie";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<a href="afficher_articles.php?categorie='.$row["id"].'">'.$row["libelle"].'</a> ';
            }
        }
        $conn->close();
        ?>
    </div>
    <div class="articles-container">
        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection echoué: " . $conn->connect_error);
        }

        $where_condition = "";
        if(isset($_GET['categorie']) && !empty($_GET['categorie'])) {
            $categorie_id = $_GET['categorie'];
            $where_condition = "WHERE a.categorie = $categorie_id";
        }

        $sql = "SELECT a.titre, a.contenu, c.libelle AS categorie 
                FROM Article a
                INNER JOIN Categorie c ON a.categorie = c.id
                $where_condition";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="article">
                        <h2>'.$row["titre"].'</h2>
                        <p>'.$row["contenu"].'</p>
                        <p>Catégorie: '.$row["categorie"].'</p>
                      </div>';
            }
        } else {
            echo "Zéro résultats";
        }
        $conn->close();
        ?>
    </div>  
</body>
</html>
