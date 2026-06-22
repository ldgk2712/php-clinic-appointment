<div class="page-header">
    <div>
        <h1>Edit Patient #<?= e($data['id']) ?></h1>
        <p>Submit by POST /patients/update. On success, redirect to /patients.</p>
    </div>
</div>

<?php if ($errors): ?>
    <div class="alert alert-danger">Please check the highlighted fields.</div>
<?php endif; ?>

<form class="form-card" method="post" action="/patients/update">
    <input type="hidden" name="id" value="<?= e($data['id']) ?>">

    <div class="form-row">
        <label>Name</label>
        <input type="text" name="name" maxlength="100" required value="<?= e(old($data, 'name')) ?>">
        <?php if (isset($errors['name'])): ?><small class="error"><?= e($errors['name']) ?></small><?php endif; ?>
    </div>

    <div class="form-row">
        <label>Email</label>
        <input type="email" name="email" maxlength="150" required value="<?= e(old($data, 'email')) ?>">
        <?php if (isset($errors['email'])): ?><small class="error"><?= e($errors['email']) ?></small><?php endif; ?>
    </div>

    <div class="form-row">
        <label>Phone</label>
        <input type="text" name="phone" maxlength="20" value="<?= e(old($data, 'phone')) ?>">
        <?php if (isset($errors['phone'])): ?><small class="error"><?= e($errors['phone']) ?></small><?php endif; ?>
    </div>

    <div class="form-row">
        <label>Gender</label>
        <select name="gender">
            <?php foreach (['male', 'female', 'other'] as $gender): ?>
                <option value="<?= e($gender) ?>" <?= old($data, 'gender') === $gender ? 'selected' : '' ?>><?= e($gender) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['gender'])): ?><small class="error"><?= e($errors['gender']) ?></small><?php endif; ?>
    </div>

    <div class="form-row">
        <label>Status</label>
        <select name="status">
            <?php foreach (['active', 'inactive'] as $status): ?>
                <option value="<?= e($status) ?>" <?= old($data, 'status') === $status ? 'selected' : '' ?>><?= e($status) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['status'])): ?><small class="error"><?= e($errors['status']) ?></small><?php endif; ?>
    </div>

    <div class="form-row">
        <label>Note</label>
        <textarea name="note" rows="3"><?= e(old($data, 'note')) ?></textarea>
        <?php if (isset($errors['note'])): ?><small class="error"><?= e($errors['note']) ?></small><?php endif; ?>
    </div>

    <div class="form-actions">
        <button class="btn btn-primary" type="submit">Update Patient</button>
        <a class="btn" href="/patients">Back to Patients</a>
    </div>
</form>
