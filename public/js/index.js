window.addEventListener("scroll", function () {
    const navbar = document.getElementById("navbar");
    if (window.scrollY > 50) {
        navbar.classList.add(
            "bg-white/95",
            "backdrop-blur-sm",
            "shadow-custom",
            "py-2",
        );
        navbar.classList.remove("py-4");
    } else {
        navbar.classList.remove(
            "bg-white/95",
            "backdrop-blur-sm",
            "shadow-custom",
            "py-2",
        );
        navbar.classList.add("py-4");
    }
});

const mobileMenuBtn = document.getElementById("mobileMenuBtn");
const mobileMenu = document.getElementById("mobileMenu");

if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener("click", function () {
        mobileMenu.classList.toggle("active");
        const icon = mobileMenuBtn.querySelector("i");
        if (icon) {
            icon.className = mobileMenu.classList.contains("active")
                ? "fas fa-times"
                : "fas fa-bars";
        }
    });
}

document.addEventListener("click", function (event) {
    const navbar = document.getElementById("navbar");
    if (navbar && !navbar.contains(event.target) && mobileMenu) {
        mobileMenu.classList.remove("active");
        if (mobileMenuBtn) {
            const icon = mobileMenuBtn.querySelector("i");
            if (icon) {
                icon.className = "fas fa-bars";
            }
        }
    }
});

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
            target.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
            if (mobileMenu) {
                mobileMenu.classList.remove("active");
                if (mobileMenuBtn) {
                    const icon = mobileMenuBtn.querySelector("i");
                    if (icon) {
                        icon.className = "fas fa-bars";
                    }
                }
            }
        }
    });
});

const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver(function (entries) {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("active");
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll(".reveal").forEach((el) => {
    observer.observe(el);
});

function createFeedbackCard(feedback) {
    const card = document.createElement("div");
    card.className =
        "relative z-10 flex-shrink-0 transition-all duration-300 bg-white border cursor-pointer w-96 rounded-2xl p-7 shadow-custom border-border hover:scale-105 hover:shadow-2xl hover:border-primary/30 hover:z-20";

    card.innerHTML = `
        <div class="mb-4">
            <i class="text-2xl fas fa-quote-left text-slate-300"></i>
        </div>
        <p class="mb-6 text-sm leading-relaxed text-text-primary">"${feedback.comment}"</p>
        <div class="flex items-center gap-3 pt-6 border-t border-border">
            <img src="${feedback.avatar}" alt="${feedback.name}" class="object-cover w-12 h-12 rounded-full bg-border">
            <div>
                <h4 class="text-sm font-semibold text-text-primary">${feedback.name}</h4>
                <p class="text-xs text-text-secondary">${feedback.role} • ${feedback.company}</p>
            </div>
        </div>
    `;
    return card;
}

function initializeFeedback() {
    const track1 = document.getElementById("feedbackTrack1");
    const track2 = document.getElementById("feedbackTrack2");
    const container1 = document.getElementById("feedbackContainer1");
    const container2 = document.getElementById("feedbackContainer2");

    if (!track1 || !track2 || !container1 || !container2) {
        return;
    }

    // Get feedbacks from global variable set by Blade template
    if (
        typeof feedbacks === "undefined" ||
        !feedbacks ||
        feedbacks.length === 0
    ) {
        return;
    }

    const duplicatedFeedbacks = [...feedbacks, ...feedbacks];

    duplicatedFeedbacks.forEach((feedback) => {
        track1.appendChild(createFeedbackCard(feedback));
    });

    [...duplicatedFeedbacks].reverse().forEach((feedback) => {
        track2.appendChild(createFeedbackCard(feedback));
    });

    let isPaused = false;

    function handleMouseEnter() {
        isPaused = true;
        track1.style.animationPlayState = "paused";
        track2.style.animationPlayState = "paused";
        track1.classList.add("paused");
        track2.classList.add("paused");
    }

    function handleMouseLeave() {
        isPaused = false;
        track1.style.animationPlayState = "running";
        track2.style.animationPlayState = "running";
        track1.classList.remove("paused");
        track2.classList.remove("paused");
    }

    // Add event listeners to containers
    container1.addEventListener("mouseenter", handleMouseEnter);
    container1.addEventListener("mouseleave", handleMouseLeave);
    container2.addEventListener("mouseenter", handleMouseEnter);
    container2.addEventListener("mouseleave", handleMouseLeave);
}

// Initialize everything when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    // Initialize feedback section
    initializeFeedback();

    // Add smooth scrolling
    document.documentElement.style.scrollBehavior = "smooth";
});
