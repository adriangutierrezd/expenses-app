window.addEventListener('load', () => {
    if(document.body.contains(document.getElementById('categoriesContainer'))){
        getCategories();
        const categoriesContainer = document.getElementById('categoriesContainer');
        const deleteCategoryBtn = document.getElementById('deleteCategoryBtn');
        const editCategoryBtn = document.getElementById('editCategoryBtn');
        const createCategoryBtn = document.getElementById('createCategoryBtn');
    }
});

deleteCategoryBtn.addEventListener('click', () => {delCategory();})
editCategoryBtn.addEventListener('click', () => {updateCategory(); })
createCategoryBtn.addEventListener('click', () => {createCategory();})


async function getCategories(){
    const url = 'http://localhost/expenses-app/category/getCategories';
    const response = await fetch(url);
    switch(response.status){
        case STATUS_OK:
            const data = await response.json();
            printCategories(data);
            break;
        case STATUS_ERROR_SERVER:
            categoriesContainer.innerText = 'Ha ocurrido un error del servidor';
            break;
        case STATUS_NOT_FOUND:
            categoriesContainer.innerText = 'No podemos encontrar los recursos que buscas';
            break;
        case defualt:
            categoriesContainer.innerText = 'Ha ocurrido un error inesperado';
            break;
    }
}

function printCategories(data){
    categoriesContainer.innerHTML = '';
    data.forEach(element => {
        const elementHTML = `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${element[2]}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="width:50px;background-color:${element[3]};height:20px;"> </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <?php if(${element[0]} != 1) : ?>
                <button class="text-blue-500 hover:text-blue-600" onclick="editCategory(${element[0]}, '${element[2]}', '${element[3]}')">Editar</button>
                <span>  |  </span>
                <button class="text-red-500 hover:text-red-600" onclick="deleteCategory(${element[0]})">Eliminar</button>
            <?php endif; ?>
            </td>
        </tr>
        `;
        categoriesContainer.insertAdjacentHTML('beforeend', elementHTML);
    });
}

async function delCategory(){
    const id = document.getElementById('deleteCategoryId').value;
    const url = 'http://localhost/expenses-app/category/delete';
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
    switch(response.status){
        case STATUS_OK:
            closeDeleteModal();
            getCategories();
            break;
        default:
            showAlert(1);
            break;
    }
}

async function updateCategory(){
    // Validaciones
    const n = document.getElementById('nameEdit').value;
    const c = document.getElementById('colorEdit').value;

    const id = document.getElementById('categoryId').value;
    const name = n.trim().length > 2 ?  n.trim() : '';
    const color = c.trim().length > 2 ?  c.trim() : ''; 

    const errorNameEdit = document.getElementById('error-nameEdit');
    const errorColorEdit = document.getElementById('error-colorEdit');

    if(name === ''){
        errorNameEdit.innerText = 'Debes introducir un nombre';
        return false; 
    }else{errorNameEdit.innerText = ''}

    if(color === ''){
        errorColorEdit.innerText = 'Debes introducir un color';
        return false; 
    }else{errorColorEdit.innerText = ''}

    // Llamada al servidor
    const url = 'http://localhost/expenses-app/category/update';
    const params = {
        id: id,
        name: name,
        color: color
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
            getCategories();
            showAlert(STATUS_OK);
            break;
        case defualt:
            showAlert(1);
            break;
    }

}

async function createCategory(){
    // Validaciones
    const n = document.getElementById('name').value;
    const c = document.getElementById('color').value;

    const name = n.trim().length > 2 ?  n.trim() : '';
    const color = c.trim().length > 2 ?  c.trim() : ''; 

    const errorName = document.getElementById('error-name');
    const errorColor = document.getElementById('error-color');

    if(name === ''){
        errorName.innerText = 'Debes introducir un nombre';
        return false; 
    }else{errorName.innerText = ''}

    if(color === ''){
        errorColor.innerText = 'Debes introducir un color';
        return false; 
    }else{errorColor.innerText = ''}

    // Llamada al servidor
    const url = 'http://localhost/expenses-app/category/save';
    const params = {
        name: name,
        color: color
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
            getCategories();
            document.getElementById('name').value = '';
            document.getElementById('color').value = '#00000';
            break;
        case defualt:
            showAlert(1);
            break;
    }


}