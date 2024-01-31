<?php
if (isset($_SESSION['success_message'])) { ?>
<div class="alert alert-danger">
    <?= $_SESSION['success_message'] ?>
</div>
<?php
    unset($_SESSION['success_message']);
}
?>
