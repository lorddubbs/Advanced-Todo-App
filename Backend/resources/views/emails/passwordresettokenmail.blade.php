@component('mail::message')
# Password Reset

Hello,

<p>
    You requested for a password reset. Kindly click on the button below
    to reset your password.

    Ignore this email if you did not make the request.
</p>

@component('mail::button', ['url' => $url .'/update-password?token='.$token])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
