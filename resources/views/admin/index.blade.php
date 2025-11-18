<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Test</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;max-width:800px;margin:2rem auto}
        table{width:100%;border-collapse:collapse}
        th,td{border:1px solid #ddd;padding:.5rem;text-align:left}
        form.inline{display:inline}
    </style>
</head>
<body>
    <h1>Admin — Test</h1>

    <p>This is a minimal admin page for testing auth and your controllers. Use it to create and delete `cartas`.</p>

    <h2>Create</h2>
    <form method="POST" action="{{ route('admin.cartas.store') }}">
        @csrf
        <label>Nome: <input name="nome" required></label>
        <label>Desc: <input name="desc"></label>
        <label>Imagem: <input name="imagem"></label>
        <button type="submit">Create</button>
    </form>

    <h2>List</h2>
    <table>
        <thead><tr><th>ID</th><th>Nome</th><th>Desc</th><th>Imagem</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($cartas as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->nome }}</td>
                <td>{{ $c->desc }}</td>
                <td>{{ $c->imagem }}</td>
                <td>
                    <form class="inline" method="POST" action="{{ route('admin.cartas.destroy', $c) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete carta #{{ $c->id }}?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No cartas yet</td></tr>
        @endforelse
        </tbody>
    </table>

</body>
</html>
