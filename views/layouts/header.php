<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?=base_url?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=base_url?>/assets/css/menu.css">
    <script type="text/javascript" src="<?=base_url?>/assets/js/menu.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/expensesModal.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/categoriesModal.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/budgetModal.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/expenses.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/categories.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/budget.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/alerts.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/amountSpentByMonthChart.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/amountSpentByCategoryChart.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

<!-- HEADER -->
<div class="relative bg-neutral-800">
    <div class="max-w-7xl mx-auto py-2 relative">
        <nav class="flex items-center justify-between h-14">
            <a class="text-white font-medium mx-5 hover:text-blue-100 text-2xl cursor-pointer" href="<?=base_url.'dashboard/index'?>">Expenses App</a>
            <div class="hidden md:flex items-center justify-around">
            <?php if(isset($_SESSION['login'])) : ?>
                <a href="<?=base_url.'dashboard/index'?>" class="nav-link">Inicio</a>
                <a href="<?=base_url.'category/index'?>" class="nav-link">Categorías</a>
                <a href="<?=base_url.'statics/index'?>" class="nav-link">Estadísticas</a>
                <a href="<?=base_url.'user/index'?>" class="nav-link">Cuenta</a>
                <a href="<?=base_url.'user/logout'?>" class="nav-link">Cerrar sesión</a>
            <?php endif; ?>
            </div>
            <div class="flex md:hidden">
                <i class="bi bi-list text-white text-3xl p-2 hover:text-blue-100 cursor-pointer" id="hamburguer"></i>
                <div class="hidden flex-col w-full min-h-screen overflow-hidden absolute bg-neutral-800 top-0 right-0 p-4 z-50 duration-100" id="items">
                    <div class="max-w-7xl mx-auto flex items-center justify-between w-full p-2">
                        <a class="flex items-center justify-start text-white" href="index.php">
                            <img src="assets/img/icon-light.svg" alt="" class="h-10 mr-4">
                            <span class="text-white font-semibold text-3xl tracking-wider hidden sm:block">Expenses App</span>
                            <span class="text-white font-semibold text-3xl tracking-wider sm:hidden">EApp</span>
                        </a>
                        <i class="bi bi-x-lg text-white text-3xl hover:text-blue-100 cursor-pointer" id="cross"></i>
                    </div>
                    <div class="flex flex-col w-full items-center justify-center" id="dropdown-menu-items">
                        <?php if(isset($_SESSION['login'])) : ?>
                            <a href="<?=base_url.'dashboard/index'?>" class="nav-link-responsive">Inicio</a>
                            <a href="<?=base_url.'category/index'?>" class="nav-link-responsive">Categorías</a>
                            <a href="<?=base_url.'statics/index'?>" class="nav-link-responsive">Estadísticas</a>
                            <a href="<?=base_url.'user/index'?>" class="nav-link-responsive">Cuenta</a>
                            <a href="<?=base_url.'user/logout'?>" class="nav-link-responsive">Cerrar sesión</a>
                        <?php else: ?>
                            <a href="<?=base_url.'user/login'?>" class="nav-link-responsive">Acceder</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>




