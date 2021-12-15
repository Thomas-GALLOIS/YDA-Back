@component('mail::message')
  Bonjour, créez votre compte Your Daily Assistant
  @component('mail::button', ['url' => $url])
    LOGIN
  @endcomponent
@endcomponent
