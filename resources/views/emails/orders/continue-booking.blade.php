@component('mail::message')
# Tarvetta lisãà aikaa?

Hei {{ $request['first_name'] }} {{ $request['last_name'] }},<br><br>

Muuttolaatikoiden vuokraus päättyy huomenna {{ $request['end_date'] }}. Jos tarvetta lisäà aikaa jatkaa vuokran <a href="https://payment.vuokralaatikot.fi/continue/{$request['id']}">tästà</a> linkistà.<br>

Kiitos!,<br>
{{ config('app.name') }}
@endcomponent
