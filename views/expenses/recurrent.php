<?php require_once 'views/includes/alerts.php'; ?>
<h1 class="h1 mb-4">Gastos recurrentes</h1>
<p>Aquí puedes gestionar los gastos que tienes todos los meses, como el alquiler, la factura del Internet o Netflix.</p>


<!-- CREATE EXPENSES -->
<div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl w-full border border-gray-100 my-8">
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                <!-- Heroicon name: outline/exclamation -->
                <i class="bi bi-coin text-blue-700"></i>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Añadir gasto recurrente</h3>
                <div class="mt-2 flex flex-row w-full">
                    <div class="form-group mr-2 w-full">
                        <label class="form-label" for="name">Descripción:</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="error-alert" id="error-name"></span>
                    </div>
                    <div class="form-group ml-2 w-full">
                        <label class="form-label" for="amount">Importe:</label>
                        <input type="number" name="amount" id="amount" class="form-control">
                        <span class="error-alert" id="error-amount"></span>
                    </div>
                </div>
                <div class="form-group w-full">
                    <label class="form-label" for="amount">Categoría:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="0" disabled selected>Selecciona una categoría</option>
                        <?php foreach($categories as $category) : ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="error-alert" id="error-category"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button id="createCategoryBtn" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="createRecurrentExpense()">Añadir</button>
    </div>
</div>

<!-- MANAGE EXPENSES -->
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Importe</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="recurrentContainer" class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- EDIT EXPENSE -->
<div class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title-edit" role="dialog" aria-modal="true" id="editModal">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="outiside-edit-expense-modal" aria-hidden="true"></div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
            <!-- Heroicon name: outline/exclamation -->
            <i class="bi bi-pencil text-blue-400 text-lg"></i>    
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title-edit"></h3>
            <!-- Form -->
            <div class="mt-2">
                
                <input type="text" name="expenseIdEdit" id="expenseIdEdit" value="" class="hidden">
                
                <div class="form-group">
                        <label for="nameEdit" class="form-label">Descripcion:</label>
                        <input type="text" name="nameEdit" id="nameEdit" class="form-control">
                        <span class="error-alert" id="error-nameEdit"></span>
                    </div>
                    <div class="form-group">
                        <label for="category_edit" class="form-label">Categoría:</label>
                        <select name="category_edit" id="category_edit" class="form-control">
                            <option value="0" disabled>Selecciona una categoría</option>
                            <?php foreach($categories as $category) : ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="error-alert" id="error-categoryEdit"></span>
                    </div>
                    <div class="form-group">
                        <label for="amountEdit" class="form-label">Importe:</label>
                        <input type="number" name="amountEdit" id="amountEdit" class="form-control" step=".01" min="0">
                        <span class="error-alert" id="error-amountEdit"></span>
                    </div>                   
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit" id="updateExpenseBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="updateExpense()">Editar</button>
        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="cancelEditModal" onclick="closeModal('editModal')">Cancelar</button>
      </div>
      
    </div>
  </div>
</div>

<!-- DELETE EXPENSE -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title-delete" role="dialog" aria-modal="true" id="deleteModal">


    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="outside-delete-modal" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" id="modal-body-delete">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Heroicon name: outline/exclamation -->
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title-delete"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">¿Estás seguro? No podrás deshacer esta acción.</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <input type="text" name="deleteExpenseId" id="deleteExpenseId" value="" class="hidden">
                <button id="deleteExpenseBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="destroyExpense()">Eliminar</button>
                <button type="button" type="submit" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="deletCancelBtn" onclick="closeModal('deleteModal')">Cancelar</button>
            </div>
        </div>
</div>



<script type="text/javascript" src="<?= base_url ?>/assets/js/recurrentExpenses.js" defer></script>