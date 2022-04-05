<!-- BUDGET -->
<?php if($_SESSION['login']->budget === NULL) : ?>
    <div class="bg-blue-600">
        <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between flex-wrap">
            <div class="flex items-center">
            <span class="flex p-2 px-3 rounded-lg bg-blue-800">
                <!-- Heroicon name: outline/speakerphone -->
                <i class="bi bi-piggy-bank text-white text-2xl"></i>
            </span>
            <p class="ml-3 font-medium text-white truncate">
                <span class="lg:hidden"> Añade tu presupuesto mensual </span>
                <span class="hidden lg:inline"> Si añades tu presupuesto mensual podemos darte más información sobre tus finanzas </span>
            </p>
            </div>
            <div class="mt-2 w-full sm:mt-0 sm:w-auto">
            <a href="#" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-blue-50" onclick="toggleAddBudgetModal()"> Añadir presupuesto </a>
            </div>
        </div>
        </div>
    </div>

    <!-- ADD BUDGET -->
    <div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="addBudget">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="outiside-add-budget-modal" onclick="toggleAddBudgetModal()" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                <!-- Heroicon name: outline/exclamation -->
                <i class="bi bi-pencil text-blue-400 text-lg"></i> 
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Añadir presupuesto</h3>
                <!-- Form -->
                <div class="mt-2">
                    <form action="<?=base_url.'budget/save'?>" method="post">
                        <div class="form-group">
                            <label for="budget" class="form-label">Presupuesto:</label>
                            <input type="number" name="budget" id="budget" class="form-control" step=".01" min="0">
                            <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['budget'])){
                                echo showErrorForm($_SESSION['errors'], 'budget');
                            } ?>
                        </div>                
                </div>
                </div>
            </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Guardar presupuesto</button>
            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="toggleAddBudgetModal()" id="cancelBudgetButton">Cancelar</button>
            </div>
            </form>
        </div>
        </div>
    </div>

<?php else : ?>
      <!-- EDIT BUDGET -->
      <div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="editBudget">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="outiside-edit-budget-modal" onclick="toggleEditBudgetModal()" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                <!-- Heroicon name: outline/exclamation -->
                <i class="bi bi-pencil text-blue-400 text-lg"></i>    
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Añadir presupuesto</h3>
                <!-- Form -->
                <div class="mt-2">
                    <div class="form-group">
                        <label for="budgetEdit" class="form-label">Presupuesto:</label>
                        <input type="number" name="budgetEdit" id="budgetEdit" class="form-control" step=".01" min="0"
                        value="<?= $_SESSION['login']->budget != NULL ? $_SESSION['login']->budget : '' ?>">
                        <span id="error-budgetEdit" class="error-alert"></span>
                    </div>                
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button id="updateBudgetBtn" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Actualizar presupuesto</button>
            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="cancelBudgetEditButton" onclick="toggleEditBudgetModal()">Cancelar</button>
          </div>
          
        </div>
      </div>
  </div>

<?php endif; ?>