
@component('mail::message')
    <h2>Hello {{$body['name']}},</h2>
    <p>The email is a sample email for testing that is it work for the cpanel hosting with it's mail server! @component('mail::button', ['url' => $body['url_a']])
            Qubit Solution Lab
        @endcomponent</p>



    Happy coding!

    Thanks
    {{ config('app.name') }}
    Qubit Solution Lab Team.
@endcomponent
