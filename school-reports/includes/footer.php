<script src="/mkkschool-new/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/mkkschool-new/assets/libs/simplebar/simplebar.min.js"></script>
<!-- <script src="/mkkschool-new/assets/libs/apexcharts/apexcharts.min.js"></script> -->
<script src="/mkkschool-new/assets/data/stock-prices.js"></script>
<!-- <script src="/mkkschool-new/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
<script src="/mkkschool-new/assets/libs/jsvectormap/maps/world.js"></script> -->
<script src="/mkkschool-new/assets/js/pages/index.init.js"></script>
<script src="/mkkschool-new/assets/js/app.js"></script>
<!-- <footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Computer Center Management System. All rights reserved.</p>
</footer> -->

<?php if (!empty($modal_body)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure Bootstrap's Modal is available
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var msgModalEl = document.getElementById('messageModal');
                var msgModal = new bootstrap.Modal(msgModalEl, {
                    keyboard: true,
                    backdrop: 'static'
                });
                msgModal.show();
            } else {
                // fallback: simple alert (if Bootstrap JS not loaded)
                <?php if ($modal_type === 'error'): ?>
                    alert("<?php echo addslashes(strip_tags($modal_body)); ?>");
                <?php else: ?>
                    alert("<?php echo addslashes(strip_tags($modal_body)); ?>");
                <?php endif; ?>
            }
        });
    </script>
<?php endif; ?>