<div class="header-row">
    <div>
        <h1>Create Patient</h1>
        <p class="subtitle">Submit by POST /patients/store. Success redirects to /patients.</p>
    </div>
</div>

<div class="form-grid">
    <form class="card form-card" method="post" action="/patients/store">
        <?php require __DIR__ . '/_form.php'; ?>
        <button class="btn" type="submit">Save Patient</button>
        <a class="btn secondary" href="/patients">Back to Patients</a>
    </form>
    <aside class="card req-list">
        <h3>Patient form requirements</h3>
        <ul>
            <li>Validate required fields.</li>
            <li>Email format must be valid.</li>
            <li>Repository uses prepared INSERT.</li>
            <li>Duplicate email is caught by unique_patient_email.</li>
            <li>PRG after success.</li>
            <li>Keep old data when validation fails.</li>
        </ul>
    </aside>
</div>
