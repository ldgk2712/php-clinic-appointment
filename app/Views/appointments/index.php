<div class="page-header">
    <div>
        <h1>Appointment Management</h1>
        <p>Search by appointment code, patient name/email, department.</p>
    </div>
    <a class="btn btn-primary" href="/appointments/create">+ Create Appointment</a>
</div>

<form class="filter-box" method="get" action="/appointments">
    <label for="q">Search</label>
    <input id="q" type="text" name="q" value="<?= e($q) ?>" placeholder="Code, patient, email or department">
    <input type="hidden" name="sort" value="<?= e($sort) ?>">
    <input type="hidden" name="direction" value="<?= e($direction) ?>">
    <button class="btn btn-dark" type="submit">Filter</button>
</form>

<p class="meta">Sort: <?= e($sort) ?> <?= e(strtoupper($direction)) ?> | Per page: <?= e($perPage) ?></p>

<table class="table">
    <thead>
    <tr>
        <th><a href="/appointments?<?= e(query_string(['sort' => 'id', 'direction' => $direction === 'asc' ? 'desc' : 'asc', 'page' => 1])) ?>">ID</a></th>
        <th><a href="/appointments?<?= e(query_string(['sort' => 'appointment_code', 'direction' => $direction === 'asc' ? 'desc' : 'asc', 'page' => 1])) ?>">Code</a></th>
        <th><a href="/appointments?<?= e(query_string(['sort' => 'patient_name', 'direction' => $direction === 'asc' ? 'desc' : 'asc', 'page' => 1])) ?>">Patient</a></th>
        <th>Email</th>
        <th><a href="/appointments?<?= e(query_string(['sort' => 'appointment_date', 'direction' => $direction === 'asc' ? 'desc' : 'asc', 'page' => 1])) ?>">Date</a></th>
        <th>Department</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($appointments === []): ?>
        <tr><td class="empty" colspan="8">No appointments found.</td></tr>
    <?php endif; ?>
    <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td><?= e($appointment['id']) ?></td>
            <td><?= e($appointment['appointment_code']) ?></td>
            <td><?= e($appointment['patient_name']) ?></td>
            <td><?= e($appointment['patient_email']) ?></td>
            <td><?= e($appointment['appointment_date']) ?></td>
            <td><?= e($appointment['department']) ?></td>
            <td><span class="badge badge-<?= e($appointment['status']) ?>"><?= e($appointment['status']) ?></span></td>
            <td class="actions">
                <a class="btn btn-small" href="/appointments/edit?id=<?= e($appointment['id']) ?>">Edit</a>
                <form method="post" action="/appointments/delete" onsubmit="return confirm('Delete this appointment?');">
                    <input type="hidden" name="id" value="<?= e($appointment['id']) ?>">
                    <button class="btn btn-small btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="pagination-row">
    <span>Showing page <?= e($page) ?> of <?= e($totalPages) ?>, total <?= e($total) ?> appointments</span>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="/appointments?<?= e(query_string(['page' => $page - 1])) ?>">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="<?= $i === $page ? 'active' : '' ?>" href="/appointments?<?= e(query_string(['page' => $i])) ?>"><?= e($i) ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="/appointments?<?= e(query_string(['page' => $page + 1])) ?>">Next</a>
        <?php endif; ?>
    </div>
</div>
