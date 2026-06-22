<div class="header-row">
    <div>
        <h1>Create Appointment</h1>
        <p class="subtitle">Submit by POST /appointments/store. Success redirects to /appointments.</p>
    </div>
</div>

<div class="form-grid">
    <form class="card form-card" method="post" action="/appointments/store">
        <?php require __DIR__ . '/_form.php'; ?>
        <button class="btn" type="submit">Save Appointment</button>
        <a class="btn secondary" href="/appointments">Back to Appointments</a>
    </form>
    <aside class="card req-list">
        <h3>Appointment form requirements</h3>
        <ul>
            <li>Validate code, patient name, appointment date and status.</li>
            <li>Repository uses prepared INSERT.</li>
            <li>Duplicate code is caught by unique_appointment_code.</li>
            <li>Friendly error appears near appointment_code.</li>
            <li>PRG after success.</li>
        </ul>
    </aside>
</div>
