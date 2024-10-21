<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One-Time Password (OTP) MIS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <style>
        body {
            margin: 0;
            font-family: Poppins, Helvetica, "sans-serif";
            font-size: 1.2rem;
            font-weight: 400;
            line-height: 1.5;
            color: #3F4254;
            text-align: left;
            background-color: #ffffff;
        }

        .p-5 {
            padding: 3rem;
        }
    </style>
</head>
<body>

    <div class="p-5">
        <img src="{{ url('assets/media/logos/dole_logo_more_than_jobs.png') }}" style="height: 84px;" />

        <br>
    
        <div style="margin-top: 3rem;">
            <p style="font-size: 1.2rem;">
                <span style="font-size: 1.3rem; font-weight: 600;">Hi {{ $name }},</span>

                <br><br>

                Greetings! We are excited to have you onboard. 
                
                <br><br>
                
                To complete your login request and ensure the security of your account, we have sent you a One-Time Password (OTP) verification code. This code will expire in (5) five minutes, so please act promptly. 
                
                <br><br>
                
                OTP Code: <b style="letter-spacing: 15px; font-size: 1.6rem; margin-left: 10px;">{{ $otpCode }}</b>
                
                <br><br>
                
                Please use this code on the login authentication page to confirm your account. If you did not initiate this process, kindly ignore this email or get in touch with our IT support team. 
                
                <br><br><br><br>
                
                Thank you.
            </p>
        </div>
    </div>

</body>
</html>