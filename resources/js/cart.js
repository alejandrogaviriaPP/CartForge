document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            addToCart(id);
        });
    });

});


function showToast(message) {
    const toast = document.getElementById("toast");
    if (!toast) return;

    toast.innerText = message;

    // Reset classes
    toast.classList.remove("toast-out");
    toast.classList.add("toast-in");

    // Mostrar
    toast.style.opacity = "1";

    // Ocultar después
    setTimeout(() => {
        toast.classList.remove("toast-in");
        toast.classList.add("toast-out");
    }, 1000);
}



export function addToCart(id) {

    fetch(`/cart/add/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json",
            "Accept": "application/json"
        }
    })
    .then(async (res) => {

        if (res.status === 401) {

            // 🔥 GUARDAMOS EL PRODUCTO
            localStorage.setItem("pendingProduct", id);

            await Swal.fire({
                icon: 'info',
                title: 'Login required',
                text: 'You need to login to add items to your cart',
                confirmButtonText: 'Go to login'
            });

            window.location.href = "/login";
            return null;
        }

        return res.json();
    })
    .then(data => {

        if (!data) return;

        document.getElementById("cart-count").innerText = data.cartCount;

        showToast("Product added to cart 🛒");
        animateCartCount();
    });
}

// =========================
// ❌ REMOVE FROM CART (FIXED TOTAL BUG)
// =========================
export function removeFromCart(id) {

    fetch(`/cart/remove/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {

        document.getElementById("cart-count").innerText = data.cartCount;

        const item = document.getElementById(`item-${id}`);
        if (item) item.remove();

        showToast("Product removed from cart");

        // 🔥 FIX IMPORTANTE: recalcular total sin recargar página
        const totalEl = document.getElementById("cart-total");

        if (totalEl && data.total !== undefined) {
            totalEl.innerText = `Total: $${parseFloat(data.total).toFixed(2)}`;
        }
    });

}


// =========================
// 🔄 UPDATE QUANTITY
// =========================
export function updateQuantity(id, quantity) {

    fetch(`/cart/update/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ quantity })
    })
    .then(res => res.json())
    .then(data => {

        document.getElementById("cart-count").innerText = data.cartCount;

        // mejor que reload (opcional mejorar luego)
        location.reload();
    });

}


// =========================
// 💳 CHECKOUT
// =========================
export function checkout() {

    const cartCount = parseInt(document.getElementById("cart-count").innerText);

    if (cartCount === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Empty Cart',
            text: 'Your shopping cart is currently empty.',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to complete this purchase?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, checkout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) return;

        fetch('/cart/checkout', {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {

                Swal.fire({
                    icon: 'success',
                    title: 'Order Placed!',
                    text: 'Your order has been processed successfully.',
                    timer: 1000,
                    showConfirmButton: false
                });

                document.getElementById("cart-count").innerText = 0;

                const cartContainer = document.querySelector('.max-w-4xl'); 

                if (cartContainer) {
                    cartContainer.innerHTML = `
                        <div class="text-center py-10">
                            <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>
                            <p class="text-gray-500">Your cart is now empty. Thank you for your purchase!</p>
                            <a href="/products" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg">Back to Products</a>
                        </div>
                    `;
                }
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Something went wrong with the transaction.', 'error');
        });

    });
}

function animateCartCount() {
    console.log("ANIMATION TRIGGERED"); // 👈 prueba

    const count = document.getElementById("cart-count");

    if (!count) return;

    count.classList.add("scale-125");

    setTimeout(() => {
        count.classList.remove("scale-125");
        count.classList.add("scale-110");
    }, 110);

    setTimeout(() => {
        count.classList.remove("scale-110");
    }, 220);
}

function togglePassword() {
    const input = document.querySelector('input[name="password"]');
    input.type = input.type === "password" ? "text" : "password";
}