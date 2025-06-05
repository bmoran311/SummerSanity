<!DOCTYPE html>
<html lang="en">
    @include('partials.dashboard-head')
    <style>
    .badge {
        display: inline-block;
        min-width: 18px;
        padding: 2px 6px;
        font-size: 12px;
        font-weight: bold;
        color: #fff;
        background-color: #e3342f; /* Red */
        border-radius: 9999px;
        text-align: center;
        line-height: 1;
        vertical-align: middle;
    }
    </style>
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
                    <li class="nav__link"><a href="/friends">Friends                        
                        @if(isset($pending_friend_requests) && $pending_friend_requests->count() > 0)
                            <span class="badge">{{ $pending_friend_requests->count() }}</span>
                        @endif                      
                    </a></li>
                    <li id="invitation-link" class="nav__link"><a href="#">Invitation</a></li>
                    <li class="nav__link"><a href="/edit_profile">Profile</a></li>
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
