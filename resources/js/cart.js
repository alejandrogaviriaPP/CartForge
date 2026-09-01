/* global Swal */

const t = (key, fallback = "") => (window.i18n && window.i18n[key]) || fallback;

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".add-to-cart-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            addToCart(id);
        });
    });
});

export function showToast(message) {
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
                    text: t(
                        "login_required_text",
                        "You need to login to add items to your cart",
                    ),
                    confirmButtonText: t("go_to_login", "Go to login"),
                });

                window.location.href = "/login";
                return null;
            }

            if (!res.ok) {
                throw new Error(`HTTP ${res.status}`);
            }

            return res.json();
        })
        .then((data) => {
            if (!data) return;

            if (data.success === false) {
                showToast(data.message || t("error_text", "Something went wrong"));
                return;
            }

            const countEl = document.getElementById("cart-count");

            if (countEl && data.cartCount !== undefined) {
                countEl.innerText = data.cartCount;
            }

            showToast(t("added", "Product added to cart"));
            animateCartCount();
        })
        .catch(() => {
            showToast(t("error_text", "Something went wrong"));
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

const paymentOptions = [
    {
        value: "card",
        icon: `<svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>`,
        label: t("credit_debit_card", "Credit / Debit Card"),
    },
    {
        value: "paypal",
        icon: `<svg class="w-7 h-7 text-[#003087]" fill="currentColor" viewBox="0 0 24 24"><path d="M7.076 21.337H2.47a.641.641 0 01-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 00-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 00-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 00.554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 01.923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.971z"/></svg>`,
        label: "PayPal",
    },
    {
        value: "nequi",
        icon: `<svg class="w-7 h-7 text-[#362044]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>`,
        label: "Nequi",
    },
];

function selectPaymentMethod() {
    const optionsHtml = paymentOptions
        .map(
            (option) => `
        <label class="relative flex flex-col items-center gap-2 sm:gap-3 p-4 sm:p-5 bg-white border border-gray-200 rounded-2xl cursor-pointer transition-all duration-200 ease-out hover:border-gray-300 hover:shadow-lg hover:-translate-y-0.5 has-[:checked]:border-green-600 has-[:checked]:bg-green-50/70 has-[:checked]:shadow-lg has-[:checked]:ring-2 has-[:checked]:ring-green-600/30 has-[:checked]:scale-[1.02] active:scale-95">
            <input type="radio" name="swal_payment_method" value="${option.value}" class="sr-only peer">
            <span class="absolute top-2 right-2 w-5 h-5 rounded-full bg-green-600 text-white items-center justify-center hidden has-[:checked]:flex">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </span>
            ${option.icon}
            <span class="text-xs sm:text-sm font-medium text-center text-gray-800">${option.label}</span>
        </label>
    `,
        )
        .join("");

    return Swal.fire({
        title: t("payment_method", "Payment method"),
        html: `<div class="grid grid-cols-3 gap-2 sm:gap-4">${optionsHtml}</div>`,
        showCancelButton: true,
        confirmButtonColor: "#16a34a",
        cancelButtonColor: "#d33",
        confirmButtonText: t("confirm_checkout", "Confirm"),
        cancelButtonText: t("cancel", "Cancel"),
        focusConfirm: false,
        customClass: {
            popup: "payment-popup",
        },
        preConfirm: () => {
            const method = Swal.getPopup().querySelector(
                'input[name="swal_payment_method"]:checked',
            )?.value;

            if (!method) {
                Swal.showValidationMessage(
                    t(
                        "select_payment_method",
                        "Please select a payment method.",
                    ),
                );
                return false;
            }

            return method;
        },
    });
}

const paymentFields = {
    card: `
        <div class="text-left space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">${t("card_number", "Card number")}</label>
                <input id="swal-card-number" inputmode="numeric" autocomplete="cc-number" maxlength="19" placeholder="4242 4242 4242 4242"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">${t("card_holder", "Cardholder name")}</label>
                <input id="swal-card-holder" autocomplete="cc-name" placeholder="${t("card_holder_placeholder", "Name as it appears on the card")}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">${t("card_expiry", "Expiry (MM/YY)")}</label>
                    <input id="swal-card-expiry" inputmode="numeric" autocomplete="cc-exp" maxlength="5" placeholder="12/28"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">${t("card_cvv", "CVV")}</label>
                    <input id="swal-card-cvv" inputmode="numeric" autocomplete="cc-csc" maxlength="4" placeholder="123"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>
        </div>
    `,
    paypal: `
        <div class="text-left">
            <label class="block text-sm font-medium text-gray-700 mb-1">${t("paypal_email", "PayPal email")}</label>
            <input id="swal-paypal-email" type="email" autocomplete="email" placeholder="you@example.com"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            <p class="text-xs text-gray-500 mt-2">${t("paypal_note", "You will receive a payment request at this email.")}</p>
        </div>
    `,
    nequi: `
        <div class="text-left">
            <label class="block text-sm font-medium text-gray-700 mb-1">${t("nequi_phone", "Nequi phone number")}</label>
            <input id="swal-nequi-phone" inputmode="numeric" maxlength="10" placeholder="3001234567"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            <p class="text-xs text-gray-500 mt-2">${t("nequi_note", "We will send a payment request to this number.")}</p>
        </div>
    `,
};

function digitsOnly(value) {
    return value.replace(/\D/g, "");
}

function formatCardNumber(value) {
    return digitsOnly(value)
        .slice(0, 16)
        .replace(/(\d{4})(?=\d)/g, "$1 ");
}

function formatExpiry(value) {
    const digits = digitsOnly(value).slice(0, 4);

    if (digits.length <= 2) return digits;

    return `${digits.slice(0, 2)}/${digits.slice(2)}`;
}

function validatePaymentDetails(method) {
    const errors = [];

    if (method === "card") {
        const number = digitsOnly(
            document.getElementById("swal-card-number").value,
        );
        const holder = document.getElementById("swal-card-holder").value.trim();
        const expiry = document.getElementById("swal-card-expiry").value;
        const cvv = digitsOnly(document.getElementById("swal-card-cvv").value);

        if (number.length !== 16) {
            errors.push(
                t(
                    "invalid_card_number",
                    "The card number must have 16 digits.",
                ),
            );
        }

        if (holder.length < 3) {
            errors.push(
                t("invalid_card_holder", "Please enter the cardholder name."),
            );
        }

        const expiryMatch = expiry.match(/^(0[1-9]|1[0-2])\/(\d{2})$/);

        if (!expiryMatch) {
            errors.push(
                t("invalid_expiry", "The expiry date must be in MM/YY format."),
            );
        } else {
            const now = new Date();
            const year = 2000 + parseInt(expiryMatch[2]);
            const month = parseInt(expiryMatch[1]);

            if (
                year < now.getFullYear() ||
                (year === now.getFullYear() && month < now.getMonth() + 1)
            ) {
                errors.push(t("expired_card", "The card has expired."));
            }
        }

        if (cvv.length < 3) {
            errors.push(t("invalid_cvv", "The CVV must have 3 or 4 digits."));
        }

        return {
            errors,
            details: {
                card_number: number,
                card_holder: holder,
                card_expiry: expiry,
                card_cvv: cvv,
            },
        };
    }

    if (method === "paypal") {
        const email = document.getElementById("swal-paypal-email").value.trim();

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.push(
                t("invalid_email", "Please enter a valid email address."),
            );
        }

        return { errors, details: { paypal_email: email } };
    }

    if (method === "nequi") {
        const phone = digitsOnly(
            document.getElementById("swal-nequi-phone").value,
        );

        if (phone.length !== 10) {
            errors.push(
                t(
                    "invalid_phone",
                    "Please enter a valid 10-digit phone number.",
                ),
            );
        }

        return { errors, details: { nequi_phone: phone } };
    }

    return { errors, details: {} };
}

function bindPaymentFieldFormatting(method) {
    if (method === "card") {
        const numberInput = document.getElementById("swal-card-number");
        const expiryInput = document.getElementById("swal-card-expiry");
        const cvvInput = document.getElementById("swal-card-cvv");

        numberInput.addEventListener("input", () => {
            numberInput.value = formatCardNumber(numberInput.value);
        });
        expiryInput.addEventListener("input", () => {
            expiryInput.value = formatExpiry(expiryInput.value);
        });
        cvvInput.addEventListener("input", () => {
            cvvInput.value = digitsOnly(cvvInput.value).slice(0, 4);
        });
    }

    if (method === "nequi") {
        const phoneInput = document.getElementById("swal-nequi-phone");

        phoneInput.addEventListener("input", () => {
            phoneInput.value = digitsOnly(phoneInput.value).slice(0, 10);
        });
    }
}

export async function checkout() {
    const cartCount = parseInt(document.getElementById("cart-count").innerText);

    if (cartCount === 0) {
        Swal.fire({
            icon: "info",
            title: t("empty_cart_title", "Empty Cart"),
            text: t(
                "empty_cart_text",
                "Your shopping cart is currently empty.",
            ),
            confirmButtonColor: "#16a34a",
        });
        return;
    }

    const selected = await selectPaymentMethod();

    if (!selected.isConfirmed) return;

    const paymentMethod = selected.value;

    Swal.fire({
        title: t("payment_details_title", "Payment details"),
        html: paymentFields[paymentMethod] || "",
        showCancelButton: true,
        confirmButtonColor: "#16a34a",
        cancelButtonColor: "#d33",
        confirmButtonText: t("pay_now", "Pay now"),
        cancelButtonText: t("cancel", "Cancel"),
        focusConfirm: false,
        didOpen: () => bindPaymentFieldFormatting(paymentMethod),
        preConfirm: () => {
            const { errors, details } = validatePaymentDetails(paymentMethod);

            if (errors.length > 0) {
                Swal.showValidationMessage(errors.join(" "));
                return false;
            }

            return details;
        },
    }).then((result) => {
        if (!result.isConfirmed) return;

        Swal.fire({
            title: t("processing_payment", "Processing payment..."),
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading(),
        });

        fetch("/cart/checkout", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({
                payment_method: paymentMethod,
                payment_details: result.value,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: data.payment_url ? "info" : "success",
                        title: t("order_placed_title", "Order Placed!"),
                        text:
                            data.deliveryText ||
                            t(
                                "order_placed_text",
                                "Your order has been processed successfully.",
                            ),
                        footer: data.payment_url
                            ? `<a href="${data.payment_url}" target="_blank" rel="noopener" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">${t("pay_now_redirect", "Go to pay")}</a>`
                            : undefined,
                        timer: data.payment_url ? 0 : 4000,
                        showConfirmButton: !data.payment_url,
                    });

                    document.getElementById("cart-count").innerText = 0;

                    const cartContainer = document.querySelector(".max-w-4xl");

                    if (cartContainer) {
                        cartContainer.innerHTML = `
                        <div class="text-center py-10">
                            <h1 class="text-3xl font-bold mb-6">${t("shopping_cart", "Shopping Cart")}</h1>
                            <p class="text-gray-500">${t("cart_empty_thanks", "Your cart is now empty. Thank you for your purchase!")}</p>
                            <a href="/products" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">${t("back_to_products", "Back to Products")}</a>
                        </div>
                    `;
                    }
                } else if (data.message) {
                    Swal.fire(t("error_title", "Error"), data.message, "error");
                }
            })
            .catch(() => {
                Swal.fire(
                    t("error_title", "Error"),
                    t(
                        "error_text",
                        "Something went wrong with the transaction.",
                    ),
                    "error",
                );
            });
    });
}

function animateCartCount() {
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
