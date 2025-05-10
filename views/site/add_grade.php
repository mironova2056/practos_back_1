<style>
    :root {
        --primary: #3498db;
        --secondary: #2c3e50;
        --success: #27ae60;
        --danger: #e74c3c;
        --light: #ecf0f1;
        --dark: #34495e;
        --white: #fff;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f5f7fa;
        color: var(--dark);
        line-height: 1.6;
    }

    .staff-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #ddd;
    }

    .page-title {
        font-size: 24px;
        color: var(--secondary);
    }

    .section {
        background: var(--white);
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 30px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .section-title {
        font-size: 18px;
        color: var(--secondary);
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background: #2980b9;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }

    .form-group {
        flex: 1;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    select.form-control {
        height: 36px;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    @media (max-width: 768px) {
        .staff-container {
            padding: 15px;
        }

        .form-row {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>
<div class="staff-container">
    <div class="page-header">
        <h1 class="page-title">Добавление новой оценки</h1>
    </div>

    <div class="section">
        <!-- Вывод сообщений об ошибках -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Вывод сообщений об успехе -->
        <?php if (!empty($_GET['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <!-- Форма добавления оценки -->
        <form method="post">
            <input type="hidden" name="create" value="1">
            <div class="form-row">
                <div class="form-group">
                    <label>Студент</label>
                    <select class="form-control" name="id_student" required>
                        <option value="">Выберите студента</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student->id_student ?>">
                                <?= htmlspecialchars($student->surname . ' ' . $student->name) ?>
                                (Группа: <?= htmlspecialchars($student->student_groups->name ?? 'Не указана') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Дисциплина</label>
                    <select class="form-control" name="id_discipline" required>
                        <option value="">Выберите дисциплину</option>
                        <?php foreach ($disciplines as $discipline): ?>
                            <option value="<?= $discipline->id_discipline ?>">
                                <?= htmlspecialchars($discipline->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Оценка</label>
                    <select class="form-control" name="grade" required>
                        <option value="">Выберите оценку</option>
                        <option value="5">5 (Отлично)</option>
                        <option value="4">4 (Хорошо)</option>
                        <option value="3">3 (Удовлетворительно)</option>
                        <option value="2">2 (Неудовлетворительно)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Дата оценки</label>
                    <input type="date" class="form-control" name="date"
                           value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Добавить оценку</button>
                <a href="/practos_back_1/staff" class="btn">Отмена</a>
            </div>
        </form>
    </div>
</div>