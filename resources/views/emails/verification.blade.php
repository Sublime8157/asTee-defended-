<x-mail::message>
# Email Verification

Thank you for choosing a's Tee! We're excited to have you on board. To ensure the best shopping experience, please verify your email address by clicking the button below. Once verified, you'll be able to explore our latest collections and enjoy exclusive offers. Thank you for joining us on this journey!

<x-mail::button :url="route('verified', ['email' => $userEmail])">
VERIFY EMAIL
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
