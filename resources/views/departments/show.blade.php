<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Departemen</title>
</head>
<body>
    <h1>Detail Departemen</h1>
    <table border="1" cellpadding="8" cellspacing="0">
         <tr>
            <th>Nama Departemen</th>
            <td>{{ $departments->nama_departemen }}</td>
        </tr>
    </table>
</body>
</html>