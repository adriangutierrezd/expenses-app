<!-- ADD EXPENSE -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="addExpense">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="outiside-add-expense-modal" aria-hidden="true" onclick="toggleAddExpenseModal()"></div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
            <!-- Heroicon name: outline/exclamation -->
            <i class="bi bi-pencil text-blue-400 text-lg"></i>    
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Añadir gasto</h3>
            <!-- Form -->
            <div class="mt-2">
                <div class="form-group">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <span class="error-alert" id="error-name"></span>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="form-label">Categoría:</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="0" selected disabled>Selecciona una categoría</option>
                            <?php while($category = $categories->fetch_object()) : ?>
                                <option value="<?= $category->id ?>" ><?= $category->name ?></option>
                            <?php endwhile; ?>
                        </select>
                        <span class="error-alert" id="error-category"></span>
                        
                    </div>
                    <div class="form-group">
                        <label for="amount" class="form-label">Importe:</label>
                        <input type="number" name="amount" id="amount" class="form-control" step=".01" min="0">
                        <span class="error-alert" id="error-amount"></span>
                    </div>       
                    <div class="form-group">
                      <label for="date" class="form-label">Fecha:</label>
                      <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d') ?>">
                      <span class="error-alert" id="error-date"></span>
                    </div>        
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
      <button id="addExpenseBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Añadir</button>
        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="toggleAddExpenseModal()" id="cancelAddModal">Cancelar</button>
      </div>
    </div>
  </div>
</div>