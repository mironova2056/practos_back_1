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

    .btn-sm {
        padding: 5px 10px;
        font-size: 13px;
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
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Добавить новую дисциплину</h4>
                    <a href="/practos_back_1/staff" class="btn btn-sm btn-secondary">Назад</a>
                </div>

                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <p><?= htmlspecialchars($error) ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_GET['success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_GET['success']) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <input type="hidden" name="create" value="1">
                        <div class="form-group">
                            <label>Название дисциплины</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Добавить дисциплину</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
