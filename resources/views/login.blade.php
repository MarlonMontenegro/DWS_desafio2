<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Finanzas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top left, #4b6cb7 0, #182848 40%, #020817 100%);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            margin: 0;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 1.5rem;
            border: none;
            box-shadow: 0 18px 45px rgba(0,0,0,.45);
            backdrop-filter: blur(18px);
            background: rgba(9,9,15,.98);
            color: #e5e7eb;
            padding: 1.75rem 1.75rem 1.5rem;
        }
        .login-title {
            font-weight: 600;
            color: #38bdf8;
        }
        .subtitle {
            font-size: .8rem;
            color: #9ca3af;
        }
        .form-label {
            font-size: .85rem;
            color: #9ca3af;
        }
        .form-control {
            background-color: #020817;
            border-color: #111827;
            color: #e5e7eb;
            font-size: .9rem;
        }
        .form-control::placeholder {
            color: #6b7280;
        }
        .form-control:focus {
            background-color: #020817;
            color: #e5e7eb;
            border-color: #38bdf8;
            box-shadow: 0 0 0 0.15rem rgba(56,189,248,.25);
        }
        .btn-login {
            background: linear-gradient(90deg, #4b6cb7, #38bdf8);
            border: none;
            font-weight: 600;
            font-size: .95rem;
        }
        .btn-login:hover {
            opacity: .95;
        }
        .helper {
            font-size: .75rem;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-3">
            <h4 class="login-title mb-1">Finanzas</h4>
            <div class="subtitle">Panel de Entradas, Salidas y Balance</div>
        </div>

        @if ($errors->has('login_error'))
            <div class="alert alert-danger py-2 mb-3">
                {{ $errors->first('login_error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success py-2 mb-3">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}" class="mt-2">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', 'admin@example.com') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    value="123456"
                    required
                >
            </div>

            <button type="submit" class="btn btn-login w-100 mt-1">
                Iniciar sesión
            </button>

            <div class="text-center mt-3">
                <div class="helper">
                    Credenciales de prueba:<br>
                    <strong>admin@example.com</strong> / <strong>123456</strong>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
