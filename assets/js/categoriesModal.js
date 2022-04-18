/**
 * Abre el modal de confirmación para eliminar una categoría
 * @param {Number} categoryId Id de la categoría que se quiere eliminar
 */
function deleteCategory(categoryId){
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteCategoryId').setAttribute('value', categoryId);
}

/**
 * Cierra el modal de eliminación de categorías si se hace click fuera de él
 */
if(document.body.contains(document.getElementById('outside-delete-modal'))){
    document.getElementById('outside-delete-modal').addEventListener('click', () => { closeDeleteModal(); });
}


/**
 * Cierra el modal de eliminación de categorías
 */
deletCancelBtn.addEventListener('click', () => { closeDeleteModal(); });

/**
 * Cierra el modal de eliminación de categorías
 */
function closeDeleteModal(){
    deleteModal.classList.add('hidden');
}

/**
 * Abre el modal de edición de categorías y establece los datos de la categoría seleccionada
 * @param {Number} categoryId Id de la categoría
 * @param {String} categoryName Nombre de la categoría
 * @param {String} categoryColor Color de la categoría
 */
function editCategory(categoryId, categoryName, categoryColor){
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('categoryId').setAttribute('value', categoryId);
    document.getElementById('nameEdit').value = categoryName;
    document.getElementById('colorEdit').value = categoryColor;
}

/**
 * Cierra el modal de edición de categorías si se hace click fuera de él
 */
if(document.body.contains(document.getElementById('outiside-edit-category-modal'))){
    document.getElementById('outiside-edit-category-modal').addEventListener('click', () => { closeEditModal(); });
}


/**
 * Cierra el modal de edición de categorías
 */
document.getElementById('cancelEditModal').addEventListener('click', () => { closeEditModal(); });

/**
 * Cierra el modal de edición de categorías
 */
function closeEditModal(){
    document.getElementById('editModal').classList.add('hidden');
}