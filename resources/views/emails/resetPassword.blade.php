@if($user['language'] == "en")
    <h2>Click on the link below to reset your password:</h2>
    <br/>
    <a href="{{url('user/reset-password', $user['remember_token']) }}">Click here</a>
@elseif($user['language'] == "sr")
    <h2>Za resetovanje Vaše lozinke kliknite na link ispod:</h2>
    <br/>
    <a href="{{url('user/reset-password', $user['remember_token']) }}">Kliknite ovde</a>
@endif
