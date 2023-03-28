## Email send for cpanel hosting

### Installation
- Clone the repository
- Run `composer update`
- Copy `.env.example` to `.env`
- Edit `.env` file and set your mail credentials with mail server credentials

### Mail Server configuration in .env file
```
    MAIL_MAILER=smtp
    MAIL_HOST=mail.qubitsolutionlab.com
    MAIL_PORT=587
    MAIL_USERNAME=no-reply@qubitsolutionlab.com
    MAIL_PASSWORD= 'password'
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="no-reply@qubitsolutionlab.com"
    MAIL_FROM_NAME="${APP_NAME}"
```

### Usage
- Create mail with markdown

```
php artisan make:mail QBLabMail --markdown=emails.QBLabMail
```
By running the above command, two files are generated:
- `
app/Mail/QBLabMail.php
`
- `
resources/views/emails/QBLabMail.blade.php
`

Edit `app/Mail/QBLabMail.php` and write down this code
    
```
    public function __construct($body)
    {
        //
        $this->body =$body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.QBLabMail')->with('body',$this->body);
    }
```

Create mail controller for Mail

```
php artisan make:controller MailController
```

Now we will use our MailController file and add the sendMail() function into it. Using this file, we can quickly write the mail send code

```
    public function sendMail(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email'
        ]);
        $email = $data['email'];

        $body = [
            'name'=>$data['name'],
            'url_a'=>'https://qubitsolutionlab.com//',
        ];

        Mail::to($email)->send(new QBLabMail($body));
        return back()->with('status','Mail sent successfully');;
    }
```
Now create a simple form for sending mail. Open the `resources/views/con-form.blade.php` file and add the following code

```
    <body class="antialiased">
        <div
            class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <h2>Bacancy Technology Mail Sending Tutorials</h2>
                </div>
        
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
        
        
                            <div class="ml-12">
                                <form action="{{route('send.email')}}" method="POST">
                                    @csrf
                                    <h6>Enter Name</h6>
                                    <input style="background:DarkGrey; width:500px; height:35px" type="text" name="name" value="" />
                                    <br>
                                    <h6>Enter Email </h6>
                                    <input style="background:DarkGrey; width:500px; height:35px" type="email" name="email" id="email">
                                    <br><br><br>
                                    <input class="btn btn-dark btn-block" type="submit" value="submit" name="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="https://www.bacancytechnology.com/blog/wp-content/cache/min/1/aa9c6fe5ef823ec62d319148737249bd.js" data-minify="1" defer></script></body>


```

Now Create Body for the Mail so copy and past bellow code  `resources/views/emails/QBLabMail.blade.php` file

```
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
```

Now we will create a route for this function. Open the `routes/web.php` file and add the following code

```
    Route::get('/', function () {
        return view('con-from');
    });
    
    Route::post('/sendQbLabMail',[MailController::class,'sendMail'])->name('send.email');
```
