@component('mail::message')
# Verify Your NSTU Email

Your one-time verification code is:

@component('mail::panel')
<h1 style="text-align: center; font-size: 32px; color: #1a73e8;">{{ $otp }}</h1>
@endcomponent

This code expires in 15 minutes. For assistance, contact NSTU support.

Thanks,<br>
{{ config('app.name') }}
@endcomponent