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

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .table th {
        background-color: var(--light);
        font-weight: 600;
    }

    .table tr:hover {
        background-color: rgba(0,0,0,0.02);
    }

    .action-btns {
        display: flex;
        gap: 8px;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 13px;
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

    @media (max-width: 768px) {
        .staff-container {
            padding: 15px;
        }

        .form-row {
            flex-direction: column;
            gap: 15px;
        }

        .table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<div class="staff-container">
    <div class="page-header">
        <h1 class="page-title">Панель сотрудника деканата</h1>
    </div>

    <!-- Фильтры для данных -->
    <div class="section">
        <form method="get">
            <input type="hidden" name="index" value="1">
            <div class="form-row">
                <div class="form-group">
                    <label>Группа</label>
                    <select name="group_id" class="form-control">
                        <option value="">Все группы</option>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group->id_group ?>" <?= ($selectedGroupId ?? null) == $group->id_group ? 'selected' : '' ?>>
                                <?= htmlspecialchars($group->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Дисциплина</label>
                    <select name="discipline_id" class="form-control">
                        <option value="">Все дисциплины</option>
                        <?php foreach ($disciplines as $discipline): ?>
                            <option value="<?= $discipline->id_discipline ?>"
                                <?= ($selectedDisciplineId ?? '') == $discipline->id_discipline ? 'selected' : '' ?>>
                                <?= htmlspecialchars($discipline->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Курс</label>
                    <select name="course" class="form-control">
                        <option value="">Все курсы</option>
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <option value="<?= $i ?>" <?= ($selectedCourse ?? null) == $i ? 'selected' : '' ?>>
                                <?= $i ?> курс
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Семестр</label>
                    <select name="semester" class="form-control">
                        <option value="">Все семестры</option>
                        <?php for ($i = 1; $i <= 2; $i++): ?>
                            <option value="<?= $i ?>" <?= ($selectedSemester ?? null) == $i ? 'selected' : '' ?>>
                                <?= $i ?> семестр
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group" style="align-self: flex-end;">
                    <button type="submit" class="btn btn-primary">Применить</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Секция дисциплин -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Дисциплины</h2>
            <div class="action-btns">
                <a href="/practos_back_1/disciplines/create" class="btn btn-primary">Добавить дисциплину</a>
                <a href="/practos_back_1/disciplines/attach" class="btn btn-primary">Прикрепить к группе</a>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Группа</th>
                <th>Курс</th>
                <th>Семестр</th>
                <th>Часы</th>
                <th>Тип контроля</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($groupDisciplines)): ?>
                <?php foreach ($groupDisciplines as $gd): ?>
                    <tr>
                        <td><?= htmlspecialchars($gd->disciplines->name ?? '') ?></td>
                        <td><?= htmlspecialchars($gd->student_groups->name ?? '') ?></td>
                        <td><?= $gd->course ?></td>
                        <td><?= $gd->semester ?></td>
                        <td><?= $gd->hours ?></td>
                        <td><?= htmlspecialchars($gd->control_type->name ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Нет данных о дисциплинах</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
    <!-- Секция групп -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Группы</h2>
            <a href="/practos_back_1/groups/create" class="btn btn-primary">Добавить группу</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Кол-во студентов</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= htmlspecialchars($group->name) ?></td>
                    <td><?= $group->students()->count() ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Секция студентов -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Студенты</h2>
            <a href="/practos_back_1/students/create" class="btn btn-primary">Добавить студента</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>ФИО</th>
                <th>Группа</th>
                <th>Пол</th>
                <th>Дата рождения</th>
                <th>Адрес проживания</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student->surname . ' ' . $student->name . ' ' . $student->patronym) ?></td>
                        <td><?= htmlspecialchars($student->student_groups->name ?? 'Не указана') ?></td>
                        <td><?= htmlspecialchars($student->gender->name ?? '') ?></td>
                        <td><?= date('d.m.Y', strtotime($student->date_birth)) ?></td>
                        <td><?= htmlspecialchars($student->address) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Нет данных о студентах</p>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Секция успеваемости -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Успеваемость</h2>
            <a href="/practos_back_1/grades/create" class="btn btn-primary">Добавить оценку</a>
        </div>

        <?php if (!empty($grades)): ?>
            <table class="table">
                <thead>
                <tr>
                    <th>Студент</th>
                    <th>Дисциплина</th>
                    <th>Оценка</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($grades)): ?>
                    <?php foreach ($grades as $grade): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars(($grade->students->surname ?? '') . ' ' . ($grade->students->name ?? '')) ?>
                            </td>
                            <td><?= htmlspecialchars($grade->disciplines->name ?? 'Дисциплина не указана') ?></td>
                            <td><?= $grade->grade ?? 'Нет оценки' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">
                            Нет данных для отображения. Примените фильтры для просмотра успеваемости.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Нет данных для отображения. Примените фильтры для просмотра успеваемости.</p>
        <?php endif; ?>
    </div>
</div>