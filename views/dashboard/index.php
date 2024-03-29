<?php 
require_once 'helpers/Utils.php';
require_once 'helpers/form.php';
require_once 'controllers/DashboardController.php'; 
?>




<!-- CONTENT -->
<div>

<h1 class="h1">Resumen del mes:</h1>

<?php require_once 'views/includes/alerts.php'; ?>

<div id="budgetStats">
  <?php require_once 'views/includes/budget-controllers.php'; ?>
</div>

<!-- ADD EXPENSES BUTTON -->
<div class="my-8 flex items-center justify-end">
    <button type="button" class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="toggleAddExpenseModal()">Añadir gasto</button>
</div>

<!-- GRAPHS -->
<canvas id="categoryChart" width="1250" height="600"></canvas>

<?php include_once 'views/includes/add-expense-modal.php'; ?>
<?php require_once 'views/includes/expense-controllers.php'; ?>

</div>
</div>
<script type="text/javascript" src="<?=base_url?>/assets/js/expensesModal.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/budgetModal.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/expenses.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/budget.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/amountSpentByCategoryChart.js" defer></script>
