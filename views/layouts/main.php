<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Деканат | Учебный портал</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .user-greeting {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-greeting::before {
            content: "👤";
        }

        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            min-height: calc(100vh - 200px);
        }

        footer {
            background-color: var(--dark-color);
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .nav-links {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
            }

            .nav-links a {
                text-align: center;
                padding: 0.8rem;
            }
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="nav-links">
            <?php if (!app()->auth::check()): ?>
                <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <?php else: ?>
                <span class="user-greeting"><?= app()->auth::user()->name ?></span>
                <a href="<?= app()->route->getUrl('/logout') ?>" class="logout-btn">Выход</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main>
    <?= $content ?? '' ?>
</main>

<footer>
    <p>Учебный портал деканата &copy; <?= date('Y') ?></p>
</footer>
</body>
</html>