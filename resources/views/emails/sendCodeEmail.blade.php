<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Código de Verificação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
            color: #111827;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: auto;
            text-align: center;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            margin-top: 20px;
            color: #2563eb;
            letter-spacing: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Olá, {{ $name }}!</h2>
        <p>Use o código abaixo para verificar seu e-mail:</p>
        <div class="code">{{ $code }}</div>
        <p>Este código é válido por 10 minutos.</p>
    </div>
</body>
</html>
