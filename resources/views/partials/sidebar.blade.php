<div class="sidebar" id="sidebar">
    <div class="logo-details">
        <div class="logo_name" id="logo-link">SipanData</div>
        <button type="button" id="btn">
            <i class='bx bx-menu'></i>
        </button>
    </div>

    <ul class="nav-list">
        <li>
            <a href="#" class="active">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-user'></i>
                <span class="links_name">Data Siswa</span>
            </a>
            <span class="tooltip">Data Siswa</span>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-building'></i>
                <span class="links_name">DUDI</span>
            </a>
            <span class="tooltip">DUDI</span>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-user-check'></i>
                <span class="links_name">Pembimbing</span>
            </a>
            <span class="tooltip">Pembimbing</span>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-show-alt'></i>
                <span class="links_name">Monitoring</span>
            </a>
            <span class="tooltip">Monitoring</span>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-file'></i>
                <span class="links_name">Laporan</span>
            </a>
            <span class="tooltip">Laporan</span>
        </li>
    </ul>

    <div class="profile-section">
        <div class="profile-content">
            <div class="profile-details">
                <div class="profile-info">
                    <div class="name">Admin PKL</div>
                    <div class="job">Administrator</div>
                </div>
            </div>
            <button class="logout-btn" id="log_out">
                <i class='bx bx-log-out'></i>
                <span class="logout-tooltip">Logout</span>
            </button>
        </div>
    </div>
</div>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<style>
    :root {
        --primary-color: #11101D;
        --secondary-color: #1d1b31;
        --accent-color: #695CFE;
        --light-color: #e4e9f7;
        --white-color: #ffffff;
        --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 80px;
        background: linear-gradient(180deg, var(--primary-color) 0%, #0d0c1a 100%);
        padding: 10px 14px;
        z-index: 1000;
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        transform: translateZ(0);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        will-change: width;
    }

    .sidebar.open {
        width: 260px;
    }

    .logo-details {
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        padding: 0 10px;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .logo-details .logo_name {
        color: var(--white-color);
        font-size: 22px;
        font-weight: 700;
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        letter-spacing: 0.5px;
        background: linear-gradient(45deg, #695CFE, #9b89ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        pointer-events: none;
    }

    .sidebar.open .logo-details .logo_name {
        opacity: 1;
        pointer-events: auto;
    }

    .logo-details #btn {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        font-size: 24px;
        color: var(--white-color);
        background: transparent;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: var(--transition);
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-details #btn:hover {
        background: rgba(105, 92, 254, 0.2);
        transform: translateY(-50%) scale(1.05);
    }

    .nav-list {
        flex: 1;
        overflow-y: auto;
        overflow-x: visible;
        padding-bottom: 120px;
    }

    .nav-list::-webkit-scrollbar {
        width: 0px;
    }

    .sidebar:not(.open) .nav-list {
        overflow: visible !important;
    }

    .sidebar:not(.open) .nav-list li {
        overflow: visible !important;
    }

    .nav-list li {
        position: relative;
        margin: 8px 0;
        list-style: none;
    }

    .nav-list li a {
        display: flex;
        height: 55px;
        width: 100%;
        border-radius: 12px;
        align-items: center;
        text-decoration: none;
        transition: background 0.2s ease;
        background: transparent;
        position: relative;
        overflow: visible;
    }

    .nav-list li a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: var(--accent-color);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .nav-list li a.active::before {
        transform: scaleY(1);
    }

    .nav-list li a:hover,
    .nav-list li a.active {
        background: rgba(105, 92, 254, 0.1);
    }

    .nav-list li a i {
        min-width: 55px;
        font-size: 22px;
        color: #b0b3d6;
        text-align: center;
        line-height: 55px;
        transition: color 0.2s ease;
        position: relative;
        z-index: 1;
    }

    .nav-list li a.active i,
    .nav-list li a:hover i {
        color: var(--accent-color);
    }

    .nav-list li a .links_name {
        color: #b0b3d6;
        font-size: 15px;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s ease;
        margin-left: 5px;
    }

    .sidebar.open .nav-list li a .links_name {
        opacity: 1;
        pointer-events: auto;
    }

    .nav-list li a.active .links_name,
    .nav-list li a:hover .links_name {
        color: var(--white-color);
    }

    .nav-list li .tooltip {
        position: absolute;
        left: calc(100% + 20px);
        top: 50%;
        transform: translateY(-50%) translateX(-10px);
        background: var(--white-color);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--primary-color);
        opacity: 0;
        white-space: nowrap;
        pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
        z-index: 1100;
        min-width: 100px;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.05);
        visibility: hidden;
    }

    .nav-list li .tooltip::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 50%;
        transform: translateY(-50%);
        border-width: 6px 6px 6px 0;
        border-style: solid;
        border-color: transparent var(--white-color) transparent transparent;
    }

    .sidebar:not(.open) .nav-list li:hover .tooltip {
        opacity: 1;
        transform: translateY(-50%) translateX(0);
        visibility: visible;
    }

    .sidebar.open .nav-list li .tooltip {
        display: none;
    }

    .profile-section {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 15px;
        background: var(--secondary-color);
        transition: var(--transition);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 10;
    }

    .profile-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .profile-details {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
        overflow: hidden;
    }

    .profile-info {
        margin-left: 12px;
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar.open .profile-info {
        opacity: 1;
    }

    .profile-info .name {
        font-size: 15px;
        font-weight: 600;
        color: var(--white-color);
    }

    .profile-info .job {
        font-size: 12px;
        color: #b0b3d6;
        margin-top: 2px;
    }

    .logout-btn {
        position: relative;
        width: 45px;
        height: 45px;
        background: rgba(255, 107, 107, 0.1);
        border: none;
        border-radius: 10px;
        color: #ff6b6b;
        font-size: 22px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-left: 15px;
    }

    .sidebar:not(.open) .logout-btn {
        margin-left: 0;
    }

    .logout-btn:hover {
        background: #ff6b6b;
        color: var(--white-color);
        transform: scale(1.05);
    }

    .logout-tooltip {
        position: absolute;
        left: calc(100% + 20px);
        top: 50%;
        transform: translateY(-50%) translateX(-10px);
        background: var(--white-color);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--primary-color);
        opacity: 0;
        white-space: nowrap;
        pointer-events: none;
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
        z-index: 1100;
        min-width: 80px;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.05);
        visibility: hidden;
    }

    .logout-tooltip::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 50%;
        transform: translateY(-50%);
        border-width: 6px 6px 6px 0;
        border-style: solid;
        border-color: transparent var(--white-color) transparent transparent;
    }

    .sidebar:not(.open) .logout-btn:hover .logout-tooltip {
        opacity: 1;
        transform: translateY(-50%) translateX(0);
        visibility: visible;
    }

    .sidebar.open .logout-btn .logout-tooltip {
        display: none;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.3s;
        visibility: hidden;
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
    }

    .sidebar-overlay.active {
        display: block;
        opacity: 1;
        visibility: visible;
    }

    @media (max-width: 1200px) {
        .sidebar {
            left: -100%;
            z-index: 1000;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(0);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        .sidebar.open {
            left: 0;
            transform: translateX(0);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
            width: 280px;
        }

        .nav-list li .tooltip,
        .logout-tooltip {
            display: none !important;
        }
    }

    @media (max-width: 992px) {
        .profile-section {
            padding: 12px;
        }

        .logout-btn {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }
    }

    @media (max-width: 768px) {
        .profile-info .name {
            font-size: 14px;
        }

        .profile-info .job {
            font-size: 11px;
        }
    }

    @media (max-width: 576px) {
        .sidebar.open {
            width: 250px;
        }

        .nav-list li a {
            height: 50px;
        }

        .nav-list li a i {
            min-width: 50px;
            line-height: 50px;
            font-size: 20px;
        }
    }

    @media (max-width: 480px) {
        .profile-section {
            padding: 10px;
        }

        .logout-btn {
            width: 36px;
            height: 36px;
            font-size: 18px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const closeBtn = document.querySelector('#btn');
        const logoLink = document.querySelector('#logo-link');
        const sidebarOverlay = document.querySelector('#sidebar-overlay');
        const navLinks = document.querySelectorAll('.nav-list li a');

        let sidebarState = localStorage.getItem('sidebarState') === 'open';

        function loadSidebarState() {
            sidebar.style.transition = 'none';

            if (sidebarState && window.innerWidth > 1200) {
                sidebar.classList.add('open');
            } else {
                sidebar.classList.remove('open');
            }

            setTimeout(() => {
                sidebar.style.transition = '';
            }, 50);

            updateMenuIcon();
        }

        function toggleSidebar() {
            const isOpen = sidebar.classList.contains('open');

            if (isOpen) {
                sidebar.classList.remove('open');
                sidebarState = false;
            } else {
                sidebar.classList.add('open');
                sidebarState = true;
            }

            updateMenuIcon();

            if (window.innerWidth > 1200) {
                localStorage.setItem('sidebarState', sidebarState ? 'open' : 'closed');
            }

            handleMobileOverlay();
        }

        function updateMenuIcon() {
            const isOpen = sidebar.classList.contains('open');
            const closeBtn = document.querySelector('#btn');

            if (closeBtn) {
                const icon = closeBtn.querySelector('i');
                if (isOpen) {
                    icon.classList.replace('bx-menu', 'bx-menu-alt-right');
                } else {
                    icon.classList.replace('bx-menu-alt-right', 'bx-menu');
                }
            }
        }

        function handleMobileOverlay() {
            const overlay = document.getElementById('sidebar-overlay');

            if (window.innerWidth <= 1200) {
                if (sidebar.classList.contains('open')) {
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                } else {
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
        }

        loadSidebarState();

        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleSidebar();
            });
        }

        if (logoLink) {
            logoLink.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('Logo clicked - redirect to dashboard');
            });
        }

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                navLinks.forEach(l => l.classList.remove('active'));

                this.classList.add('active');

                if (window.innerWidth <= 1200) {
                    sidebar.classList.remove('open');
                    document.getElementById('sidebar-overlay').classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
                updateMenuIcon();

                if (window.innerWidth > 1200) {
                    localStorage.setItem('sidebarState', 'closed');
                    sidebarState = false;
                }
            });
        }

        const logoutBtn = document.querySelector('#log_out');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (confirm('Apakah Anda yakin ingin logout?')) {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';
                    this.style.background = '#ff6b6b';
                    this.style.color = 'white';
                    this.disabled = true;

                    // Buat form untuk logout
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("logout") }}';
                    form.style.display = 'none';
                    
                    // Tambahkan CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Tambahkan form ke body dan submit
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        window.addEventListener('resize', function() {
            const overlay = document.getElementById('sidebar-overlay');

            if (window.innerWidth > 1200) {
                if (sidebarState) {
                    sidebar.classList.add('open');
                } else {
                    sidebar.classList.remove('open');
                }

                if (overlay) overlay.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.remove('open');
                if (overlay) overlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            updateMenuIcon();
        });
    });
</script>
