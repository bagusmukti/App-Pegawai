<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Departemen</title>
</head>

<body>
    @extends('master')
    @section('title', 'Daftar Departemen Pegawai')
    @section('page-title', 'Daftar Departemen')
    @section('content')

        <h1 class="page-title">Daftar Departemen</h1>

        <div class="add-button-container">
            <a href="{{ route('departments.create') }}" class="btn btn-primary">Add Department</a>
        </div>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nama Departemen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $dep)
                    <tr>
                        <td>{{ $dep->nama_departemen }}</td>
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('departments.show', $dep->id) }}" class="action-link-detail">Detail</a> |
                                <a href="{{ route('departments.edit', $dep->id) }}" class="action-link-edit">Edit</a> |
                                <form action="{{ route('departments.destroy', $dep->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
</body>

</html>
