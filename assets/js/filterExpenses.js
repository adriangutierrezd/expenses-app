const filterBtn = document.getElementById('filterBtn');
filterBtn.addEventListener('click', () => {filter();})
/**
 * Recoge los datos de filtrado por fecha del formulario y actualiza el listado de gastos y las gráficas
 */
function filter(){
    let start_date = document.getElementById('start-date').value;
    let end_date = document.getElementById('end-date').value;
    if(document.body.contains(document.getElementById('expensesContainer'))){
        getExpenses(start_date, end_date);
    }
    if(document.body.contains(document.getElementById('monthlyChart'))){
        destroySpentByCategoryChart();
        getSpentByCategory(start_date, end_date);
    }
}