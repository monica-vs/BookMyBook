
async function eliminar_item(id) {
    let url = "http://127.0.0.1:8000/carrito/" + id;

    //Obtención del token CSRF como autenticación
    let token = document.querySelector('meta[name="csrf-token"]').content;
    console.log(url, token);

    let xhr = new XMLHttpRequest();
    xhr.open("DELETE", url);

    xhr.setRequestHeader("Accept", "*/*");
    xhr.setRequestHeader('X-CSRF-TOKEN', token);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log(xhr.status);
            console.log(xhr.responseText);
            return xhr.status;
        }
    };

    xhr.send();

    window.location = "/micarrito";
}

async function pagar() {
    console.log('Fuction pagar');
    
    for(let i = 0; i < subtotales.length ; i++){
        //Almacenaremos aquí la información del pedido creado en la tabla de pedidos, nos interesa especialemente el id generado.
         let pedido = await hacerPedido(subtotales[i]);
         
         //Añadimos los libros a la tabla de Pedidos_Detalle
         let detallesPedido = await anadirDetallesPedido(pedido, i+1);
         
         console.log('Subpedido realizado correctamente');
    }
    
     console.log('Pedido completado');
     
     //Borrar elementos del carrito
     for (let j = 0; j < ids_carrito.length; j++) {
     let borrado = await eliminar_item(ids_carrito[j]);
     console.log(borrado);
     }
     
     window.location = "/compras-y-ventas";
     
}

async function hacerPedido(total) {
    console.log('Realizando pedido...');
    let url = "http://127.0.0.1:8000/pedido";

    //Obtención del token CSRF como autenticación
    let token = document.querySelector('meta[name="csrf-token"]').content;
    
    
    return fetch(url, {
        method: 'POST',
        body: JSON.stringify({
            usuario_id: user_id,
            total: total
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    }).then(respuesta => respuesta.json())
            .then((datos) => {
                return datos
            });
     
}

async function anadirDetallesPedido(pedido, n) {
    console.log('Añadiendo detalles del pedido...');
    let url = "http://127.0.0.1:8000/pedidodetalle";

    let peticion;
    //Obtención del token CSRF como autenticación
    let token = document.querySelector('meta[name="csrf-token"]').content;

    let libros_carrito = document.getElementsByClassName('idproducto'+n);
    
    for (let i = 0; i < libros_carrito.length; i++) {
        let libro = libros_carrito[i].innerText;

        peticion = fetch(url, {
            method: 'POST',
            body: JSON.stringify({
                pedido_id: pedido.id,
                libro_id: libro
            }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        }).then(respuesta => respuesta.json())
                .then((datos) => {
                    return datos
                });
    }
    return peticion;
    
}