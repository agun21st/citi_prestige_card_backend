@component('mail::message')

{{-- @component('mail::panel') --}}
# Dear {{$myArray['name']}},
{{-- @endcomponent --}}
Welcome to cit.tools app powerd by Creative IT Institute

শুধুমাত্র cit শিক্ষার্থীদের জন্যই থাকছে ২০ লক্ষ+ টাকার প্রিমিয়াম টুলস, সফটওয়্যার ও রিসোর্স অসংখ্যবার ডাউনলোড এর দারুণ সুযোগ



@component('mail::button', ['url' => 'https://app.cit.tools/login'])
Click here to login
@endcomponent



@component('mail::table')
| Login ID      | Password      |
| ------------- |:-------------:|
| {{$myArray['login_id']}} | {{$myArray['password']}} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
