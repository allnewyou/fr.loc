<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0,
        maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>500 - Server error</title>
</head>
<body>

<h1>500 - Server error</h1>

<?= $error ?? ''; ?> <!-- проверка наличия переменной $error, если её нет берём пустую строку -->

</body>
</html>