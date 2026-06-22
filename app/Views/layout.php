<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Clinic Appointment DB App') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<nav class="navbar">
    <div class="brand">Clinic Appointment DB App</div>
    <div class="nav-links">
        <a href="/">Dashboard</a>
        <a href="/patients">Patients</a>
        <a href="/patients/create">Create Patient</a>
        <a href="/appointments">Appointments</a>
        <a href="/appointments/create">Create Appointment</a>
        <a href="/health">Health</a>
    </div>
</nav>

<main class="container">
    <?php if ($message = flash_get('success')): ?>
        <div class="alert alert-success"><?= e($message) ?></div>
    <?php endif; ?>

    <?php if ($message = flash_get('error')): ?>
        <div class="alert alert-danger"><?= e($message) ?></div>
    <?php endif; ?>

    <?= $content ?>
</main>
</body>
</html>
