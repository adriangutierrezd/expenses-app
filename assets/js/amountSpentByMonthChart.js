window.addEventListener('load', () => {
    if(document.body.contains(document.getElementById('monthlyChart'))){
        getSpentByMonth();
    }
});

let spentByMonthChart = null;

/**
 * Obtiene los datos para generar la gráfica del gasto desagregado por mes en el último natural
 */
async function getSpentByMonth(){
    const url = BASE_URL + 'expense/getExpenseByMonth';
    const response = await fetch(url);
    switch(response.status){
        case STATUS_OK:
            const data = await response.json();
            printSpentByMonth(data);
            break;
        case STATUS_ERROR_SERVER:
            document.getElementById('monthlyChart').innerText = 'Ha ocurrido un error del servidor.';
            break;
        case STATUS_NOT_FOUND:
            document.getElementById('monthlyChart').innerText = 'No hemos podido encontrar lo que buscabas.';
            break;
        case defualt:
            document.getElementById('monthlyChart').innerText = 'Ha ocurrido un error inesperado.';
            break;
    }
}

/**
 * Obtiene el nombre de un mes a partir de su número
 * @param {Number} mes Número del mes a convertir a texto
 * @returns Nombre del mes
 */
function getMonthName(mes){
    var date =  mes +'/01/2001';
    var fecha = new Date(date);
    var monthName = fecha.toLocaleDateString('es-ES', {month: 'long'});
    return monthName;
}

/**
 * Crea la gráfica de gasto desgregado por mes
 * @param {Object} data Datos de los gastos del último año natural
 */
function printSpentByMonth(data){
    const amountMonths = [];
    const nameMonths = [];

    data.forEach(element => {
        amountMonths.push(element[1]);
        nameMonths.push(getMonthName(element[0]));
    }); 


    const ct = document.getElementById('monthlyChart').getContext('2d');
    spentByMonthChart = new Chart(ct, {
        type: 'line',
        data: {
            labels: nameMonths,
            datasets: [{
                label: 'Gasto por mes',
                data: amountMonths,
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
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
function destroySpentByMonthChart(){
    spentByMonthChart.destroy();
}