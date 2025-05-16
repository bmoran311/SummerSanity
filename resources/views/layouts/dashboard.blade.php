<!DOCTYPE html>
<html lang="en">
    @include('partials.dashboard-head')
    <body>
        <div class="dashboard">
            {{-- Navigation --}}
            <nav class="nav nav--dashboard">
                <div class="logo">
                    <a href="/"><img src="/assets/logo.svg" alt="Summer Sanity Logo" /></a>
                </div>
                <ul class="nav__links">
                    <li class="nav__link"><a href="/my-dashboard">Dashboard</a></li>
                    <li class="nav__link"><a href="/campers">My Kids</a></li>
                    <li class="nav__link"><a href="/friends">Friends</a></li>
                    <li id="invitation-link" class="nav__link"><a href="#">Invitation</a></li>
                    <li class="nav__link"><a href="/profile">Profile</a></li>
                </ul>
                <div class="profile">
                    <span>{{ Auth::guard('guardian')->user()->first_name }} {{ Auth::guard('guardian')->user()->last_name }}</span>
                </div>
            </nav>

            {{-- Main Content --}}
            <main>
                @yield('content')
            </main>
        </div>                
        @include('partials.invitation_modal')
        @include('partials.toast')
    </body>
</html>
