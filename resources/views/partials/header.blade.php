<style>
    :root {
        --primary-red: #d92525;
        --dark-red: #b31616;
        --light-red: #ff6b6b;
        --dark-bg: #1a1a1a;
        --light-bg: #f9f9f9;
        --text-dark: #333;
        --text-light: #fff;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
        background-color: var(--light-bg);
        line-height: 1.6;
    }

    h1, h2, h3 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Header Styles */
    header {
        background-color: black; /* Header background color */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        width: 100%;
        z-index: 1000;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo h1 {
        font-size: 28px;
        color: #E7592B; /* Company name color */
        margin-right: 10px;
    }

    .logo span {
        font-size: 28px; /* Match font size with company name */
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        color: #E7592B; /* Same color as company name */
    }

    nav ul {
        display: flex;
        list-style: none;
    }

    nav ul li {
        margin-left: 30px;
    }

    nav ul li a {
        text-decoration: none;
        color: white; /* Header letters white */
        font-weight: 500;
        transition: color 0.3s;
    }

    nav ul li a.active, /* Highlight clicked heading */
    nav ul li a:hover {
        color: #E7592B; /* Clicked heading color */
    }

    /* Page Banner */
    .page-banner {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
        height: 300px;
        display: flex;
        align-items: center;
        text-align: center;
        color: var(--text-light);
        padding-top: 80px;
    }

    .page-banner h1 {
        font-size: 48px;
        margin-bottom: 20px;
    }

    /* Menu Section */
    .menu {
        padding: 80px 0;
        background-color: var(--text-light);
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-size: 36px;
        color: var(--primary-red);
        margin-bottom: 15px;
    }

    .section-title p {
        max-width: 700px;
        margin: 0 auto;
    }

    .menu-categories {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .category-btn {
        background: none;
        border: none;
        padding: 10px 20px;
        margin: 0 10px;
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
        transition: all 0.3s;
        border-bottom: 2px solid transparent;
    }

    .category-btn.active {
        color: var(--primary-red);
        border-bottom: 2px solid var(--primary-red);
    }

    .category-btn:hover {
        color: var(--primary-red);
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .menu-item {
        background-color: var(--light-bg);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        display: flex;
    }

    .menu-item:hover {
        transform: translateY(-10px);
    }

    .menu-item-img {
        width: 120px;
        height: 120px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .menu-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .menu-item-info {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .menu-item-info h3 {
        font-size: 18px;
        margin-bottom: 5px;
        color: var(--primary-red);
    }

    .menu-item-info p {
        margin-bottom: 10px;
        color: #666;
        font-size: 14px;
    }

    .menu-item-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price {
        font-weight: 700;
        color: var(--primary-red);
        font-size: 16px;
    }

    .add-to-cart {
        background-color: var(--primary-red);
        color: var(--text-light);
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-to-cart:hover {
        background-color: var(--dark-red);
    }

    /* Footer */
    footer {
        background-color: var(--dark-bg);
        color: var(--text-light);
        padding: 60px 0 20px;
    }

    .footer-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
    }

    .footer-logo {
        margin-bottom: 20px;
    }

    .footer-logo h2 {
        font-size: 28px;
        color: var(--text-light);
        margin-bottom: 5px;
    }

    .footer-logo span {
        display: block;
        font-size: 14px;
        letter-spacing: 2px;
    }

    .footer-about p {
        margin-bottom: 20px;
    }

    .footer-links h3 {
        font-size: 20px;
        margin-bottom: 20px;
        color: var(--text-light);
    }

    .footer-links ul {
        list-style: none;
    }

    .footer-links ul li {
        margin-bottom: 10px;
    }

    .footer-links ul li a {
        color: #ccc;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-links ul li a:hover {
        color: var(--light-red);
    }

    .copyright {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.1);
        color: #999;
        font-size: 14px;
    }

    /* Mobile Menu */
    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        color: var(--primary-red);
        cursor: pointer;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .header-container {
            padding: 15px;
        }

        nav {
            position: fixed;
            top: 80px;
            left: -100%;
            width: 100%;
            height: calc(100vh - 80px);
            background-color: var(--text-light);
            transition: left 0.3s;
        }

        nav.active {
            left: 0;
        }

        nav ul {
            flex-direction: column;
            padding: 20px;
        }

        nav ul li {
            margin: 15px 0;
        }

        .mobile-menu-btn {
            display: block;
        }

        .page-banner h1 {
            font-size: 36px;
        }

        .menu-item {
            flex-direction: column;
        }

        .menu-item-img {
            width: 100%;
            height: 150px;
        }
    }
</style>

<header>
    <div class="container header-container">
        <div class="logo">
            <img src="{{ asset('uploads/logo/logo2.png') }}" alt="Flame & Crust Pizzeria Logo" class="logo" style="width: 100px; height: auto;">
            <h1>FLAME & CRUST PIZZERIA</h1>
       
        </div>
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
        <nav id="mainNav">
            <ul>
                <li><a href="{{ route('welcome') }}" @if(Request::routeIs('welcome')) class="active" @endif>HOME</a></li>
                <li><a href="{{ route('menu') }}" @if(Request::routeIs('menu')) class="active" @endif>MENU</a></li>
                <li><a href="{{ route('about') }}" @if(Request::routeIs('about')) class="active" @endif>ABOUT US</a></li>
                <li><a href="{{ route('contact') }}" @if(Request::routeIs('contact')) class="active" @endif>CONTACT US</a></li>
                @auth
                    <li><a href="#">DASHBOARD</a></li>
                @else
                    <li><a href="{{ route('login') }}">LOGIN</a></li>
                @endauth
            </ul>
        </nav>
    </div>
</header>

<script>
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainNav = document.getElementById('mainNav');

    mobileMenuBtn.addEventListener('click', () => {
        mainNav.classList.toggle('active');
    });

    // Close menu when clicking on a link
    const navLinks = document.querySelectorAll('nav ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            mainNav.classList.remove('active');
        });
    });
</script>