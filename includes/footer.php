<?php
/**
 * Reusable Footer Template
 * Usage: <?php require_once __DIR__ . '/includes/footer.php'; ?>
 * Parameters (set before including):
 *   - $scripts: Array of additional script files to include (e.g., ['js/page.js'])
 *   - $inlineScript: Inline JavaScript code to include
 */
$scripts = $scripts ?? [];
$inlineScript = $inlineScript ?? '';
?>
    </main>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Action completed successfully</span>
    </div>

    <script src="js/app.js"></script>
    <script src="js/dashboard.js"></script>
    <?php foreach ($scripts as $script): ?>
    <script src="<?php echo htmlspecialchars($script); ?>"></script>
    <?php endforeach; ?>
    <?php if ($inlineScript): ?>
    <script>
        <?php echo $inlineScript; ?>
    </script>
    <?php endif; ?>
</body>
</html>