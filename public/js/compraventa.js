//Control de las pestañas

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
function anadirNumeroEnvio(id) {
    //Obtención del número de envío
    let input_envio = document.getElementById('input-envio' + id);

    if (comprobarInput(id)) {
        console.log(input_envio.value)
        console.log(id);

        let url = "http://127.0.0.1:8000/pedido/" + id;

        //Obtención del token CSRF como autenticación
        let token = document.querySelector('meta[name="csrf-token"]').content;
        console.log(url, token);

        
        let body = {};
        body.num_envio = input_envio.value;
        console.log(body);

        const requestOptions = {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(body)
        };
        fetch(url, requestOptions)
                .then(response => response.json())
                .then(() => window.location.href = '/compras-y-ventas');

    } else {
        console.log('Error');
    }
}

//Petición con método PUT al controller de pedido para marcarlo como recibido
function confirmarRecepcion(id){
    let url = "http://127.0.0.1:8000/pedido/" + id;

        //Obtención del token CSRF como autenticación
        let token = document.querySelector('meta[name="csrf-token"]').content;
        console.log(url, token);

        
        let body = {};
        body.recibido = 1;
        console.log(body);

        const requestOptions = {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(body)
        };
        fetch(url, requestOptions)
                .then(response => response.json())
                .then(() => window.location.href = '/compras-y-ventas');
}

//Control del input del número de envío. Si no es válido, muestra un mensaje y deshabilita el botón
function comprobarInput(id) {
    //Obtención del texto de error y del boton
    let error = document.getElementById('error' + id);
    let boton = document.getElementById('btn-envio' + id);
    let input_envio = document.getElementById('input-envio' + id);

    let success = false;
    if (input_envio.value.length == 0) {
        error.hidden = false;
        boton.disabled = true;
        success = false;
    } else {
        error.hidden = true;
        boton.disabled = false;
        success = true;
    }
    return success;
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