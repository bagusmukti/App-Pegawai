<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Departemen</title>
</head>
<body>
    <div>
        <h1>Daftar Departemen</h1>
        <a href="{{ route('departments.create') }}">Add Department</a>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Departemen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $dep)
                <tr>
                    <td>{{ $dep->nama_departemen }}</td>
                    <td>
                        <a href="{{ route('departments.show', $dep->id) }}">Detail</a> |
                        <a href="{{ route('departments.edit', $dep->id) }}">Edit</a> |
                        <form action="{{ route('departments.destroy', $dep->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                         </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>