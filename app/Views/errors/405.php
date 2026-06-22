<section class="panel">
    <h1>405 Method Not Allowed</h1>
    <p>URL này có tồn tại nhưng bạn gọi sai HTTP method.</p>
    <?php if (!empty($allowedMethods)): ?>
        <p>Allowed: <?= e(implode(', ', $allowedMethods)) ?></p>
    <?php endif; ?>
    <a class="btn" href="/">Back to Dashboard</a>
</section>
