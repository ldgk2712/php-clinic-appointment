<section class="panel">
    <h1>Something went wrong</h1>
    <p>Production mode không hiển thị SQLSTATE hoặc đường dẫn file cho người dùng.</p>

    <div class="alert alert-danger">
        <strong><?= e($message ?? 'Sorry, something went wrong.') ?></strong>
        <br>
        Please try again later or contact the administrator.
    </div>

    <div class="note-box">
        <strong>Developer note:</strong>
        Chi tiết lỗi được ghi vào <code>storage/logs/app.log</code>.
    </div>

    <?php if (!empty($debugMessage)): ?>
        <div class="note-box debug-box">
            <strong>Debug:</strong> <?= e($debugMessage) ?>
        </div>
    <?php endif; ?>
</section>
