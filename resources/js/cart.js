/* global Swal */

// Translate helper: reads strings injected by the layout (window.i18n).
const t = (key, fallback = "") => (window.i18n && window.i18n[key]) || fallback;

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".add-to-cart-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            addToCart(id);
        });
    });
});

function showToast(message) {
    const toast = document.getElementById("toast");
    if (!toast) return;

    toast.innerText = message;
    toast.classList.remove("toast-out");
    toast.classList.add("toast-in");
    toast.style.opacity = "1";

    setTimeout(() => {
        toast.classList.remove("toast-in");
        toast.classList.add("toast-out");
    }, 1000);
}

export function addToCart(id) {
    fetch(`/cart/add/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    })
        .then(async (res) => {
            if (res.status === 401) {
                localStorage.setItem("pendingProduct", id);

                await Swal.fire({
                    icon: "info",
                    title: t("login_required_title", "Login required"),
                    text: t("login_required_text", "You need to login to add items to your cart"),
                    confirmButtonText: t("go_to_login", "Go to login"),
                });

                window.location.href = "/login";
                return null;
            }

            return res.json();
        })
        .then((data) => {
            if (!data) return;

            document.getElementById("cart-count").innerText = data.cartCount;

            showToast(t("added", "Product added to cart"));
            animateCartCount();
        });
}

export function removeFromCart(id) {
    fetch(`/cart/remove/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            "Content-Type": "application/json",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            document.getElementById("cart-count").innerText = data.cartCount;

            const item = document.getElementById(`item-${id}`);
            if (item) item.remove();

            showToast(t("removed", "Product removed from cart"));

            const totalEl = document.getElementById("cart-total");

            if (totalEl && data.total !== undefined) {
                totalEl.innerText = `${t("total_label", "Total:")} $${parseFloat(data.total).toFixed(2)}`;
            }
        });
}

export function updateQuantity(id, quantity) {
    fetch(`/cart/update/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ quantity }),
    })
        .then((res) => res.json())
        .then((data) => {
            document.getElementById("cart-count").innerText = data.cartCount;

            location.reload();
        });
}

export function checkout() {
    const cartCount = parseInt(document.getElementById("cart-count").innerText);

    if (cartCount === 0) {
        Swal.fire({
            icon: "info",
            title: t("empty_cart_title", "Empty Cart"),
            text: t("empty_cart_text", "Your shopping cart is currently empty."),
            confirmButtonColor: "#3085d6",
        });
        return;
    }

    Swal.fire({
        title: t("checkout_confirm_title", "Are you sure?"),
        text: t("checkout_confirm_text", "Do you want to complete this purchase?"),
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#16a34a",
        cancelButtonColor: "#d33",
        confirmButtonText: t("yes_checkout", "Yes, checkout!"),
        cancelButtonText: t("cancel", "Cancel"),
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch("/cart/checkout", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: t("order_placed_title", "Order Placed!"),
                        text: t("order_placed_text", "Your order has been processed successfully."),
                        timer: 1000,
                        showConfirmButton: false,
                    });

                    document.getElementById("cart-count").innerText = 0;

                    const cartContainer = document.querySelector(".max-w-4xl");

                    if (cartContainer) {
                        cartContainer.innerHTML = `
                        <div class="text-center py-10">
                            <h1 class="text-3xl font-bold mb-6">${t("shopping_cart", "Shopping Cart")}</h1>
                            <p class="text-gray-500">${t("cart_empty_thanks", "Your cart is now empty. Thank you for your purchase!")}</p>
                            <a href="/products" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg">${t("back_to_products", "Back to Products")}</a>
                        </div>
                    `;
                    }
                }
            })
            .catch(() => {
                Swal.fire(
                    t("error_title", "Error"),
                    t("error_text", "Something went wrong with the transaction."),
                    "error",
                );
            });
    });
}

function animateCartCount() {
    console.log("ANIMATION TRIGGERED");

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
