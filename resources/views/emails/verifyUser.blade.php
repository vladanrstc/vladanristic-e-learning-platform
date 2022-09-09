@if($user['language'] == "en")
    <h2>Welcome to the site {{$user['name']}}</h2>
    <br/>
    Your registered email-id is {{$user['email']}}. <br>Please click on the below link to verify your email account<br>
    <br/>
    <a href="{{url('user/verify', $user['remember_token']) }}">Verify Email</a>
@elseif($user['language'] == "sr")
    <h2>Dobro došli na platformu vladanristic.com</h2>
    <br/>
    Vaša elektronska pošta je: {{$user['email']}}.
    <br>Molimo Vas, kliknite na link ispod kako bi ste potvrdili Vaš nalog.<br>
    <br/>
    <a href="{{url('user/verify', $user['remember_token']) }}">Potvrdi adresu elektronske pošte</a>
@endif
