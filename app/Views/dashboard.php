<section class="hero">
    <h1>Lab05 - Clinic Appointment Management App</h1>
    <p>PDO + Repository + CRUD + Search/Pagination + Unique + Index</p>
</section>

<div class="cards">
    <div class="card">
        <div class="icon">{}</div>
        <h3>Database</h3>
        <p>users / patients / appointments with utf8mb4, constraints and indexes.</p>
    </div>
    <div class="card">
        <div class="icon purple">{}</div>
        <h3>PDO Repository</h3>
        <p>Prepared statements, no SQL string concat from user input.</p>
    </div>
    <div class="card">
        <div class="icon green">{}</div>
        <h3>Patient CRUD</h3>
        <p>List, create, edit, delete, search and duplicate email handling.</p>
    </div>
    <div class="card">
        <div class="icon orange">{}</div>
        <h3>Appointment CRUD</h3>
        <p>Unique appointment code, appointment date, status and pagination.</p>
    </div>
    <div class="card">
        <div class="icon red">{}</div>
        <h3>Performance</h3>
        <p>Safe sort whitelist, LIMIT/OFFSET and EXPLAIN-ready indexes.</p>
    </div>
</div>

<div class="flow-box">
    <strong>Main flow:</strong>
    Browser -> public/index.php -> Router -> Controller -> Repository -> PDO -> MySQL -> View/Redirect -> Browser
</div>
