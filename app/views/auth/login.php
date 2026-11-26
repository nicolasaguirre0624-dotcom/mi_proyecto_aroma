<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión - Aroma</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            display: grid;
            min-height: 100vh;
            margin: 0;
            place-items: center;
            padding: 20px;
            background: #f5f4ef;
            color: #30352f;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .login-box {
            width: min(100%, 390px);
            padding: 32px;
            border: 1px solid #dedfd7;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 12px 34px rgb(39 48 39 / 9%);
        }

        .login-box h1 {
            margin: 0 0 24px;
            color: #354b3b;
            font-size: 1.8rem;
            letter-spacing: -0.04em;
        }

        .login-box label {
            display: flex;
            flex-direction: column;
            gap: 7px;
            margin-bottom: 17px;
            color: #596258;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .login-box input {
            width: 100%;
            min-height: 42px;
            padding: 9px 11px;
            border: 1px solid #cdd1c8;
            border-radius: 7px;
            color: #30352f;
            font: inherit;
        }

        .login-box input:focus {
            border-color: #48634f;
            outline: 3px solid rgb(72 99 79 / 15%);
        }

        .login-box button {
            width: 100%;
            min-height: 42px;
            padding: 9px 14px;
            border: 0;
            border-radius: 7px;
            background: #48634f;
            color: #fff;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .login-box button:hover {
            background: #354b3b;
        }

        .error {
            margin: 0 0 16px;
            color: #a64c42;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Iniciar sesión</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form action="<?= htmlspecialchars(APP_BASE_PATH . '/login?action=ingresar', ENT_QUOTES, 'UTF-8') ?>" method="POST">
            <label>
                Usuario
                <input type="text" name="usuario" required>
            </label>
            <label>
                Contraseña
                <input type="password" name="password" required>
            </label>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
