<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to A.Martínez Wrecker Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        .header {
            background-color: #0EA5E9;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to A.Martínez Wrecker Service</h1>
        </div>
        <div class="content">
            <p>Dear Employee {{ $user->name }},</p>
            <p>Welcome to the A.Martínez Wrecker Service website! Please find your username and password below. With
                this information, you'll be able to enter the system. Save the login information for the next time you
                use the system.</p>
            <p><strong>Username:</strong> {{ $user['user'] }}</p>
            <p><strong>Password:</strong> {{ $plainPassword }}</p>
            <p>Thanks,</p>
            <p>{{ config('app.name') }}</p>
        </div>
        <div class="footer">
            <p>Estimado Residente de {{ $user->name }},</p>
            <p>Bienvenido al website de A.Martínez Wrecker Service! Porfavor encuentre su nombre de usario y contrasena
                abajo. Con esta informacion podra entrar al sistema. Guarde su informacion de acceso para la proxima vez
                que use el sistema.</p>
            <p>Gracias</p>
        </div>

        <p>Your account has been successfully created. Here are your login details:</p>
        <ul>
            <li>Username: {{ $user->user }}</li>
            <li>Email: {{ $user->email }}</li>
            <li>Password: {{ $user->password }}</li>
        </ul>
        <p>Please keep this information safe and secure.</p>
        <p>Thank you for joining us!</p>
    </div>
</body>

</html>
