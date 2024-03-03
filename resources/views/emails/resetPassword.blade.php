@component('mail::message')
# Dear {{ $firstName }},

You recently requested to reset your password for your account. To complete the process, please click the link below:

{{ $url }}

This link will take you to a secure page where you can set a new password for your account. If you did not request a password reset, please ignore this email or contact us if you have any concerns.

Please note: This password reset link is valid for a limited time only.



Best Regards,

Your LangBooster Team
@endcomponent
