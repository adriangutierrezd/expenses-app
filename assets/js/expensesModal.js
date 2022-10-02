const deleteModal = document.getElementById('deleteModal');
const deletCancelBtn = document.getElementById('deletCancelBtn');
var deleteExpenseId = document.getElementById('deleteExpenseId');
var deleteExpenseAmount = document.getElementById('amountExpense');
var deleteExpenseDate = document.getElementById('dateExpense');


/**
 * Abre el modal y obtiene el gasto a eliminar
 * @param {Number} expenseId Id del gasto a eliminar
 * @param {Number} amount Importe del gasto a eliminar
 * @param {String} date Fecha del gasto a eliminar
 */
function deleteExpense(expenseId, amount, date){
    deleteModal.classList.remove('hidden');
    deleteExpenseId.setAttribute('value', expenseId);
    deleteExpenseAmount.setAttribute('value', amount);
    deleteExpenseDate.setAttribute('value', date);
}

/**
 * Cierra el modal de eliminación de gastos si se hace clic fuera de el
 */
if(document.body.contains(document.getElementById('outside-delete-modal'))){
    document.getElementById('outside-delete-modal').addEventListener('click', () => { closeDeleteModal(); });
}


/**
 * Cierra el modal de eliminación de gastos
 */
function closeDeleteModal(){
    deleteModal.classList.add('hidden');
}

/**
 * Cierra el modal cuando se cancela la operación
 */
deletCancelBtn.addEventListener('click', () => { closeDeleteModal(); });



/**
 * Abre el modal de edición de gastos y establece los datos del gasto seleccionado
 * @param {Number} expenseId Id 
 * @param {String} expenseName Nombre 
 * @param {Number} expenseCategory Categoría 
 * @param {Number} expenseAmount Importe    
 * @param {String} expenseDate Fecha
 */
function editExpense(expenseId, expenseName, expenseCategory, expenseAmount, expenseDate){
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('expenseId').setAttribute('value', expenseId);
    document.getElementById('previousAmount').setAttribute('value', expenseAmount);
    document.getElementById('nameEdit').value = expenseName;
    document.getElementById('amountEdit').value = expenseAmount;
    document.getElementById('category_idEdit').value = expenseCategory;
    document.getElementById('dateEdit').value = expenseDate;

}

/**
 * Cierra el modal de edición de gastos si se hace clic fuera de él
 */
document.getElementById('outiside-edit-expense-modal').addEventListener('click', () => { closeEditModal(); });

/**
 * Cierra el modal de edición de gastos
 */
function closeEditModal(){
    document.getElementById('editModal').classList.add('hidden');
}

/**
 * Abre o cierra el modal de creación de gastos. Antes, establece en el campo date la fecha de hoy y limpia el resto de campos.
 */
function toggleAddExpenseModal(){
    let date = new Date()

    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()
    let fulldate = '';
    if(month < 10){
        fulldate = `${year}-0${month}-${day}`;
        if(day < 10){
            fulldate = `${year}-0${month}-0${day}`;
        }
    }else{
        fulldate = `${year}-${month}-${day}`;
        if(day < 10){
            fulldate = `${year}-${month}-0${day}`;
        }
    }
    document.getElementById('name').value = '';
    document.getElementById('amount').value = '';
    document.getElementById('date').value = fulldate;
    document.getElementById('category_id').value = 0;
    document.getElementById('addExpense').classList.toggle('hidden');
}



