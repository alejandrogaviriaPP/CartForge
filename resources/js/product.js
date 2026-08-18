import { showToast } from "./cart";

const t = (key, fallback = "") => (window.i18n && window.i18n[key]) || fallback;

document.addEventListener("DOMContentLoaded", () => {
    initGallery();
    initRating();
    initRatingModal();
});

function initGallery() {
    const mainImage = document.getElementById("main-image");
    const thumbs = document.querySelectorAll(".gallery-thumb");

    if (!mainImage || thumbs.length === 0) return;

    thumbs.forEach((thumb) => {
        thumb.addEventListener("click", () => {
            const img = thumb.dataset.image;
            if (!img) return;

            mainImage.src = img;
            mainImage.style.opacity = "0";

            setTimeout(() => {
                mainImage.style.opacity = "1";
            }, 150);

            thumbs.forEach((t) => {
                t.classList.remove("border-blue-600");
                t.classList.add("border-gray-200", "hover:border-gray-400");
            });

            thumb.classList.remove("border-gray-200", "hover:border-gray-400");
            thumb.classList.add("border-blue-600");
        });
    });
}

function initRating() {
    const container = document.getElementById("star-rating");
    if (!container) return;

    const buttons = container.querySelectorAll(".rating-star");

    function paint(stars) {
        buttons.forEach((btn, index) => {
            const svg = btn.querySelector("svg");
            if (!svg) return;

            if (index < stars) {
                svg.classList.add("text-yellow-400", "fill-yellow-400");
                svg.classList.remove("text-gray-300", "fill-gray-300");
            } else {
                svg.classList.remove("text-yellow-400", "fill-yellow-400");
                svg.classList.add("text-gray-300", "fill-gray-300");
            }
        });
    }

    function reset() {
        const current = parseInt(container.dataset.userRating || "0", 10);
        paint(current);
    }

    buttons.forEach((btn, index) => {
        btn.addEventListener("mouseenter", () => paint(index + 1));
        btn.addEventListener("mouseleave", reset);

        btn.addEventListener("click", () => {
            document.dispatchEvent(
                new CustomEvent("open-rating-modal", {
                    detail: { rating: parseInt(btn.dataset.value, 10) },
                }),
            );
        });
    });

    reset();
}

function initRatingModal() {
    const modal = document.getElementById("rating-modal");
    const openBtn = document.getElementById("open-rating-modal");
    const closeBtns = document.querySelectorAll("[data-close-rating-modal]");
    const submitBtn = document.getElementById("submit-rating");
    const commentInput = document.getElementById("rating-comment");

    if (!modal || !openBtn) return;

    const container = document.getElementById("modal-star-rating");
    const productId = container.dataset.productId;
    const buttons = container.querySelectorAll(".modal-rating-star");
    let selectedRating = parseInt(container.dataset.userRating || "0", 10);

    function paint(stars) {
        buttons.forEach((btn, index) => {
            const svg = btn.querySelector("svg");
            if (!svg) return;

            if (index < stars) {
                svg.classList.add("text-yellow-400", "fill-yellow-400");
                svg.classList.remove("text-gray-300", "fill-gray-300");
            } else {
                svg.classList.remove("text-yellow-400", "fill-yellow-400");
                svg.classList.add("text-gray-300", "fill-gray-300");
            }
        });
    }

    function reset() {
        paint(selectedRating);
    }

    function openModal() {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        document.body.style.overflow = "hidden";
        reset();
    }

    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        document.body.style.overflow = "";
    }

    openBtn.addEventListener("click", openModal);

    document.addEventListener("open-rating-modal", (e) => {
        if (e.detail && e.detail.rating) {
            selectedRating = e.detail.rating;
        }
        openModal();
    });

    closeBtns.forEach((btn) => {
        btn.addEventListener("click", closeModal);
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });

    buttons.forEach((btn, index) => {
        btn.addEventListener("mouseenter", () => paint(index + 1));
        btn.addEventListener("mouseleave", reset);

        btn.addEventListener("click", () => {
            selectedRating = parseInt(btn.dataset.value, 10);
            paint(selectedRating);
        });
    });

    submitBtn.addEventListener("click", async () => {
        if (selectedRating === 0) {
            showToast(t("select_rating", "Please select a rating"));
            return;
        }

        const comment = commentInput ? commentInput.value.trim() : "";

        try {
            const response = await fetch(`/products/${productId}/rate`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ rating: selectedRating, comment }),
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();

            container.dataset.userRating = String(data.user_rating);
            selectedRating = data.user_rating;

            const avgEl = document.getElementById("rating-average");
            const countEl = document.getElementById("rating-count");
            const reviewsEl = document.getElementById("reviews-count");

            if (avgEl) {
                avgEl.innerText = data.average.toFixed(1);
            }

            if (countEl) {
                const word =
                    data.count === 1
                        ? t("rating", "rating")
                        : t("ratings", "ratings");
                countEl.innerText = `(${data.count} ${word})`;
            }

            if (reviewsEl) {
                reviewsEl.innerText = data.count;
            }

            const inlineContainer = document.getElementById("star-rating");
            if (inlineContainer) {
                inlineContainer.dataset.userRating = String(data.user_rating);
                const inlineButtons =
                    inlineContainer.querySelectorAll(".rating-star");
                inlineButtons.forEach((btn, index) => {
                    const svg = btn.querySelector("svg");
                    if (!svg) return;
                    if (index < data.user_rating) {
                        svg.classList.add("text-yellow-400", "fill-yellow-400");
                        svg.classList.remove("text-gray-300", "fill-gray-300");
                    } else {
                        svg.classList.remove(
                            "text-yellow-400",
                            "fill-yellow-400",
                        );
                        svg.classList.add("text-gray-300", "fill-gray-300");
                    }
                });
            }

            await refreshReviews(productId);

            closeModal();
            showToast(t("rating_saved", "Thank you for your rating!"));
        } catch {
            showToast(t("error_text", "Something went wrong"));
        }
    });

    reset();
}

async function refreshReviews(productId) {
    try {
        const response = await fetch(`/products/${productId}/reviews`, {
            headers: { Accept: "application/json" },
        });

        if (!response.ok) return;

        const data = await response.json();
        const reviewsList = document.getElementById("reviews-list");
        if (!reviewsList) return;

        if (data.reviews.length === 0) {
            reviewsList.innerHTML = `
                <p class="text-gray-500 text-sm text-center py-8">${t("no_reviews_yet", "No reviews yet")}</p>
                <p class="text-gray-400 text-xs text-center pb-4">${t("be_first_to_review", "Be the first to review this product")}</p>
            `;
            return;
        }

        reviewsList.innerHTML = data.reviews
            .map(
                (review) => `
                <div class="border-b border-gray-100 py-4 last:border-0">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                ${review.initial}
                            </div>
                            <span class="font-medium text-sm text-gray-900">${review.name}</span>
                        </div>
                        <span class="text-xs text-gray-400">${review.time}</span>
                    </div>
                    <div class="flex items-center gap-0.5">
                        ${Array.from(
                            { length: 5 },
                            (_, i) => `
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ${i < review.rating ? "text-yellow-400 fill-yellow-400" : "text-gray-300 fill-gray-300"}"
                                viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L1.933 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                            </svg>
                        `,
                        ).join("")}
                    </div>
                    ${review.comment ? `<p class="text-sm text-gray-700 mt-2 leading-relaxed">${review.comment}</p>` : ""}
                </div>
            `,
            )
            .join("");
    } catch {
    }
}
