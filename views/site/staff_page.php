
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

    <!-- Секция групп -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Группы</h2>
            <a href="/groups/create" class="btn btn-primary">Добавить группу</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Курс</th>
                <th>Кол-во студентов</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= htmlspecialchars($group->name) ?></td>
                    <td><?= htmlspecialchars($group->course) ?></td>
                    <td><?= $group->students_count ?></td>
                    <td class="action-btns">
                        <a href="/groups/<?= $group->id ?>/edit" class="btn btn-sm btn-primary">Редактировать</a>
                        <a href="/groups/<?= $group->id ?>/students" class="btn btn-sm btn-primary">Студенты</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Секция студентов -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Студенты</h2>
            <a href="/students/create" class="btn btn-primary">Добавить студента</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>ФИО</th>
                <th>Группа</th>
                <th>Дата рождения</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student->full_name) ?></td>
                    <td><?= htmlspecialchars($student->group->name ?? 'Не указана') ?></td>
                    <td><?= date('d.m.Y', strtotime($student->birth_date)) ?></td>
                    <td class="action-btns">
                        <a href="/students/<?= $student->id ?>/edit" class="btn btn-sm btn-primary">Редактировать</a>
                        <a href="/students/<?= $student->id ?>/performance" class="btn btn-sm btn-primary">Успеваемость</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Секция дисциплин -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Дисциплины</h2>
        </div>

        <form method="get" action="/disciplines">
            <div class="form-row">
                <div class="form-group">
                    <label>Группа</label>
                    <select name="group_id" class="form-control">
                        <option value="">Все группы</option>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group->id ?>" <?= ($selectedGroupId ?? '') == $group->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($group->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Курс</label>
                    <select name="course" class="form-control">
                        <option value="">Все курсы</option>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <option value="<?= $i ?>" <?= ($selectedCourse ?? '') == $i ? 'selected' : '' ?>>
                                <?= $i ?> курс
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Семестр</label>
                    <select name="semester" class="form-control">
                        <option value="">Все семестры</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= ($selectedSemester ?? '') == $i ? 'selected' : '' ?>>
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
            <?php foreach ($disciplines as $discipline): ?>
                <tr>
                    <td><?= htmlspecialchars($discipline->name) ?></td>
                    <td><?= htmlspecialchars($discipline->group->name) ?></td>
                    <td><?= $discipline->course ?></td>
                    <td><?= $discipline->semester ?></td>
                    <td><?= $discipline->hours ?></td>
                    <td><?= $discipline->control_type ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Секция успеваемости -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Успеваемость</h2>
        </div>

        <form method="get" action="/performance">
            <div class="form-row">
                <div class="form-group">
                    <label>Группа</label>
                    <select name="group_id" class="form-control" id="group-select">
                        <option value="">Выберите группу</option>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group->id ?>" <?= ($selectedGroupId ?? '') == $group->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($group->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Студент</label>
                    <select name="student_id" class="form-control" id="student-select" <?= empty($selectedGroupId) ? 'disabled' : '' ?>>
                        <option value="">Выберите студента</option>
                        <?php if (!empty($studentsForGroup)): ?>
                            <?php foreach ($studentsForGroup as $student): ?>
                                <option value="<?= $student->id ?>" <?= ($selectedStudentId ?? '') == $student->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($student->full_name) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Дисциплина</label>
                    <select name="discipline_id" class="form-control">
                        <option value="">Все дисциплины</option>
                        <?php foreach ($disciplinesList as $discipline): ?>
                            <option value="<?= $discipline->id ?>" <?= ($selectedDisciplineId ?? '') == $discipline->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($discipline->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="align-self: flex-end;">
                    <button type="submit" class="btn btn-primary">Показать</button>
                </div>
            </div>
        </form>

        <?php if (!empty($performanceData)): ?>
            <table class="table">
                <thead>
                <tr>
                    <th>Студент</th>
                    <th>Дисциплина</th>
                    <th>Оценка</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($performanceData as $performance): ?>
                    <tr>
                        <td><?= htmlspecialchars($performance->student->full_name) ?></td>
                        <td><?= htmlspecialchars($performance->discipline->name) ?></td>
                        <td><?= $performance->grade ?? 'Нет оценки' ?></td>
                        <td><?= date('d.m.Y', strtotime($performance->date)) ?></td>
                        <td class="action-btns">
                            <a href="/performance/<?= $performance->id ?>/edit" class="btn btn-sm btn-primary">Изменить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Выберите параметры для просмотра успеваемости</p>
        <?php endif; ?>
    </div>
</div>

<script>
    // Динамическая загрузка студентов при выборе группы
    document.getElementById('group-select').addEventListener('change', function() {
        const groupId = this.value;
        const studentSelect = document.getElementById('student-select');

        if (groupId) {
            fetch(`/api/students?group_id=${groupId}`)
                .then(response => response.json())
                .then(data => {
                    studentSelect.innerHTML = '<option value="">Выберите студента</option>';
                    data.forEach(student => {
                        const option = document.createElement('option');
                        option.value = student.id;
                        option.textContent = student.full_name;
                        studentSelect.appendChild(option);
                    });
                    studentSelect.disabled = false;
                });
        } else {
            studentSelect.innerHTML = '<option value="">Выберите студента</option>';
            studentSelect.disabled = true;
        }
    });
</script>