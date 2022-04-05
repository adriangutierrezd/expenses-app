let spentByCategoryChart = null;

window.addEventListener('load', () => {
    getSpentByCategory();
});

/**
 * Obtiene los datos para crear la gráfica de gasto desagregado por categoría
 * @param {date} start_date Fecha de inicio del periodo
 * @param {date} end_date Fecha de fin del periodo
 */
async function getSpentByCategory(start_date = null, end_date = null){
    const url = BASE_URL +'expense/getExpenseByCategory';
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
    switch(response.status){
        case STATUS_OK:
            const data = await response.json();
            printSpentByCategory(data);
            break;
        case STATUS_ERROR_SERVER:
            document.getElementById('categoryChart').innerText = 'Ha ocurrido un error del servidor.';
            break;
        case STATUS_NOT_FOUND:
            document.getElementById('categoryChart').innerText = 'No hemos podido encontrar lo que buscabas.';
            break;
        case defualt:
            document.getElementById('categoryChart').innerText = 'Ha ocurrido un error inesperado.';
            break;
    }
}

/**
 * Crea la gráfica de gasto desgregado por categoría del periodo seleccionado
 * @param {Object} data Datos de los gastos y categorias de dicho periodo
 */
function printSpentByCategory(data){
    const amounts = [];
    const categories = [];
    const borderColors = [];
    const backgroundColors = [];

    data.forEach(element => {
        amounts.push(element.SPENT);
        categories.push(element.NAME);
        borderColors.push(convertHex(element.COLOR));
        backgroundColors.push(convertHex(element.COLOR, 0.2))
    }); 


    const ctx = document.getElementById('categoryChart').getContext('2d');
    spentByCategoryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Gasto por categoría',
                data: amounts,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


}

/**
 * Elimina la gráfica creada
 */
function destroySpentByCategoryChart(){
    spentByCategoryChart.destroy();
}

/**
 * Transforma el código de color de HEX a RGBA
 * @param {String} hexCode Color en HEX
 * @param {Number} opacity Opacidad del color en RGBA
 * @returns Color transformado en RGBA
 */
function convertHex(hexCode, opacity = 1){
    var hex = hexCode.replace('#', '');

    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }

    var r = parseInt(hex.substring(0,2), 16),
        g = parseInt(hex.substring(2,4), 16),
        b = parseInt(hex.substring(4,6), 16);

    // Backward compatibility for whole number based opacity values. 
    if (opacity > 1 && opacity <= 100) {
        opacity = opacity / 100;   
    }
    
    return 'rgba('+r+','+g+','+b+','+opacity+')';
}