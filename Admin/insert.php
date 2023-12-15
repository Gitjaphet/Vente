<?php
    require 'database.php';
    $nameError = $priceError = $categoryError = $imageError = $name = $price = $category = $image = "";
    if(!empty($_POST))
    {
        $name             = checkInput($_POST['name']);
        $price            = checkInput($_POST['price']);
        $category         = checkInput($_POST['category']);
        $image            = checkInput($_FILES['image']['name']);
        $imagePath        = '../images/'. basename($image);
        $imageExtension   = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess        = true;
        $isUploadSuccess  = false;

        if(empty($name))
        {
            $nameError    = "Ce champ ne peut pas être vide";
            $isSuccess    = false;
        }
        if(empty($price))
        {
            $priceError    = "Ce champ ne peut pas être vide";
            $isSuccess     = false;
        }
        if(empty($category))
        {
            $categoryError    = "Ce champ ne peut pas être vide";
            $isSuccess        = false;
        }
        if(empty($image))
        {
            $imageError    = "Ce champ ne peut pas être vide";
            $isSuccess     = false;
        }
        else
        {
            $isUploadSuccess    = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
            {
                $imageError      = "Les fichiers autorisés sont: .jpg, .jpeg, .png, .gif ";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath))
            {
                $imageError      = "L'image que vous avez choisit existe déjà";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 6000000) 
            {
                $imageError      = "Le fichier ne doit pas depasser 6Mo";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess)
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
                {
                    $imageError  = "Il y a eu un erreur lors du telechargement";
                    $isUploadSuccess = false;
                }
            }
        }
        if($isSuccess && $isUploadSuccess)
        {
            $db          = Database::connect();
            $statement   = $db -> prepare("INSERT INTO itrems (name, price, category, image) values (?, ?, ?, ?)");
            $statement -> execute(array($name, $price, $category, $image));
            Database::disconnect();
            header("location: index.php");
        }
    }


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
                    <h3><strong>Ajouter un Produit</strong></h3>
                    <br>
                    <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom: </label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                            <span class="help-inline"><?php echo $nameError; ?></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="price">Prix: (en Ariary) </label>
                            <input type="number" step="100" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                            <span class="help-inline"><?php echo $priceError; ?></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="category">categories: </label>
                            <select class="form-control" name="category" id="category">
                                <?php
                                    $db = Database::connect();
                                    foreach($db -> query('SELECT * FROM categories') as $row)
                                    {
                                        echo '<option value="' .$row['id']. '">' .$row['name']. '</option>';
                                    }
                                    Database::disconnect();
                                ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError; ?></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="image">Selectionner une image: </label>
                            <input type="file" id="image" name="image">
                            <br>
                            <span class="help-inline"><?php echo $imageError; ?></span>
                        </div>
                        <br>
                        <br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><i class="fas fa-pencil"></i> Ajouter</button>
                            <a class="btn btn-primary" href="index.php"><i class="fas fa-arrow-left" ></i> Retour</a>
                        </div>
                    </form>
                        
            </div>
                
        </div>

    </body>
</html>


