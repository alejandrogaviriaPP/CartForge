import { addToCart, removeFromCart, updateQuantity, checkout } from './cart';

window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
window.checkout = checkout;

document.addEventListener('DOMContentLoaded', () => {

    // =========================
    // PENDING CART
    // =========================

    const pending = localStorage.getItem("pendingProduct");

    if (pending && window.isLoggedIn) {

        localStorage.removeItem("pendingProduct");

        setTimeout(() => {
            addToCart(pending);
        }, 300);

    }
});
  const searchBtn = document.getElementById("search-btn");
const overlay = document.getElementById("search-overlay");
const closeBtn = document.getElementById("close-search");
const searchContent = document.getElementById("search-content");

if (searchBtn && overlay && closeBtn && searchContent) {

    let closeTimeout;

    // OPEN SEARCH
    function openSearch() {

        clearTimeout(closeTimeout);

        overlay.classList.remove(
            "opacity-0",
            "pointer-events-none"
        );

        setTimeout(() => {

            searchContent.classList.remove(
                "opacity-0",
                "-translate-y-20"
            );

        }, 30);

    }

    // CLOSE SEARCH
    function closeSearch() {

        searchContent.classList.add(
            "opacity-0",
            "-translate-y-20"
        );

        setTimeout(() => {

            overlay.classList.add(
                "opacity-0",
                "pointer-events-none"
            );

        }, 120);

    }

    // START CLOSE TIMER
    function startCloseTimer() {

        clearTimeout(closeTimeout);

        closeTimeout = setTimeout(() => {

            closeSearch();

        }, 120);

    }

    // OPEN
    searchBtn.addEventListener("mouseenter", openSearch);

    // KEEP OPEN
    searchContent.addEventListener("mouseenter", () => {

        clearTimeout(closeTimeout);

    });

    searchBtn.addEventListener("mouseenter", () => {

        clearTimeout(closeTimeout);

    });

    // CLOSE WHEN LEAVING CONTENT
    searchContent.addEventListener("mouseleave", startCloseTimer);

    // CLOSE WHEN LEAVING BUTTON
    searchBtn.addEventListener("mouseleave", startCloseTimer);

    // CLOSE BUTTON
    closeBtn.addEventListener("click", closeSearch);

    // ESC KEY
    document.addEventListener("keydown", (e) => {

        if (e.key === "Escape") {
            closeSearch();
        }

    });

    // CLICK OUTSIDE
    overlay.addEventListener("click", (e) => {

        if (e.target === overlay) {
            closeSearch();
        }

    });

}