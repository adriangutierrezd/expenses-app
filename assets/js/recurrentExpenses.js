window.addEventListener('load', () => { getRecurrentExpenses(); })
document.getElementById('outside-delete-modal').addEventListener('click', () => { closeModal('deleteModal'); });
document.getElementById('outiside-edit-expense-modal').addEventListener('click', () => { closeModal('editModal'); });



/**
 * Obtiene los gastos recurrentes de un usuario
*/
async function getRecurrentExpenses(){
    const url = BASE_URL + 'expense/getRecurrentExpenses';
    const info = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    }

    const response = await fetch(url, info);
    switch (response.status) {
        case STATUS_OK:
            const data = await response.json();
            printRecurrentExpenses(data);
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
function printRecurrentExpenses(data){
    const recExpensesContainer = document.getElementById('recurrentContainer');
    recExpensesContainer.innerHTML = '';
    if(typeof(data) == 'string'){
        recExpensesContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${data}</td>
        </tr>`;
        return;
    }
    data.forEach(element => {
        const btns = `
        <button class="text-blue-500 hover:text-blue-600" onclick="editExpense(${element.id_recurrent_expenses}, '${element.description}', ${element.id_categoria}, ${element.amount})">Editar</button>
        <span>  |  </span>
        <button class="text-red-500 hover:text-red-600" onclick="deleteExpense(${element.id_recurrent_expenses}, '${element.description}')">Eliminar</button>
        `;
        const elementHTML = `
        <tr>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 truncate">${element.description}</td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 truncate">${element.name}</td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 truncate">${getFormarNum(element.amount)}</td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 truncate">${btns}</td>
        </tr>
        `;
        recExpensesContainer.insertAdjacentHTML('beforeend', elementHTML);
    }); 
}

/**
 * Crea un gasto recurrente
 * @return {Boolean} True si el proceso es exitoso, false si no lo es
 */
async function createRecurrentExpense(){

    const name = document.getElementById('name').value.trim();
    const amount = document.getElementById('amount').value.trim();
    const category = document.getElementById('category').value;

    let errors = false;

    if(name === ''){
        document.getElementById('error-name').innerHTML = 'Debes introducir un nombre';
        errors = true;
    }else{
        document.getElementById('error-name').innerHTML = '';
    }

    if(amount === ''){
        document.getElementById('error-amount').innerHTML = 'Debes introducir un importe';
        errors = true;
    }else if(amount < 0){
        document.getElementById('error-amount').innerHTML = 'El importe debe ser mayor a 0';
        errors = true;
    }else{
        document.getElementById('error-amount').innerHTML = '';
    }

    if(category == 0){
        document.getElementById('error-category').innerHTML = 'Debes seleccionar una categoría';
        errors = true;
    }else{
        document.getElementById('error-category').innerHTML = '';
    }

    if(errors) return;

    // Parámetros de llamada AJAX
    const url = BASE_URL + 'expense/createRecurrentExpense';
    const params = {
        name: name,
        amount: amount,
        category: category,
    }

    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }


    const response = await fetch(url, info);
    document.getElementById('name').value = '';
    document.getElementById('amount').value = '';
    document.getElementById('category').value = '';
    getRecurrentExpenses();
}


/**
 * Elimina un gasto recurrente
 */
async function delExpense(){
    const expenseId = document.getElementById('deleteExpenseId').value;

    const url = BASE_URL + 'expense/deleteRecurrent';
    const params = {
        id: expenseId,
    }
    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }


    const response = await fetch(url, info);

}

/**
 * Abre el modal y obtiene el gasto a eliminar
 * @param {Number} expenseId Id del gasto a eliminar
 * @param {String} name Nombre del gasto a eliminar
 */
function deleteExpense(expenseId, name){
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteExpenseId').value =  expenseId;
    document.getElementById('modal-title-delete').innerHTML ='Eliminar ' + name;
}


/**
 * Cierra el modal pasado por parámetro
 * @param {String} modal ID del modal que se quiere cerrar
 */
function closeModal(modal){
    document.getElementById(modal).classList.add('hidden');
}

/**
 * 
 * @param {Number} id ID del gasto a modificar
 * @param {String} name Descripción del gasto a modificar
 * @param {Number} category ID de categoría del gasto a modificar
 * @param {Float} amount Importe del gasto a modificar
 */
function editExpense(id, name, category, amount){
    console.log(id);
    console.log(name);
    console.log(category);
    console.log(amount)
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('modal-title-edit').innerHTML ='Editar ' + name;
    document.getElementById('nameEdit').value = name;
    document.getElementById('expenseIdEdit').value =  id;
    document.getElementById('category_edit').value =  category;
    document.getElementById('amountEdit').value =  amount;

}

/**
 * Obtiene los datos y actualiza un gasto recurrente en la base de datos
*/
async function updateExpense(){
    const name = document.getElementById('nameEdit').value.trim();
    const amount = document.getElementById('amountEdit').value.trim();
    const category = document.getElementById('category_edit').value;
    const id = document.getElementById('expenseIdEdit').value;

    let errors = false;

    if(name === ''){
        document.getElementById('error-nameEdit').innerHTML = 'Debes introducir un nombre';
        errors = true;
    }else{
        document.getElementById('error-nameEdit').innerHTML = '';
    }

    if(amount === ''){
        document.getElementById('error-amountEdit').innerHTML = 'Debes introducir un importe';
        errors = true;
    }else if(amount < 0){
        document.getElementById('error-amountEdit').innerHTML = 'El importe debe ser mayor a 0';
        errors = true;
    }else{
        document.getElementById('error-amountEdit').innerHTML = '';
    }

    if(category == 0){
        document.getElementById('error-categoryEdit').innerHTML = 'Debes seleccionar una categoría';
        errors = true;
    }else{
        document.getElementById('error-categoryEdit').innerHTML = '';
    }

    if(errors) return;


    // Parámetros de llamada AJAX
    const url = BASE_URL + 'expense/updateRecurrentExpense';
    const params = {
        name: name,
        amount: amount,
        category_id: category,
        id: id
    }

    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }


    const response = await fetch(url, info);
    document.getElementById('nameEdit').value = '';
    document.getElementById('amountEdit').value = '';
    document.getElementById('category_edit').value = 0;
    document.getElementById('expenseIdEdit').value = '';
    getRecurrentExpenses();
    closeModal('editModal');

}


/**
 * Elimina un gasto recurrente
*/
async function destroyExpense(){

    const id = document.getElementById('deleteExpenseId').value;

    // Parámetros de llamada AJAX
    const url = BASE_URL + 'expense/deleteRecurrentExpense';
    const params = {
        id: id
    }

    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    }


    const response = await fetch(url, info);
    document.getElementById('deleteExpenseId').value = '';
    getRecurrentExpenses();
    closeModal('deleteModal');

}


