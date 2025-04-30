<header>
    <nav class="nav">
        <div class="container">
            <ul class="nav__links">
                <li class="nav__link"><a href="#hero">Home</a></li>
                <li class="nav__link"><a href="#calendar">Features</a></li>
                <li class="nav__link"><a href="#about">About Us</a></li>
                <li class="nav__link"><a href="#team">Team</a></li>
                <li class="nav__link"><a href="/faqs">FAQs</a></li>
            </ul>
            <div class="logo">
                <a href="/"><img src="/assets/logo.svg" alt="Summer Sanity Logo" /></a>
            </div>            
            @guest('guardian')
                <div class="actions">
                    <a href="#login"><button class="btn btn--tertiary btn--sm">Login</button></a>
                    <a href="#cta"><button class="btn btn--secondary btn--sm">Register</button></a>
                </div>
            @else
            <div class="welcome-msg" style="color: black; display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.9rem; font-weight: bold;"><b>Welcome, {{ Auth::guard('guardian')->user()->first_name }}!</b></span>

                <form action="{{ route('guardian.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn--tertiary btn--sm">Logout</button>
                </form>

                <a href="/my-dashboard" class="btn btn--secondary btn--sm">My Dashboard</a>
            </div>
            @endguest
        </div>
    </nav>
</header>