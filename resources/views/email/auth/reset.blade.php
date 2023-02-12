{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

 --}}



@component('mail::message')
# Introduction

Sofra reset password
<p>Hello{{$user->name}}</p>
<P>your reset code is :{{$user->pin_code}}</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
