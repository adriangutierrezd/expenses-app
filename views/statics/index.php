<?php 
    require_once 'helpers/Utils.php';
    require_once 'helpers/form.php';
?>

<!-- CONTENT -->
<div class="max-w-7xl mx-auto my-6 px-4">
<h1 class="h1">Estadísticas</h1>


<?php require_once 'views/includes/alerts.php'; ?>

<!-- FILTERS -->
<div class="my-8" id="filterContainer">
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <div class="form-group">
            <label for="start-date" class="form-label">Inicio</label>
            <input type="date" name="start-date" id="start-date" class="form-control">
        </div>
        <div class="form-group">
            <label for="end-date" class="form-label">Fin</label>
            <input type="date" name="end-date" id="end-date" class="form-control">
        </div>
        <button id="filterBtn" class="col-span-2 sm:col-span-1 h-9 self-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm mt-2">Filtrar</button>
        </div>
</div>

<!-- GRAPHS -->
<h2 class="h2">Gasto desagregado por categoría:</h2>
<canvas id="categoryChart" width="1250" height="600"></canvas>


<?php require_once 'views/includes/expense-controllers.php'; ?>

<h2 class="h2">Gasto desagregado por mes en los últimos 12 meses:</h2>
<canvas id="monthlyChart" width="1250" height="600"></canvas>

