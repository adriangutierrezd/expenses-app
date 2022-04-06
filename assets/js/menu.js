const hamburguer = document.getElementById('hamburguer');
const cross = document.getElementById('cross');
const items = document.getElementById('items');
const body = document.getElementById('body');


/**
 * Abre el menú
 */
hamburguer.addEventListener('click', () => {
    items.classList.toggle('hidden');
    items.classList.toggle('flex');

    items.classList.add('show');
    items.classList.remove('close');

    body.classList.add('overflow-block');
    
});

/**
 * Cierra el menú
 */
cross.addEventListener('click', () => {
    items.classList.add('close');
    // Posponemos las acciones para que se vea como se baja la opacidad
    // Tiene que ser menos tiempo que la animación, para que no se colapsen
    setTimeout(toggles, 250)

    function toggles(){
        items.classList.toggle('hidden');
        items.classList.toggle('flex');
    }
    items.classList.remove('show'); 
    body.classList.remove('overflow-block');

});


