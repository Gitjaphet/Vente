<!DOCTYPE html>
<html>
	<head>
		<title>Art Jatie</title>
		<meta charset="utf-8">
		<meta name="viewport"content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="font/css/all.css">
        <script src="jquery/jquery.mobile-1.4.5.min.js"></script>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="soum">
		<div class="cool">
		<div class="inscrit">
				<button onclick="window.location.href='#'" class="btn btn-primary lien">Se connecter</button>
			</div>
			<div class="inscrit">
				<button onclick="window.location.href='#'" class="btn btn-primary lien1">S'inscrire</button>
			</div>
			<h1>
				<span style="--i:1;">A</span>
				<span style="--i:2;">r</span>
				<span style="--i:3;">t</span>
				<span style="--i:4;margin-left: 5vw;margin-right: 5vw;"><i class="fas fa-heart"></i></span>
				<span style="--i:5;">J</span>
				<span style="--i:6;">A</span>
				<span style="--i:7;">T</span>
				<span style="--i:8;">I</span>
				<span style="--i:9;">E</span>
			</h1>
			<div class="shopping">
				<i class="fas fa-shopping-cart shop"></i>
				<span class="quantity">0</span>
			</div>
		</div>

		<div>
        <nav>
            <?php
            require 'Admin/database.php';
			$db = Database::connect();  
            $statement = $db->query("SELECT * FROM categories");
            $categories = $statement->fetchAll();

            foreach ($categories as $category) {
                $isActive = ($category['id'] == 1) ? 'active' : '';
                $tabIndex = $category['id'];
                echo "<a class='navi $isActive' data-toggle='tab' href='index{$tabIndex}.php' role='tab'>" . $category['name'] . "</a>";
            }
        ?>
        </nav>
    	</div>
		</div>
		<div class="boom">
		<div class="container site">
				<?php
				$db = Database::connect();
				
				// Récupérer les articles de la catégorie avec l'ID 10
				$categoryId = 13;
				$statement = $db->query("SELECT name, price, image FROM itrems WHERE category = $categoryId ORDER BY id DESC");
				$items = $statement->fetchAll(PDO::FETCH_ASSOC);

				// Enregistrer les articles au format JSON
				$donneesJSON = ['itrems' => $items];
				$jsonData = json_encode($donneesJSON);
				file_put_contents('itrems3.json', $jsonData);

				// Afficher chaque article dans une carte
				foreach ($items as $item) {
					?>
					<div class="card kou">
						<div class="imgbox">
							<img src="images/<?php echo $item['image']; ?>">
							<ul class="action">
								<li>
									<i class="fas fa-heart" aria-hidden="true"></i>
									<span>Tiako</span>
								</li>
								<li>
									<i class="fas fa-shopping-cart" aria-hidden="true"></i>
									<span>Hividy</span>
								</li>
								<li>
									<i class="fas fa-eye" aria-hidden="true"></i>
									<span>Hijery</span>
								</li>
							</ul>
						</div>
						<div class="content">
							<div class="ProductName">
								<h3><?php echo $item['name']; ?></h3>
							</div>
							<div class="price">
								<h2><?php echo $item['price']; ?>Ar</h2>
								<div class="rating">
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="fas fa-star grey"></i>
								</div>
							</div>
							<div class="container add">
								<h3 class="panier" data-price="<?php echo $item['price']; ?>">Ajouter au panier</h3>
							</div>
						</div>
					</div>
				<?php
				}

				Database::disconnect();
				?>
			</div>

			<div class="cardo">
				<h4><i class="fas fa-shopping-bag"></i>  Votre achat  <i class="fas fa-shopping-bag"></i></h4>
				<ul class="listCard"></ul>
				<div class="checkout">
					<div class="total">0 Ar</div>
					<div class="closeShopping">Ferner</div>
				</div>
			</div>
			<script>
				var items = <?php echo file_get_contents('itrems3.json'); ?>.itrems;
			</script>
			<script src="app.js"></script>
	</div>
	</body>
</html>