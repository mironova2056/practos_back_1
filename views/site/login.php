<div style="max-width: 400px; margin: 50px auto; padding: 30px; background: #ffffff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; margin-bottom: 25px; color: #2c3e50; font-size: 24px;">Авторизация</h2>

    <?php if ($message ?? false): ?>
        <div style="color: #e74c3c; margin-bottom: 20px; padding: 10px; background: #fdecea; border-radius: 5px; text-align: center;">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <?php if (app()->auth->user()->name ?? false): ?>
        <div style="color: #27ae60; margin-bottom: 20px; padding: 10px; background: #e8f5e9; border-radius: 5px; text-align: center;">
            Добро пожаловать, <?= app()->auth->user()->name ?>
        </div>
    <?php endif; ?>

    <?php if (!app()->auth::check()): ?>
        <form method="post" style="display: flex; flex-direction: column; gap: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; color: #34495e; font-weight: 500;">Логин</label>
                <input type="text" name="login" style="width: 100%; padding: 12px; border: 1px solid #dfe6e9; border-radius: 6px; font-size: 16px; transition: border 0.3s;" placeholder="Введите логин">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; color: #34495e; font-weight: 500;">Пароль</label>
                <input type="password" name="password" style="width: 100%; padding: 12px; border: 1px solid #dfe6e9; border-radius: 6px; font-size: 16px; transition: border 0.3s;" placeholder="Введите пароль">
            </div>

            <button type="submit" style="background: #2c3e50; color: white; padding: 14px; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; transition: background 0.3s; font-weight: 500;">
                Войти
            </button>
        </form>
    <?php endif; ?>
</div>