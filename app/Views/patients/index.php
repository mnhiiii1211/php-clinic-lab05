<div class="header-row">
    <h1>Patient Management</h1>
    <a class="btn" href="/patients/create">+ Create Patient</a>
</div>

<form class="panel searchbar" method="get" action="/patients">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search name, email or phone">
    <input type="hidden" name="sort" value="<?= e($sort) ?>">
    <input type="hidden" name="direction" value="<?= e($direction) ?>">
    <span class="sort-note">Sort: <?= e($sort) ?> <?= strtoupper(e($direction)) ?></span>
    <button class="btn" type="submit">Filter</button>
</form>

<div class="card table-wrap">
    <table>
        <thead>
            <tr>
                <?php $nextDir = $direction === 'asc' ? 'desc' : 'asc'; ?>
                <th><a href="/patients?<?= e(query_string(['sort' => 'id', 'direction' => $nextDir, 'page' => 1])) ?>">ID</a></th>
                <th><a href="/patients?<?= e(query_string(['sort' => 'name', 'direction' => $nextDir, 'page' => 1])) ?>">Name</a></th>
                <th><a href="/patients?<?= e(query_string(['sort' => 'email', 'direction' => $nextDir, 'page' => 1])) ?>">Email</a></th>
                <th>Phone</th>
                <th><a href="/patients?<?= e(query_string(['sort' => 'gender', 'direction' => $nextDir, 'page' => 1])) ?>">Gender</a></th>
                <th><a href="/patients?<?= e(query_string(['sort' => 'created_at', 'direction' => $nextDir, 'page' => 1])) ?>">Created at</a></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= e((string) $patient['id']) ?></td>
                    <td><?= e($patient['name']) ?></td>
                    <td><?= e($patient['email']) ?></td>
                    <td><?= e($patient['phone'] ?? '') ?></td>
                    <td><span class="badge <?= e($patient['gender']) ?>"><?= e($patient['gender']) ?></span></td>
                    <td><?= e($patient['created_at']) ?></td>
                    <td class="actions">
                        <a class="btn small secondary" href="/patients/edit?id=<?= e((string) $patient['id']) ?>">Edit</a>
                        <form class="inline-form" method="post" action="/patients/delete" onsubmit="return confirm('Delete this patient?');">
                            <input type="hidden" name="id" value="<?= e((string) $patient['id']) ?>">
                            <button class="btn small danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$patients): ?>
                <tr><td colspan="7">No patients found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="pagination">
    <div>Showing page <?= e((string) $page) ?> / <?= e((string) $totalPages) ?>, total <?= e((string) $total) ?> patients.</div>
    <div class="page-links">
        <?php if ($page > 1): ?><a href="/patients?<?= e(query_string(['page' => $page - 1])) ?>">Prev</a><?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i === $page): ?><span class="active"><?= $i ?></span><?php else: ?><a href="/patients?<?= e(query_string(['page' => $i])) ?>"><?= $i ?></a><?php endif; ?>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?><a href="/patients?<?= e(query_string(['page' => $page + 1])) ?>">Next</a><?php endif; ?>
    </div>
</div>
