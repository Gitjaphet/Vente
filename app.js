document.addEventListener('DOMContentLoaded', function () {
    var openShopping = document.querySelector('.shopping');
    var closeShopping = document.querySelector('.closeShopping');
    var body = document.querySelector('body');
    var totalElement = document.querySelector('.total');
    var quantityElement = document.querySelector('.quantity');
    var listCards = document.querySelector('.listCard');

    
    var cart = [];

    // Fonction pour mettre à jour l'affichage du panier
    function updateCart() {
        var totalPrice = cart.reduce(function (total, item) {
            return total + item.price;
        }, 0);

        totalElement.textContent = 'Total :' + ' ' + totalPrice + 'Ar';
        quantityElement.textContent = cart.length;

        // Mettre à jour la liste des cartes dans le panier
        listCards.innerHTML = '';
        cart.forEach(function (item, index) {
            var listItem = document.createElement('li');

            // Créer une div pour l'image
            var imageDiv = document.createElement('div');
            imageDiv.classList.add('cart-image');
            var image = document.createElement('img');
            image.src = 'images/' + item.image; // Assurez-vous que votre objet item a une propriété 'image'
            image.alt = 'Chargement...';
            imageDiv.appendChild(image);
            listItem.appendChild(imageDiv);

            // Créer une div pour le nom, le prix et le bouton de suppression
            var contentDiv = document.createElement('div');
            contentDiv.classList.add('cart-item-content');

            // Ajouter le nom
            var itemName = document.createElement('span');
            itemName.textContent = item.name;
            contentDiv.appendChild(itemName);

            // Ajouter le prix
            var itemPrice = document.createElement('span');
            itemPrice.textContent = 'Prix: ' + ' ' + item.price + 'Ar';
            contentDiv.appendChild(itemPrice);

            // Ajouter le bouton de suppression
            var deleteButton = document.createElement('button');
            deleteButton.innerHTML = '<i class="fas fa-trash"></i>'; // Utilisez l'icône trash
            deleteButton.classList.add('delete-button');
            deleteButton.addEventListener('click', function () {
                removeFromCart(index);
            });
            contentDiv.appendChild(deleteButton);

            listItem.appendChild(contentDiv);

            listCards.appendChild(listItem);
        });


        // Ajouter le formulaire d'achat
            var checkoutForm = `
            <div class="form-actions houm">
                <button type="submit" class="btn btn-success"><i class="fas fa-coins"></i> Acheter </button>
            </div>
        `;

        listCards.insertAdjacentHTML('beforeend', checkoutForm);

// Sauvegarder le panier dans le stockage local

        // Sauvegarder le panier dans le stockage local
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    // Fonction pour charger le panier depuis le stockage local
    function loadCartFromLocalStorage() {
        var storedCart = localStorage.getItem('cart');
        if (storedCart) {
            cart = JSON.parse(storedCart);
            updateCart();
        }
    }

    // Fonction pour ajouter un article au panier
    function addToCart(item) {
        cart.push({
            name: item.name,
            price: item.price
        });

        updateCart();
    }

    // Fonction pour supprimer un article du panier
    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCart();
    }

    // Écouter les clics sur les boutons "Ajouter au panier"
    var addToCartButtons = document.querySelectorAll('.panier');
    addToCartButtons.forEach(function (button, index) {
        button.addEventListener('click', function () {
            // Lorsqu'un bouton est cliqué, ajoutez l'article correspondant au panier
            addToCart(items[index]);
        });
    });

    // Écouter les événements d'ouverture/fermeture du panier
    openShopping.addEventListener('click', function () {
        body.classList.add('active');
    });

    closeShopping.addEventListener('click', function () {
        body.classList.remove('active');
    });

    // Charger le panier depuis le stockage local au chargement de la page
    loadCartFromLocalStorage();

    // Initialiser le panier
    updateCart();
});
