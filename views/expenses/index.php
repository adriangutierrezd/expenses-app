<?php require_once 'views/includes/alerts.php'; ?>
<h1 class="h1 mb-4">Gastos</h1>
<p>Estos son tus gastos del mes actual. También puedes añadir gastos nuevos o visualizar los gastos de un periodo personalizado.</p>
<!-- ADD EXPENSES BUTTON -->
<div class="flex items-center justify-start mt-6">
    <button type="button" class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm" onclick="toggleAddExpenseModal()">Añadir gasto</button>
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
<?php require_once 'views/includes/expense-controllers.php'; ?>
<?php include_once 'views/includes/add-expense-modal.php'; ?>
<div><a href="<?= base_url; ?>expense/recurrent" class="rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm mt-2">Gastos recurrentes</a></div>
</div>
</div>



<script type="text/javascript" src="<?=base_url?>/assets/js/expensesModal.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/expenses.js" defer></script>
<script type="text/javascript" src="<?=base_url?>/assets/js/filterExpenses.js" defer></script>

