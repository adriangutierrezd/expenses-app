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
                    <select name="category_idEdit" id="category_idEdit" class="form-control">
                        <option value="0" disabled>Selecciona una categoría</option>
                        <?php while ($category = $categories->fetch_object()) : ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php endwhile; ?>
                    </select>
                    <span class="error-alert" id="error-category"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button id="createCategoryBtn" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Añadir</button>
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


