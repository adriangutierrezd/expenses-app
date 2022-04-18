window.addEventListener('load', () => {
    const updateBudgetBtn = document.getElementById('updateBudgetBtn');
    updateStats();
})
const budgetStuff = document.getElementById('budgetStuff');
updateBudgetBtn.addEventListener('click', () => {updateBudget();})

/**
 * Actualiza los datos sobre presupuesto y total gastado
 */
async function updateStats(){
    const url = BASE_URL + 'budget/getStats';
    const response = await fetch(url);
    switch(response.status){
        case STATUS_OK:
            const data = await response.json();
            printStats(data);
            getTotalSpent(data);
            break;
        default:
            budgetStuff.innerText = 'Ha ocurrido un error';
            break;
    }
}

/**
 * Obtiene el total gasto por el usuario durante el mes actual
 * @param {Object} data Datos de los gastos del mes actual
 * @returns Gasto total durante el mes actual
 */
function getTotalSpent(data){
    let totalSpent = 0;
    data[1].forEach(element => {
        totalSpent += parseFloat(element.amount);
    });
    return totalSpent;
}


/**
 * Crea el resumen con los datos financieros del mes actual
 * @param {Object} data Datos de los gastos del mes actual
 */
function printStats(data){
    budgetStuff.innerHTML = '';
    if(data[0].budget != null){
        const budget = getFormarNum(data[0].budget);
        const spent = getFormarNum(getTotalSpent(data));
        const result = getFormarNum(data[0].budget - getTotalSpent(data));

        budgetStuff.innerHTML = `
        <div class="flex flex-col flex-items-center justify-start p-4">
        <p class="font-semibold text-lg mb-3">
            Presupuesto:
        </p>
        <div class="flex items-center justify-between" onclick="toggleEditBudgetModal()">
        <div style="height: 2rem;width: 2rem;" class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 hover:bg-blue-200 cursor-pointer">
          <!-- Heroicon name: outline/exclamation -->
          <i class="bi bi-pencil text-blue-400 text-base"></i>    
        </div>

        <p class="ml-auto">${budget}</p>
      </div>
        
    </div>
    <div class="flex flex-col flex-items-center justify-start p-4">
        <p class="font-semibold text-lg mb-3">
            Total gastado: 
        </p>
        <p class="ml-auto">${spent}</p>
    </div>
    <div class="flex flex-col flex-items-center justify-start p-4">
        <p class="font-semibold text-lg mb-3">
            Capital restante:
        </p>
        <p class="ml-auto">${result}</p>
    </div>
        `;
    }else{
        const spent = getFormarNum(getTotalSpent(data));
        budgetStuff.innerHTML = `
        <div class="flex flex-col flex-items-center justify-start p-4">
            <p class="font-semibold text-lg mb-3">
                Total gastado: 
            </p>
            <p class="mr-auto">${spent}</p>
        </div>
        `;
        
    }
}

/**
 * Actualiza los datos del presupuesto mensual del usuario
 */
async function updateBudget(){
    // Validar
    const budget = document.getElementById('budgetEdit').value;
    const errorBudgetEdit = document.getElementById('error-budgetEdit');
    if(budget <= 0){
        errorBudgetEdit.innerText = 'El presupuesto debe ser mayor a 0';
        return false;
    }else{errorBudgetEdit.innerText = ''}

    // Llamada al servidor
    const url = BASE_URL + '/budget/update';
    const params = {
        budget: budget
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
            toggleEditBudgetModal();
            updateStats(); 
            break;
        default:
            showAlert(1);
            break;
    }
}
