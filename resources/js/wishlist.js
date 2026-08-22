import { showToast } from "./cart";

const t = (key, fallback = "") => (window.i18n && window.i18n[key]) || fallback;

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".wishlist-btn").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!window.isLoggedIn) {
                showToast(t("wishlist_login_required", "Log in to save favorites"));
                return;
            }

            try {
                const res = await fetch(`/wishlist/${btn.dataset.id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                });

                const data = await res.json();

                if (!data.success) return;

                const svg = btn.querySelector("svg");
                const active = ["text-red-500", "fill-red-500"];

                if (data.inWishlist) {
                    svg.classList.add(...active);
                    svg.classList.remove("text-gray-500");
                    showToast(t("wishlist_added", "Added to your wishlist"));
                } else {
                    svg.classList.remove(...active);
                    svg.classList.add("text-gray-500");
                    showToast(t("wishlist_removed", "Removed from your wishlist"));

                    const card = btn.closest(".wishlist-card");
                    if (card) card.remove();
                }

                const count = document.getElementById("wishlist-count");

                if (count) {
                    const current = parseInt(count.innerText) || 0;
                    count.innerText = data.inWishlist
                        ? current + 1
                        : Math.max(0, current - 1);
                }
            } catch {
                showToast(t("wishlist_error", "Could not update your wishlist"));
            }
        });
    });
});
