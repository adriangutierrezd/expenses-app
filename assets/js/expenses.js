window.addEventListener('load', () => {
    if(document.body.contains(document.getElementById('expensesContainer'))){
        getExpenses();
        const expensesContainer = document.getElementById('expensesContainer');
        const updateExpenseBtn = document.getElementById('updateExpenseBtn');
        const deleteExpenseBtn = document.getElementById('deleteExpenseBtn');
        updateExpenseBtn.addEventListener('click', () => {updateExpense();})
        deleteExpenseBtn.addEventListener('click', () => {delExpense();})
    }        
    if(document.body.contains(document.getElementById('addExpenseBtn'))){
        const addExpenseBtn = document.getElementById('addExpenseBtn');
        addExpenseBtn.addEventListener('click', () => {createExpense();})
    }
});


/**
 * Muestra un listado con los datos del periodo seleccionado
 * @param {String} start_date Inicio del periodo. Si no se indica, será el primer día del mes
 * @param {String} end_date Fin del periodo. Si no se indica, será el último día del mes
 */
async function getExpenses(start_date = null, end_date = null){
    const url = BASE_URL + 'expense/getExpenses';
    const params = {
        start_date: start_date,
        end_date: end_date
    }
    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }

    const response = await fetch(url, info);
    switch (response.status) {
        case STATUS_OK:
            const data = await response.json();
            printExpenses(data);
            break;
        case STATUS_ERROR_SERVER:
            expensesContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${STATUS_ERROR_SERVER_MESSAGE}</td>
            </tr>`;
            break;
        case STATUS_NOT_FOUND:
            expensesContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${STATUS_NOT_FOUND_MESSAGE}</td>
            </tr>`;
            break;
        default:
            expensesContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${UNEXPECTED_ERROR}</td>
            </tr>`;
    }
}

/**
 * Crea el listado con los gastos del periodo seleccionado
 * @param {Object} data Objeto con los datos de los gastos del periodo seleccionado
 */
function printExpenses(data){
    expensesContainer.innerHTML = '';
    if(typeof(data) == 'string'){
        expensesContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${data}</td>
        </tr>`;
        return;
    }
    data.forEach(element => {
        const elementHTML = `
        <tr>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 truncate">${element.expense_name}</td>
            <td class="hidden md:flex px-6 py-4 whitespace-nowrap text-sm text-gray-900">${element.category_name}</td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">${getFormarNum(element.amount)}</td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <button class="text-blue-500 hover:text-blue-600" onclick="editExpense(${element.id}, '${element.expense_name}', ${element.category_id}, ${element.amount}, '${element.date}')">Editar</button>
            <span>  |  </span>
            <button class="text-red-500 hover:text-red-600" onclick="deleteExpense(${element.id}, ${element.amount}, '${element.date}')">Eliminar</button>
            </td>
        </tr>
        `;
        expensesContainer.insertAdjacentHTML('beforeend', elementHTML);
    }); 
}

/**
 * Elimina un gasto
 */
async function delExpense(){
    const expenseId = document.getElementById('deleteExpenseId').value;
    const amount = document.getElementById('amountExpense').value;
    const date = document.getElementById('dateExpense').value;

    const url = BASE_URL + 'expense/delete';
    const params = {
        id: expenseId,
        amount: amount,
        date: date
    }
    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }


    const response = await fetch(url, info);
    switch(response.status){
        case STATUS_OK:
            closeDeleteModal();
            updateData();
            break;
        default:
            showAlert(1);
            break;
    }
}


/**
 * Recarga las gráficas 
 */
function refreshCharts(){
    if(document.body.contains(document.getElementById('categoryChart'))){
        destroySpentByCategoryChart();
        getSpentByCategory();
    }
    if(document.body.contains(document.getElementById('monthlyChart'))){
        destroySpentByMonthChart();
        getSpentByMonth();
    }
}

/**
 * Actualiza un gasto
 * @returns {boolean} Devuelve false si ocurre algún error en la validación
 */
async function updateExpense(){
    // Validaciones
    const n = document.getElementById('nameEdit').value;
    const a = document.getElementById('amountEdit').value;
    const d = document.getElementById('dateEdit').value;
    const c = document.getElementById('category_idEdit').value;
    const e = document.getElementById('previousAmount').value;

    const id = document.getElementById('expenseId').value;
    const name = n.trim().length > 2 ?  n.trim() : '';
    const amount = a > 0 ? a : '';
    const category_id = c > 0 ?  c : '';
    const date = d.trim().length > 2 ?  d.trim() : '';

    const errorNameEdit = document.getElementById('error-nameEdit');
    const errorAmountEdit = document.getElementById('error-amountEdit');
    const errorCategoryEdit = document.getElementById('error-categoryEdit');
    const errorDateEdit = document.getElementById('error-dateEdit');

    if(name === ''){
        errorNameEdit.innerText = 'No puedes dejar este campo vacío';
        return false; 
    }else{errorNameEdit.innerText = ''}

    if(category_id === ''){
        errorCategoryEdit.innerText = 'Debes seleccionar una categoría';
        return false; 
    }else{errorCategoryEdit.innerText = ''}

    if(amount === ''){
        errorAmountEdit.innerText = 'Debes seleccionar un importe superior';
        return false; 
    }else{errorAmountEdit.innerText = ''}

    if(date === ''){
        errorDateEdit.innerText = 'Selecciona una fecha';
        return false; 
    }else{errorDateEdit.innerText = ''}

    

    // Llamada al servidor
    const url = BASE_URL + 'expense/update';
    const params = {
        id: id,
        name: name,
        amount: amount,
        category_id: category_id,
        date: date,
        previousAmount: e
    }
    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }

    const response = await fetch(url, info);
    switch(response.status){
        case STATUS_OK:
            closeEditModal();
            updateData();
            break;
        case STATUS_ERROR_SERVER:
            expensesContainer.innerText = 'Ha ocurrido un error del servidor';
            break;
        case STATUS_NOT_FOUND:
            expensesContainer.innerText = 'No podemos encontrar los recursos que buscas';
            break;
        case defualt:
            expensesContainer.innerText = 'Ha ocurrido un error inesperado';
            break;
    }
}

/**
 * Crea un gasto
 * @returns {boolean} Devuelve false si ocurre algún error en la validación
 */
async function createExpense(){
    // Validaciones
    const n = document.getElementById('name').value;
    const a = document.getElementById('amount').value;
    const d = document.getElementById('date').value;
    const c = document.getElementById('category_id').value;

    const id = document.getElementById('expenseId').value;
    const name = n.trim().length > 2 ?  n.trim() : '';
    const amount = a > 0 ? a : '';
    const category_id = c > 0 ?  c : '';
    const date = d.trim().length > 2 ?  d.trim() : '';

    const errorName = document.getElementById('error-name');
    const errorAmount = document.getElementById('error-amount');
    const errorCategory = document.getElementById('error-category');
    const errorDate = document.getElementById('error-date');

    if(name === ''){
        errorName.innerText = 'No puedes dejar este campo vacío';
        return false; 
    }else{errorName.innerText = ''}

    if(category_id === ''){
        errorCategory.innerText = 'Debes seleccionar una categoría';
        return false; 
    }else{errorCategory.innerText = ''}

    if(amount === ''){
        errorAmount.innerText = 'Debes seleccionar un importe superior';
        return false; 
    }else{errorAmount.innerText = ''}

    if(date === ''){
        errorDate.innerText = 'Selecciona una fecha';
        return false; 
    }else{errorDate.innerText = ''}


    // Llamada al servidor
    const url = BASE_URL + '/expense/save';
    const params = {
        id: id,
        name: name,
        amount: amount,
        category_id: category_id,
        date: date
    }
    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }

    const response = await fetch(url, info);
    switch(response.status){
        case STATUS_OK:
            toggleAddExpenseModal();
            updateData();
            break;
    }

}

/**
 * Refresca toda la información susceptible de ser actualizada en la página
 */
function updateData(){
    if(document.body.contains(document.getElementById('budgetStuff'))){
        updateStats();
    }
    showAlert(STATUS_OK);
    let start_date = null;
    let end_date = null;
    if(document.body.contains(document.getElementById('start-date')) && document.body.contains(document.getElementById('end-date'))){
        start_date = document.getElementById('start-date').value;
        end_date = document.getElementById('end-date').value;
    }
    getExpenses(start_date, end_date);
    refreshCharts();
}
