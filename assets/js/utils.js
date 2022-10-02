const BASE_URL = 'http://localhost/expenses-app/';
const STATUS_OK = 200;
const STATUS_ERROR_SERVER = 500;
const STATUS_NOT_FOUND = 404;
const STATUS_NOT_FOUND_MESSAGE = 'No podemos encontrar los recursos que buscas.';
const STATUS_ERROR_SERVER_MESSAGE = 'Ha ocurrido un error del servidor.';
const UNEXPECTED_ERROR = 'Ha ocurrido un error inesperado.';


/**
 * Recibe un número y lo convierte a formato monetario
 * @param {Number, String} num Número o String a convertir
 * @returns Número en formato monetario
 */
function getFormarNum(num){
    if(typeof(num) === 'string') num = parseFloat(num);
    return new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(num);
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