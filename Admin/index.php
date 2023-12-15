<!DOCTYPE html>
<html>
<head>
		<title>Art Jatie</title>
		<meta charset="utf-8">
		<meta name="viewport"content="width=device-widht, initial-scale=1">
		<link rel="stylesheet" href="../font/css/all.css">
        <script src="../jquery/jquery.mobile-1.4.5.min.js"></script>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../style.css">
	</head>
    <body>
    <div class="container cool">
			<h1>
				<span style="--i:1;">A</span>
				<span style="--i:2;">r</span>
				<span style="--i:3;">t</span>
				<span style="--i:4;margin-left: 5vw;margin-right: 5vw;"><i class="fas fa-heart"></i></span>
				<span style="--i:5;">J</span>
				<span style="--i:6;">a</span>
				<span style="--i:7;">t</span>
				<span style="--i:8;">i</span>
				<span style="--i:9;">e</span>
			</h1>
		</div>
        <div class="container admin">
            <div class="row">
                <h3><strong>Liste des ventes</strong>  <a href="insert.php" class="btn btn-success btn-lg"> <i class="fas fa-plus"></i>  Ajouter </a></h3>
            </div>
            <table class="table table-striped table-bordered" >
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prix (en Ariary)</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        require 'database.php';
                        $db = Database::connect();
                        $statement = $db->query('SELECT itrems.id, itrems.name, itrems.price, categories.name AS category
                                                    FROM itrems LEFT JOIN categories ON itrems.category = categories.id
                                                    ORDER BY itrems.id DESC');
                        while ($item = $statement->fetch()) {
                            echo '<tr>';
                            echo '<td>' . $item['name'] .'</td>';
                            echo '<td>' . $item['price'] .'Ar'. '</td>';
                            echo '<td>' . $item['category'] .'</td>';
                            echo '<td width="314">';
                            echo '<a class="btn btn-info" href="view.php?id=' . $item['id'] .' "><i class="fas fa-eye"></i> voir</a>';
                            echo ' ';
                            echo '<a class="btn btn-primary" href="update.php?id=' . $item['id'] . '"><i class="fas fa-pencil"></i> modifier</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id=' . $item['id']. '"><i class="fas fa-remove"></i> supprimer</a>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        Database::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>