@include('partials.head')
<!DOCTYPE html>
<html lang="en">   
    <body>
        <header>      
            <x-header.header />            
        </header>
        
        <main>
            <x-home.hero />  
            <x-home.calendar />  
            <x-home.about />  
            <x-home.team />  
            <img class="line-separator" src="/assets/dotted-separator.svg" alt="Dotted line separator between sections" />   
            <x-home.cta />              
        </main>       
        <footer>      
            <x-footer.footer />            
        </footer>
    </body>
</html>

