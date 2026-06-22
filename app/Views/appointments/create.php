<div class="page-header">
    <div>
        <h1>Create Appointment</h1>
        <p>Submit by POST /appointments/store. Appointment code must be unique.</p>
    </div>
</div>

<?php if ($errors): ?>
    <div class="alert alert-danger">Please check the highlighted fields.</div>
<?php endif; ?>

<div class="form-grid">
    <form class="form-card" method="post" action="/appointments/store">
        <div class="form-row">
            <label>Appointment code</label>
            <input type="text" name="appointment_code" maxlength="50" required value="<?= e(old($data, 'appointment_code')) ?>" placeholder="APT-2026-0017">
            <?php if (isset($errors['appointment_code'])): ?><small class="error"><?= e($errors['appointment_code']) ?></small><?php endif; ?>
        </div>

        <div class="form-row">
            <label>Patient name</label>
            <input type="text" name="patient_name" maxlength="100" required value="<?= e(old($data, 'patient_name')) ?>">
            <?php if (isset($errors['patient_name'])): ?><small class="error"><?= e($errors['patient_name']) ?></small><?php endif; ?>
        </div>

        <div class="form-row">
            <label>Patient email</label>
            <input type="email" name="patient_email" maxlength="150" value="<?= e(old($data, 'patient_email')) ?>">
            <?php if (isset($errors['patient_email'])): ?><small class="error"><?= e($errors['patient_email']) ?></small><?php endif; ?>
        </div>

        <div class="form-row">
            <label>Appointment date</label>
            <input type="datetime-local" name="appointment_date" required value="<?= e(old($data, 'appointment_date')) ?>">
            <?php if (isset($errors['appointment_date'])): ?><small class="error"><?= e($errors['appointment_date']) ?></small><?php endif; ?>
        </div>

        <div class="form-row">
            <label>Department</label>
            <input type="text" name="department" maxlength="100" required value="<?= e(old($data, 'department')) ?>">
            <?php if (isset($errors['department'])): ?><small class="error"><?= e($errors['department']) ?></small><?php endif; ?>
        </div>

        <div class="form-row">
            <label>Status</label>
            <select name="status">
                <?php foreach (['scheduled', 'confirmed', 'completed', 'cancelled'] as $status): ?>
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
            <button class="btn btn-primary" type="submit">Save Appointment</button>
            <a class="btn" href="/appointments">Back to Appointments</a>
        </div>
    </form>

    <aside class="side-card">
        <h3>Appointment requirements</h3>
        <ul>
            <li>Appointment code is required and unique.</li>
            <li>Patient name and date are required.</li>
            <li>Duplicate code is caught by DB unique constraint.</li>
            <li>POST success redirects to the list page.</li>
        </ul>
    </aside>
</div>
