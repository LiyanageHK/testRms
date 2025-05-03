<header>
    <div class="container header-container">
        <div class="logo">
            {{-- <img src="https://via.placeholder.com/50/ff0000/ffffff?text=FC" alt="Flame & Crust Logo"> --}}
            <div>
                <h1>FLAME & CRUST</h1>
                <span>PIZZARIA</span>
            </div>
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
                    <li><a href="{{ route('dashboard') }}">DASHBOARD</a></li>
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