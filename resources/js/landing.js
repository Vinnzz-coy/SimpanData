
document.addEventListener('DOMContentLoaded', function() {

    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            const icon = mobileMenuBtn.querySelector('i');
            if (mobileMenu.classList.contains('active')) {
                icon.classList.remove('bx-menu');
                icon.classList.add('bx-x');
            } else {
                icon.classList.remove('bx-x');
                icon.classList.add('bx-menu');
            }
        });
    }

    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-md', 'bg-white');
            navbar.classList.remove('bg-white/90');
        } else {
            navbar.classList.remove('shadow-md', 'bg-white');
            navbar.classList.add('bg-white/90');
        }
    });

    const heroBg = document.getElementById('heroBg');
    if (heroBg) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallaxSpeed = 0.5;
            heroBg.style.transform = `translateY(${scrolled * parallaxSpeed}px)`;
        });
    }

    const scrollProgress = document.getElementById('scrollProgress');
    if (scrollProgress) {
        window.addEventListener('scroll', function() {
            const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (window.scrollY / windowHeight) * 100;
            scrollProgress.style.width = scrolled + '%';
        });
    }

    const reveals = document.querySelectorAll('.reveal');
    const revealsScale = document.querySelectorAll('.reveal-scale');
    const revealsSlideLeft = document.querySelectorAll('.reveal-slide-left');
    const revealsSlideRight = document.querySelectorAll('.reveal-slide-right');

    const revealOnScroll = function() {
        const allElements = [
            ...Array.from(reveals).map(el => ({el, cls: 'reveal'})),
            ...Array.from(revealsScale).map(el => ({el, cls: 'reveal-scale'})),
            ...Array.from(revealsSlideLeft).map(el => ({el, cls: 'reveal-slide-left'})),
            ...Array.from(revealsSlideRight).map(el => ({el, cls: 'reveal-slide-right'}))
        ];

        allElements.forEach(({el}) => {
            const windowHeight = window.innerHeight;
            const elementTop = el.getBoundingClientRect().top;
            const elementVisible = 150;

            if (elementTop < windowHeight - elementVisible) {
                el.classList.add('active');
            }
        });
    };

    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();

    const feedbackTracks = document.querySelectorAll('.feedback-track');
    feedbackTracks.forEach(track => {
        track.addEventListener('mouseenter', () => {
            track.classList.add('paused');
        });
        track.addEventListener('mouseleave', () => {
            track.classList.remove('paused');
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });

                if (mobileMenu && mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    const icon = mobileMenuBtn.querySelector('i');
                    icon.classList.remove('bx-x');
                    icon.classList.add('bx-menu');
                }
            }
        });
    });
});

if (typeof ScrollReveal !== 'undefined') {
    const sr = ScrollReveal({
        origin: 'bottom',
        distance: '60px',
        duration: 1000,
        delay: 200,
        easing: 'cubic-bezier(0.5, 0, 0, 1)',
        reset: false,
        mobile: true,
        opacity: 0,
        scale: 0.95
    });

    sr.reveal('.hero-content h1', {
        origin: 'bottom',
        distance: '80px',
        duration: 1200,
        delay: 300,
        scale: 0.9
    });

    sr.reveal('.hero-content p', {
        origin: 'bottom',
        distance: '60px',
        duration: 1000,
        delay: 500
    });

    sr.reveal('.hero-content .flex', {
        origin: 'bottom',
        distance: '60px',
        duration: 1000,
        delay: 700
    });

    sr.reveal('#features .inline-flex', {
        origin: 'top',
        distance: '40px',
        duration: 800,
        delay: 100
    });

    sr.reveal('#features h2', {
        origin: 'bottom',
        distance: '50px',
        duration: 900,
        delay: 200
    });

    sr.reveal('#features > div > div > p', {
        origin: 'bottom',
        distance: '50px',
        duration: 900,
        delay: 300
    });

    sr.reveal('#features .grid > div', {
        origin: 'bottom',
        distance: '60px',
        duration: 1000,
        interval: 150,
        delay: 100,
        scale: 0.95
    });

    sr.reveal('#feedback .inline-flex', {
        origin: 'top',
        distance: '40px',
        duration: 800,
        delay: 100
    });

    sr.reveal('#feedback h2', {
        origin: 'bottom',
        distance: '50px',
        duration: 900,
        delay: 200
    });

    sr.reveal('#feedback > div > div > p', {
        origin: 'bottom',
        distance: '50px',
        duration: 900,
        delay: 300
    });

    sr.reveal('.feedback-container', {
        origin: 'left',
        distance: '100px',
        duration: 1200,
        interval: 200
    });

    sr.reveal('.marquee-header', {
        origin: 'bottom',
        distance: '40px',
        duration: 1000,
        delay: 200
    });

    sr.reveal('.marquee-section .group', {
        origin: 'bottom',
        distance: '40px',
        duration: 1000,
        delay: 400,
        opacity: 0
    });
}
