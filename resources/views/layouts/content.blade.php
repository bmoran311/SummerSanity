@include('partials.head')
<!DOCTYPE html>
<html lang="en">   
    <body>
        <header>      
            <x-header.header />            
        </header>
        
        <main>
            @yield('content')                            
        </main>       
        <footer>      
            <x-footer.footer />            
        </footer>
    </body>
</html>

