@component('mail::message')
# Welcome to STD

Hello {{$user->name}},

Welcome to Std. 

A simple TODO APP to get you going

Login to continue access your account.

@component('mail::button', ['url' => $url])
Visit STD
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
