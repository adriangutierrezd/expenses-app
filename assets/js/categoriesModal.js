
// Delete modal
function deleteCategory(categoryId){
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteCategoryId').setAttribute('value', categoryId);
}

document.getElementById('outside-delete-modal').addEventListener('click', () => { closeDeleteModal(); });
deletCancelBtn.addEventListener('click', () => { closeDeleteModal(); });

function closeDeleteModal(){
    deleteModal.classList.add('hidden');
}


// Edit modal

function editCategory(categoryId, categoryName, categoryColor){
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('categoryId').setAttribute('value', categoryId);
    document.getElementById('nameEdit').value = categoryName;
    document.getElementById('colorEdit').value = categoryColor;
    

    console.log(categoryId, categoryName, categoryColor);
}
document.getElementById('outiside-edit-category-modal').addEventListener('click', () => { closeEditModal(); });
document.getElementById('cancelEditModal').addEventListener('click', () => { closeEditModal(); });
function closeEditModal(){
    document.getElementById('editModal').classList.add('hidden');
}