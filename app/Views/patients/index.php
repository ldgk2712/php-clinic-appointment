<div class="page-header">
    <div>
        <h1>Patient Management</h1>
        <p>Search, pagination and safe sort for clinic patients.</p>
    </div>
    <a class="btn btn-primary" href="/patients/create">+ Create Patient</a>
</div>

<form class="filter-box" method="get" action="/patients">
    <label for="q">Search</label>
    <input id="q" type="text" name="q" value="<?= e($q) ?>" placeholder="Name, email or phone">
    <input type="hidden" name="sort" value="<?= e($sort) ?>">
    <input type="hidden" name="direction" value="<?= e($direction) ?>">
    <button class="btn btn-dark" type="submit">Filter</button>
</form>

<p class="meta">Sort: <?= e($sort) ?> <?= e(strtoupper($direction)) ?> | Per page: <?= e($perPage) ?></p>

<table class="table">
    <thead>
    <tr>
        <th><a href="/patients?<?= e(query_string(['sort' => 'id', 'direction' => $direction === 'asc' ? 'desc' : 'asc', 'page' => 1])) ?>">ID</a></th>
        <th><a href="/patients?<?= e(query_string(['sort' => 'name', 'direction' => $direction === 'asc' ? 'desc' : 'asc', 'page' => 1])) ?>">Name</a></th>
        <th><a href="/patients?<?= e(query_string(['sort' => 'email', 'direction' => $direction === 'asc' ? 'desc' : 'asc', 'page' => 1])) ?>">Email</a></th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Status</th>
        <th>Created at</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($patients === []): ?>
        <tr><td class="empty" colspan="8">No patients found.</td></tr>
    <?php endif; ?>
    <?php foreach ($patients as $patient): ?>
        <tr>
            <td><?= e($patient['id']) ?></td>
            <td><?= e($patient['name']) ?></td>
            <td><?= e($patient['email']) ?></td>
            <td><?= e($patient['phone']) ?></td>
            <td><?= e($patient['gender']) ?></td>
            <td><span class="badge badge-<?= e($patient['status']) ?>"><?= e($patient['status']) ?></span></td>
            <td><?= e($patient['created_at']) ?></td>
            <td class="actions">
                <a class="btn btn-small" href="/patients/edit?id=<?= e($patient['id']) ?>">Edit</a>
                <form method="post" action="/patients/delete" onsubmit="return confirm('Delete this patient?');">
                    <input type="hidden" name="id" value="<?= e($patient['id']) ?>">
                    <button class="btn btn-small btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="pagination-row">
    <span>Showing page <?= e($page) ?> of <?= e($totalPages) ?>, total <?= e($total) ?> patients</span>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="/patients?<?= e(query_string(['page' => $page - 1])) ?>">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="<?= $i === $page ? 'active' : '' ?>" href="/patients?<?= e(query_string(['page' => $i])) ?>"><?= e($i) ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="/patients?<?= e(query_string(['page' => $page + 1])) ?>">Next</a>
        <?php endif; ?>
    </div>
</div>
