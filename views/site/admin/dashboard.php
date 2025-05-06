<style>
    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1, h2 {
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 25px;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #34495e;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #dfe6e9;
        border-radius: 6px;
        font-size: 16px;
        transition: border 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #3498db;
        outline: none;
    }

    .error {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        border: none;
    }

    .btn-primary {
        background: #3498db;
        color: white;
    }

    .btn-primary:hover {
        background: #2980b9;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 14px;
    }

    .btn-danger {
        background: #e74c3c;
        color: white;
    }

    .btn-danger:hover {
        background: #c0392b;
    }

    .alert {
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
    }

    .user-table th, .user-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #dfe6e9;
    }

    .user-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #2c3e50;
    }

    .user-table tr:hover {
        background: #f8f9fa;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }
</style>

<div class="admin-container">
    <h1>Панель администратора</h1>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Добавить нового пользователя</h2>

        <form method="post">
            <input type="hidden" name="createUser" value="1">

            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" required placeholder="Введите логин">
                <?php if (isset($errors['login'])): ?>
                    <span class="error"><?= $errors['login'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required placeholder="Введите пароль">
                <?php if (isset($errors['password'])): ?>
                    <span class="error"><?= $errors['password'] ?></span>
                <?php endif; ?>
            </div>


            <div class="form-group">
                <label>Роль</label>
                <select name="id_role" required>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role->id ?>"><?= $role->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Добавить пользователя</button>
        </form>
    </div>

    <div class="card">
        <h2>Список пользователей</h2>

        <table class="user-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Логин</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id_user ?></td>
                    <td><?= $user->login ?></td>
                    <td><?= $user->id_role?></td>
                    <td class="action-buttons">
                        <a href="/admin/edit/<?= $user->id_user ?>" class="btn btn-sm">Редактировать</a>
                        <a href="/admin/delete/<?= $user->id_user ?>" class="btn btn-sm btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>