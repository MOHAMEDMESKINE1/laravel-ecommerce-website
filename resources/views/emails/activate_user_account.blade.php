@component('mail::message')
    # Merci d'activer votre compte 
    
    @component('mail::panel')
            Pour activer votre compte
    @endcomponent

    @component('mail::button',["url"=>$url])
            Cliquez ici
    @endcomponent
    
    Merci
    
    <br>
    équipe {{config("app.name")}}

@endcomponent