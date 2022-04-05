window.addEventListener('load', () => {
    if(document.body.contains(document.getElementById('monthlyChart'))){
        getSpentByMonth();
    }
});

let spentByMonthChart = null;

/**
 * Obtiene los datos para crear la gráfica de gasto mensual
 */
async function getSpentByMonth(){
    const url = 'http://localhost/expenses-app/expense/getExpenseByMonth';
    const response = await fetch(url);
    switch(response.status){
        case STATUS_OK:
            const data = await response.json();
            printSpentByMonth(data);
            break;
    }
}

function getMonthName(mes){
    var date =  mes +'/01/2001';
    var fecha = new Date(date);
    var monthName = fecha.toLocaleDateString('es-ES', {month: 'long'});
    return monthName;
}

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

function destroySpentByMonthChart(){
    spentByMonthChart.destroy();
}