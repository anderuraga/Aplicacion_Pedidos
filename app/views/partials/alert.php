<?php
if ( isset($_SESSION['alert']) ) {
?>
    <div class="alert alert-<?= $_SESSION['alert']['tipo'] ?> alert-dismissible fade show" role="alert">
    <?= $_SESSION['alert']['mensaje'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?php 
    unset($_SESSION['alert']);
 } ?> 