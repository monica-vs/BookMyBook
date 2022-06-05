let listaCompras = document.getElementById('l-compras');
let listaVentas = document.getElementById('l-ventas');
listaVentas.hidden = true;

let compras = document.getElementById('compras');
compras.addEventListener('click', function (e) {
    mostrar(e);
})

let ventas = document.getElementById('ventas');
ventas.addEventListener('click', function (e) {
    mostrar(e);
})



//Evento disparado por el botón de Aceptar (añadir número de envío)
function anadirNumeroEnvio(id){
    //Obtención del número de envío
    let input_envio = document.getElementById('input-envio'+id);
    
    //Obtención del texto de error y del botón
    let error = document.getElementById('error'+id);
    let boton = document.getElementById('btn-envio'+id);
    
    if(input_envio.value.length == 0){
        error.hidden = false;
        boton.disabled = true;
    } else {
        error.hidden = true;
        console.log(input_envio.value);
    }
}

function comprobarInput(id){
    //Obtención del texto de error y del boton
    let error = document.getElementById('error'+id);
    let boton = document.getElementById('btn-envio'+id);
    if(event.target.value.length == 0){
        error.hidden = false;
        boton.disabled = true;
    } else {
        error.hidden = true;
        boton.disabled = false;
    }
}

function mostrar(e) {
    let enlace = e.target;
    switch (enlace.id) {
        case 'compras':
            listaCompras.hidden = false;
            listaVentas.hidden = true;
            break;
        case 'ventas':
            listaCompras.hidden = true;
            listaVentas.hidden = false;
            break;
    }
    compras.classList.toggle('active');
    compras.classList.toggle('link-dark');
    ventas.classList.toggle('active');
    ventas.classList.toggle('link-dark');
}