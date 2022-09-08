<?php 

    require __DIR__.'/vendor/autoload.php'; 
    use \App\Entity\Vaga;

    if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
        header('Location: index.php?status=error');
        exit;
    }

    $obVaga = Vaga::getVaga($_GET['id']);

    // validação da vaga
    if(!$obVaga instanceof Vaga){
        header('Location: index.php?status=error');
        exit;
    }

    if(isset($_POST['excluir'])){

        $obVaga->excluir();

        header('Location: index.php?status=success');
        exit;
    }

    include __DIR__.'/includes/header.php';
    include __DIR__.'/includes/confirmar.php';
    include __DIR__.'/includes/footer.php';