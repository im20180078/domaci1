<?php
    include 'inc/header.php';

    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');
        exit();
    }

?>

<div class="text-center">
    <h1 class="display-4">WELCOME</h1>
    <img src="img/watched.jpg" alt="pocetna" class="img-responsive" width="700"/>
</div>

<?php
    include 'inc/footer.php';
?>