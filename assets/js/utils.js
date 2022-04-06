const BASE_URL = 'http://localhost/expenses-app/';
const STATUS_OK = 200;
const STATUS_ERROR_SERVER = 500;
const STATUS_NOT_FOUND = 404;


/**
 * Recibe un número y lo convierte a formato monetario
 * @param {Number, String} num Número o String a convertir
 * @returns Número en formato monetario
 */
function getFormarNum(num){
    if(typeof(num) === 'string') num = parseFloat(num);
    return new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(num);
}