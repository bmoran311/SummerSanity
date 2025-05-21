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
                    
                </ul>
                <div class="profile">
                    
                </div>
            </nav>

            {{-- Main Content --}}
            <main>
                @yield('content')
            </main>
        </div>                        
    </body>
</html>
