<section class="card error-page">
    <h1>Something went wrong</h1>
    <div class="alert error">
        Sorry, we could not process your request right now. Please try again later or contact the administrator.
    </div>
    <p>Production mode must not show SQLSTATE, database password, file path, or raw technical errors to users.</p>
    <?php if (!empty($debug) && isset($exception)): ?>
        <h3>Developer debug detail</h3>
        <pre class="debug"><?= e(get_class($exception) . ': ' . $exception->getMessage()) ?></pre>
    <?php endif; ?>
</section>
