const resultContainer = document.getElementById('resultsContainer');
window.addEventListener('load', () => {
    getResults();
});


/**
 * Obtiene los resultados obtenidos por el usuario
 */
async function getResults(){
    const url = BASE_URL + 'result/getResults';
    const info = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    }

    const response = await fetch(url, info);
    switch (response.status) {
        case STATUS_OK:
            const data = await response.json();
            printResults(data);
            break;
        case STATUS_ERROR_SERVER:
            resultContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${STATUS_ERROR_SERVER_MESSAGE}</td>
            </tr>`;
            break;
        case STATUS_NOT_FOUND:
            resultContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${STATUS_NOT_FOUND_MESSAGE}</td>
            </tr>`;
            break;
        default:
            resultContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${UNEXPECTED_ERROR}</td>
            </tr>`;
    }
}


/**
 * Crea el listado con los resultados obtenidos por el usuario
 * @param {Object} data Objeto con los resultados del usuario
 */
function printResults(data){
    resultContainer.innerHTML = '';
    if(typeof(data) == 'string'){
        resultContainer.innerHTML = `<tr>
            <td class="px-2 py-4" colspan="5">${data}</td>
        </tr>`;
        return;
    }
    data.forEach(element => {
        getDate(element.mes);
        const elementHTML = `
        <tr>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 truncate">${getDate(element.mes, element.anio)}</td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">${getFormarNum(element.budget)}</td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">${getFormarNum(element.spent)}</td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">${getFormarNum(element.budget - element.spent)} (${getSavings(element.budget, element.spent)} %)</td>
        </tr>
        `;
        resultContainer.insertAdjacentHTML('beforeend', elementHTML);   
    }); 
}

/**
 * Obtiene el porcentaje de ahorro obtenido por el usuario
 * @param {Number} budget 
 * @param {Number} spent 
 * @returns Porcentaje de ahorro obtenido
 */
function getSavings(budget, spent){
    let totalSaved = budget - spent;
    let percentageSaved = (totalSaved / budget) * 100;
    return Math.round(percentageSaved);
}

/**
 * Recibe la fecha del informe de resultados y la muestra en formato: Mes Año
 * @param {Number} mes Mes del resultado
 * @param {Number} anio Año del resultado
 * @returns Fecha en formato: Mes Año
 */
function getDate(mes, anio){

    // Armamos la fecha completa
    fullDate = anio + '-' + mes + '-01';

    let d = new Date(fullDate);
    let year = d.getFullYear().toString().substring(2,4);
    let month = getMonthName(d.getMonth() + 1);
    month = month.charAt(0).toUpperCase() + month.slice(1)

    return month + ' ' + year;
}