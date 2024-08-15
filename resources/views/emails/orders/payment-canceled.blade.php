@component('mail::message')
# Maksusi peruutettiin

Hei,<br><br>

Maksusi peruutettiin<br><br>

Muuttolaatikot: <a href="https://vuokralaatikot.fi">Vuokralaatikot</a><br>

Ystävällisin terveisin,<br><br>

{{ $request['company_name'] }}<br><br>

{{ $request['company_email']  }} <br>

{{ $request['company_phone']  }} <br>

Kiitos!,<br>
{{ config('app.name') }}
@endcomponent