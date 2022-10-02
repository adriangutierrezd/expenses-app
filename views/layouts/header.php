<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?=base_url?>/assets/css/styles.css">
    <script type="text/javascript" src="<?=base_url?>/assets/js/alerts.js" defer></script>
    <script type="text/javascript" src="<?=base_url?>/assets/js/utils.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<!-- HEADER -->
<div class="relative bg-white md:grid md:grid-cols-6 w-full">
    <!-- MENU -->
    <div class="hidden md:block relative bg-gray-100 col-span-2 xl:col-span-1 border-r border-r-gray-300 h-screen overflow-hidden p-8">
        <div class="flex flex-col items-start justify-between min-h-full">
            <!-- ITEMS -->
                <div class="flex flex-col items-start justify-start w-full">
                    <span class="text-2xl font-semibold mb-6">Expenses App</span>
                    <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/dashboard/index' ? 'bg-gray-200' : ''); ?> nav-link" href="<?=base_url.'dashboard/index'?>">
                        <i class="bi bi-house mr-4"></i>
                        <span>Inicio</span>
                    </a>

                    <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/category/index' ? 'bg-gray-200' : ''); ?> nav-link" href="<?=base_url.'category/index'?>">
                        <i class="bi bi-archive mr-4"></i>
                        <span>Categorías</span>
                    </a>

                    <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/statics/index' ? 'bg-gray-200' : ''); ?> nav-link" href="<?=base_url.'statics/index'?>">
                        <i class="bi bi-bar-chart-line mr-4"></i>
                        <span>Estadísticas</span>
                    </a>

                    <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/expense/index' ? 'bg-gray-200' : ''); ?> nav-link" href="<?=base_url.'expense/index'?>">
                    <i class="bi bi-currency-euro mr-4"></i>
                        <span>Gastos</span>
                    </a>

                    <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/expense/recurrent' ? 'bg-gray-200' : ''); ?> nav-link" href="<?=base_url.'expense/recurrent'?>">
                    <i class="bi bi-arrow-clockwise mr-4"></i>
                        <span>Gastos recurrentes</span>
                    </a>

                </div>
            <!-- ACCOUNT -->
                <div class="border-t border-t-gray-400 w-full">
                    <div class="flex flex-col items-start justify-between w-full">
                        <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/user/index' ? 'bg-gray-200' : ''); ?> flex items-center justify-start w-full text-lg p-2 hover:bg-gray-200 rounded-md font-medium duration-100 my-4" href="<?=base_url.'user/index'?>">
                            <i class="bi bi-person mr-4"></i>
                            <span>Configuración</span>
                        </a>
                        <a class="flex items-center justify-end text-md p-2 hover:bg-gray-200 rounded-md duration-100 ml-auto" href="<?=base_url.'user/logout'?>">
                            <span class="mr-4">Cerrar sesión</span>
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    </div>
                </div>
        </div>
    </div>

    <!-- RESPONSIVE MENU -->
    <div class="bg-gray-100 border-t border-t-gray-200 z-10 fixed bottom-0 left-0 right-0 flex items-center justify-between px-1 py-2 md:hidden">
        <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/dashboard/index' ? 'bg-gray-200' : ''); ?> nav-link-responsive" href="<?=base_url.'dashboard/index'?>">
            <i class="bi bi-house"></i>
            <span>Inicio</span>
        </a>
        <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/category/index' ? 'bg-gray-200' : ''); ?> nav-link-responsive" href="<?=base_url.'category/index'?>">
            <i class="bi bi-archive"></i>
            <span>Catgs</span>
        </a>
        <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/statics/index' ? 'bg-gray-200' : ''); ?> nav-link-responsive" href="<?=base_url.'statics/index'?>">
            <i class="bi bi-bar-chart-line"></i>
            <span>Estats.</span>
        </a>

        <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/expense/index' ? 'bg-gray-200' : ''); ?> nav-link-responsive" href="<?=base_url.'expense/index'?>">
            <i class="bi bi-currency-euro"></i>
            <span>Gastos</span>
        </a>

        <a class="<?php echo ($_SERVER["REQUEST_URI"] == '/expenses-app/user/index' ? 'bg-gray-200' : ''); ?> nav-link-responsive" href="<?=base_url.'user/index'?>">
            <i class="bi bi-person"></i>
            <span>Cuenta</span>
        </a>
    </div>
    <!-- CONTENT -->
    <div class="md:col-span-4 xl:col-span-5 md:h-screen md:overflow-y-auto">
    <?php if(isset($_SESSION['login'])) require_once 'views/includes/budgetModals.php'; ?> 
        <div class="p-8" style="padding-bottom: 3rem;">