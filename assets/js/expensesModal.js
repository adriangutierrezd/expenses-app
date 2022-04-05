const deleteModal = document.getElementById('deleteModal');
const deletCancelBtn = document.getElementById('deletCancelBtn');
var deleteExpenseId = document.getElementById('deleteExpenseId');


/**
 * Abre el modal y obtiene el gasto a eliminar
 * @param {*} expenseId Gasto a eliminar
 */
function deleteExpense(expenseId){
    deleteModal.classList.remove('hidden');
    deleteExpenseId.setAttribute('value', expenseId);
}

/**
 * Cierra el modal si se hace clic fuera de el
 */
document.getElementById('outside-delete-modal').addEventListener('click', () => { closeDeleteModal(); });

/**
 * Cierra el modal
 */
function closeDeleteModal(){
    deleteModal.classList.add('hidden');
}

/**
 * Cierra el modal cuando se cancela la operación
 */
deletCancelBtn.addEventListener('click', () => { closeDeleteModal(); });



// EDIT MODAL
function editExpense(expenseId, expenseName, expenseCategory, expenseAmount, expenseDate){
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('expenseId').setAttribute('value', expenseId);
    document.getElementById('nameEdit').value = expenseName;
    document.getElementById('amountEdit').value = expenseAmount;
    document.getElementById('category_idEdit').value = expenseCategory;
    document.getElementById('dateEdit').value = expenseDate;

}
document.getElementById('outiside-edit-expense-modal').addEventListener('click', () => { closeEditModal(); });
function closeEditModal(){
    document.getElementById('editModal').classList.add('hidden');
}

// CREATE MODAL

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



