// resources/js/cart.js
// Este archivo se encarga de manejar la lógica del carrito de compras

// Escuchar el evento DOMContentLoaded para asegurarnos de que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", () => {

    const addButtons = document.querySelectorAll(".add-to-cart");
    const clearBtn = document.getElementById("clear-cart");
    const loadBtn = document.getElementById("load-cart");

    addButtons.forEach(button => {
        button.addEventListener("click", () => {

            const productId = parseInt(button.dataset.product);
            const stallId = parseInt(button.dataset.stall);
            const quantity = parseInt(button.dataset.qty);

            addToCart(productId, stallId, quantity);

        });
    });

    if (clearBtn) {
        clearBtn.addEventListener("click", clearCart);
    }

    if (loadBtn) {
        loadBtn.addEventListener("click", loadCartProducts);
    }

    loadCartProducts();
});

// Función para agregar un producto al carrito
function addToCart(productId, stallId, quantity) {

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    let existing = cart.find(item =>
        item.product_id === productId &&
        item.stall_id === stallId
    );

    if (existing) {
        existing.quantity += quantity;
    } else {
        cart.push({
            product_id: productId,
            stall_id: stallId,
            quantity: quantity
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
}

// Función para limpiar el carrito
function clearCart() {

    localStorage.removeItem("cart");

    document.getElementById("products-list").innerHTML = "";

}

// Función para cargar los productos del carrito desde el servidor
function loadCartProducts() {

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0) {
        document.getElementById("products-list").innerHTML = "<p>El carrito está vacío</p>";
        return;
    }

    document.getElementById("loading").style.display = "block";
    document.getElementById("products-list").innerHTML = "";

    // Enviar el carrito al servidor para obtener los detalles de los productos
    fetch("/customer/cart/products", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content")
        },
        body: JSON.stringify({ cart })
    })
        .then(res => res.json())
        .then(data => {

            document.getElementById("loading").style.display = "none";

            let html = "";

            data.forEach(stallGroup => {

                html += `<h3 class="font-semibold">${stallGroup.stall.name}</h3>`;
                html += `<ul class="list-disc ml-4">`;

                stallGroup.products.forEach(product => {

                    html += `
                        <li>
                        ${product.product.name}
                        - Unidad: ${product.product.unit}
                        - Precio: ${product.price_per_unit} €
                        - Cantidad: ${product.quantity}
                        - Stock: ${product.stock_quantity}
                        </li>
                    `;

                });

                html += "</ul>";
            });

            document.getElementById("products-list").innerHTML = html;

        })
        .catch(error => {

            document.getElementById("loading").style.display = "none";

            document.getElementById("products-list").innerHTML =
                "<p>Error al cargar productos</p>";

        });

}

// Función para enviar el carrito al servidor para su procesamiento
document.getElementById("send-cart").addEventListener("click", sendCart);
function sendCart() {

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0) {
        console.log("El carrito está vacío");
        return;
    }

    fetch("/customer/cart/store", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content")
        },
        body: JSON.stringify({
            cart: cart
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            clearCart();
            loadCartProducts();
        }
    })
    .catch(error => console.error(error));

}