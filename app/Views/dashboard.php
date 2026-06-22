<section class="card hero">
    <h1>Lab05 - Clinic Appointment Database Management App</h1>
    <p class="subtitle">PDO + Repository + CRUD + Search/Pagination + Unique Constraint + Index</p>

    <div class="grid">
        <div class="feature card">
            <div class="icon">DB</div>
            <h3>Database</h3>
            <p>users / patients / appointments with utf8mb4, primary keys, unique keys and indexes.</p>
        </div>
        <div class="feature card">
            <div class="icon">PDO</div>
            <h3>PDO Repository</h3>
            <p>Prepared statements only. SQL stays inside repositories, not views.</p>
        </div>
        <div class="feature card">
            <div class="icon">PT</div>
            <h3>Patient CRUD</h3>
            <p>List, create, edit, update and delete patients. Duplicate email is handled clearly.</p>
        </div>
        <div class="feature card">
            <div class="icon">AP</div>
            <h3>Appointment CRUD</h3>
            <p>Manage appointment codes, dates and statuses with duplicate code prevention.</p>
        </div>
        <div class="feature card">
            <div class="icon">IX</div>
            <h3>Performance</h3>
            <p>Index + EXPLAIN + LIMIT/OFFSET with safe q/page/sort/direction.</p>
        </div>
    </div>

    <div class="flow">Main flow: Browser -> public/index.php -> Router -> Controller -> Repository -> PDO -> MySQL -> View/Redirect -> Browser</div>
</section>
