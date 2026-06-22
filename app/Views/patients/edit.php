<div class="header-row">
    <div>
        <h1>Edit Patient</h1>
        <p class="subtitle">Submit by POST /patients/update. Success redirects to /patients.</p>
    </div>
</div>

<div class="form-grid">
    <form class="card form-card" method="post" action="/patients/update">
        <input type="hidden" name="id" value="<?= e(old($old, 'id')) ?>">
        <?php require __DIR__ . '/_form.php'; ?>
        <button class="btn" type="submit">Update Patient</button>
        <a class="btn secondary" href="/patients">Back to Patients</a>
    </form>
    <aside class="card req-list">
        <h3>Update flow</h3>
        <ul>
            <li>Read id from POST.</li>
            <li>Validate input.</li>
            <li>Repository prepared UPDATE.</li>
            <li>Catch duplicate email.</li>
            <li>Redirect after success.</li>
        </ul>
    </aside>
</div>
