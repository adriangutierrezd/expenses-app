<?php 
    require_once 'helpers/Utils.php';
    require_once 'helpers/form.php';
?>

<!-- CONTENT -->
<div>
<h1 class="h1">Estadísticas</h1>


<?php require_once 'views/includes/alerts.php'; ?>

<div class="my-4">
    <h2 class="h2">Resultados de los últimos meses</h2>
    <div class="flex flex-col shadow-xl w-full border border-gray-100 rounded-lg my-8">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden ">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mes</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Presupuesto</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gastado</th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ahorro</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="resultsContainer">
                </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>
</div>


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
<div class="my-4">
    <h2 class="h2">Gasto desagregado por categoría:</h2>
    <canvas id="categoryChart" width="1250" height="600"></canvas>
</div>

<div class="my-4">
    <h2 class="h2">Gasto desagregado por mes en los últimos 12 meses:</h2>
    <canvas id="monthlyChart" width="1250" height="600"></canvas>
</div>



</div>
</div>

<script type="text/javascript" src="<?=base_url?>/assets/js/results.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/amountSpentByMonthChart.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/amountSpentByCategoryChart.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/filterExpenses.js" defer></script>