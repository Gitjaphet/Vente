<?php
    require 'database.php';
    if(!empty($_GET['id']))
    {
        $id   = checkInput($_GET['id']);
    }
    if(!empty($_POST))
    {
        $id   = checkInput($_POST['id']);
        $db   = Database::connect();
        $statement = $db -> prepare("DELETE FROM itrems WHERE id = ?");
        $statement -> execute(array($id));
        Database::disconnect();
        header('location: index.php');
    }


    $db = Database::connect();
    $statement = $db -> prepare('SELECT itrems.id, itrems.name, itrems.image, itrems.price, categories.name AS category 
                                FROM itrems LEFT JOIN categories ON itrems.category = categories.id WHERE itrems.id = ?');


    $statement -> execute(array($id));
    $item = $statement -> fetch();
    Database::disconnect();

    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>

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



        <div class="container admin2">
            <div class="row">
                <div class="col-sm-6">
                    <h3><strong>Supprimer un Produit</strong></h3>
                    <br>
                    <form>
                        <div class="form-group">
                            <label>Nom: </label><?php echo ' ' . $item['name']; ?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Prix: </label><?php echo ' ' . $item['price'] . 'Ar'; ?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>categories: </label><?php echo ' ' . $item['category']; ?>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Image: </label><?php echo ' ' . $item['image']; ?>
                        </div>
                    </form>
                        </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="imgbox">
                                <img src="<?php echo '../images/' . $item['image']; ?>">
                            </div>
                            <div class="content">
                                <div class="ProductName">
                                <h3><?php echo $item['name']; ?></h3>
                                </div>
                                <div class="price">
                                    <h2><?php echo $item['price'] . 'Ar' ; ?></h2>
                                    <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star grey"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="form" role="form" action="delete.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-warning">Oui</button>
                            <a class="btn btn-default" href="index.php">Non</a>
                        </div>
                    </form>
            </div>
        </div>
        <div class="look">

        </div>


    </body>
</html>


