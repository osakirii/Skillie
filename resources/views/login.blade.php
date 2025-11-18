<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f7f7f8;color:#111}
        .container{max-width:420px;margin:6rem auto;padding:2rem;background:#fff;border:1px solid #e6e6e6;border-radius:6px}
        label{display:block;font-weight:600;margin-top:1rem}
        input[type=text],input[type=password],input[type=email]{width:100%;padding:.5rem;border:1px solid #ddd;border-radius:4px;margin-top:.25rem}
        .actions{margin-top:1rem;display:flex;justify-content:space-between;align-items:center}
        button{background:#0ea5a4;color:#fff;border:0;padding:.5rem 1rem;border-radius:4px;cursor:pointer}
        .error{background:#fee2e2;color:#b91c1c;padding:.5rem;border-radius:4px;margin-top:.5rem}
        .small{font-size:.9rem;color:#555}
    </style>
    </head>
<body>

    <div class="container">
        <h1 style="margin:0 0 0.5rem 0">Login</h1>
        <p class="small">Bem-vindo de volta — entre com sua conta.</p>

        @if(session('status'))
            <div class="error">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />

            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" />

            <div style="margin-top:.5rem">
                <label style="font-weight:400"><input type="checkbox" name="remember"> Lembrar-me</label>
            </div>

            <div class="actions">
                <div class="small">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
                    @endif
                </div>
                <button type="submit">Entrar</button>
            </div>
        </form>

        @if (Route::has('register'))
            <p class="small" style="margin-top:1rem">Não tem conta? <a href="{{ route('register') }}">Registre-se</a></p>
        @endif
    </div>

</body>
</html>