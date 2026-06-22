<div class="header-row">
    <h1>Appointment Management</h1>
    <a class="btn" href="/appointments/create">+ Create Appointment</a>
</div>

<form class="panel searchbar" method="get" action="/appointments">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search code, patient name or email">
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
                <th><a href="/appointments?<?= e(query_string(['sort' => 'id', 'direction' => $nextDir, 'page' => 1])) ?>">ID</a></th>
                <th><a href="/appointments?<?= e(query_string(['sort' => 'appointment_code', 'direction' => $nextDir, 'page' => 1])) ?>">Code</a></th>
                <th><a href="/appointments?<?= e(query_string(['sort' => 'patient_name', 'direction' => $nextDir, 'page' => 1])) ?>">Patient</a></th>
                <th>Email</th>
                <th><a href="/appointments?<?= e(query_string(['sort' => 'appointment_date', 'direction' => $nextDir, 'page' => 1])) ?>">Appointment Date</a></th>
                <th><a href="/appointments?<?= e(query_string(['sort' => 'status', 'direction' => $nextDir, 'page' => 1])) ?>">Status</a></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= e((string) $appointment['id']) ?></td>
                    <td><?= e($appointment['appointment_code']) ?></td>
                    <td><?= e($appointment['patient_name']) ?></td>
                    <td><?= e($appointment['patient_email'] ?? '') ?></td>
                    <td><?= e($appointment['appointment_date']) ?></td>
                    <td><span class="badge <?= e($appointment['status']) ?>"><?= e($appointment['status']) ?></span></td>
                    <td class="actions">
                        <a class="btn small secondary" href="/appointments/edit?id=<?= e((string) $appointment['id']) ?>">Edit</a>
                        <form class="inline-form" method="post" action="/appointments/delete" onsubmit="return confirm('Delete this appointment?');">
                            <input type="hidden" name="id" value="<?= e((string) $appointment['id']) ?>">
                            <button class="btn small danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$appointments): ?>
                <tr><td colspan="7">No appointments found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="pagination">
    <div>Showing page <?= e((string) $page) ?> / <?= e((string) $totalPages) ?>, total <?= e((string) $total) ?> appointments.</div>
    <div class="page-links">
        <?php if ($page > 1): ?><a href="/appointments?<?= e(query_string(['page' => $page - 1])) ?>">Prev</a><?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i === $page): ?><span class="active"><?= $i ?></span><?php else: ?><a href="/appointments?<?= e(query_string(['page' => $i])) ?>"><?= $i ?></a><?php endif; ?>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?><a href="/appointments?<?= e(query_string(['page' => $page + 1])) ?>">Next</a><?php endif; ?>
    </div>
</div>
