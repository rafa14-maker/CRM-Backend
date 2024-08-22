<x-mail::message>
# Introduction

<x-mail::panel>
{{ $invoice_terms }}
</x-mail::panel>

<x-mail::panel>
{{ $package_terms }}
</x-mail::panel>

<x-mail::panel>
{{ $bank_information }}
</x-mail::panel>

<x-mail::panel>
{{ $lead_fetch_url}}
</x-mail::panel>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
