<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? $app['name'] ?? 'Lab05 Clinic App') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="/">Lab05 Clinic DB App</a>
        <nav class="nav">
            <a href="/">Dashboard</a>
            <a href="/patients">Patients</a>
            <a href="/patients/create">Create Patient</a>
            <a href="/appointments">Appointments</a>
            <a href="/appointments/create">Create Appointment</a>
            <a href="/health">Health</a>
        </nav>
    </header>
    <main class="container">
        <?php if ($message = flash_get('success')): ?>
            <div class="alert success"><?= e($message) ?></div>
        <?php endif; ?>
        <?= $content ?>
    </main>
</body>
</html>
