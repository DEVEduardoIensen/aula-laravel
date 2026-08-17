<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>View de mensagem</h1>

    @if (isset($nome))
    <p>Tudo bem, {{ $nome }}, eu arrumei a view!!!</p>
    @elseif (isset($texto))
    <p>Mensagem: {{ $texto }}</p>
    @endif
   

</body>
</html>