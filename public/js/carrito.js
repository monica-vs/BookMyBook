//Consulta para obtener el carrito del usuario. Obtención de datos en JSON con método GET
let url = "http://127.0.0.1:8000/carrito/" + user_id;
let total = 0;
fetch(url)
        .then((respuesta) => respuesta.json())
        .then((datos) => imprimir(datos))
        .catch((e) => alert(e.message));

let btn_pago = document.getElementById('btn-pago');
btn_pago.addEventListener('click', function () {
    pagar();
})

let ids_carrito = [];

function imprimir(datos) {
    console.log(datos);
    let cuenta = document.getElementById('cuenta');
    let sin_cuenta = document.getElementById('sin-cuenta');
    if (datos.length == 0) {
        cuenta.hidden = true;
        sin_cuenta.hidden = false;
    } else {
        cuenta.hidden = false;
        sin_cuenta.hidden = true;
        for (let i = 0; i < datos.length; i++) {
            //Obtencion de los datos de cada libro que el usuario ha guardado en su carrito
            let url2 = "http://127.0.0.1:8000/libros/" + datos[i].libro_id;
            let xhReq = new XMLHttpRequest();
            xhReq.open("GET", url2, false);
            xhReq.send(null);
            let libro = JSON.parse(xhReq.responseText);

            let fila = document.createElement('tr');
            let numero = document.createElement('th');
            numero.innerText = i + 1;
            let idproducto = document.createElement('td');
            idproducto.innerText = libro.id;
            idproducto.classList = 'idproducto';
            let titulo = document.createElement('td');
            let url_libro = "http://127.0.0.1:8000/libro/" + libro.id;
            titulo.innerHTML = "<a href='" + url_libro + "'>" + libro.titulo + "</a>";
            let autor = document.createElement('td');
            autor.innerText = libro.autor;
            let precio = document.createElement('td');
            precio.innerText = libro.precio + "€";
            let eliminar = document.createElement('td');
            let boton_eliminar = document.createElement('button');
            boton_eliminar.innerText = 'Eliminar';
            boton_eliminar.classList = 'btn btn-danger';
            boton_eliminar.addEventListener('click', function (e) {
                eliminar_item(datos[i].id);
            });
            ids_carrito.push(datos[i].id);

            fila.append(numero);
            fila.append(idproducto);
            fila.append(titulo);
            fila.append(autor);
            fila.append(precio);
            fila.append(eliminar);
            eliminar.append(boton_eliminar);

            let table_body = document.getElementById('cuenta-table-body');
            table_body.append(fila);

            total = total + parseFloat(libro.precio);
        }

        let precio = document.getElementById('precio');
        precio.innerText = "Total a pagar: " + total.toFixed(2) + "€";
    }
}

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


    //Almacenaremos aquí la información del pedido creado en la tabla de pedidos, nos interesa especialemente el id generado.
    let pedido = await hacerPedido();
    
    //Añadimos los libros a la tabla de Pedidos_Detalle
    let detallesPedido = await anadirDetallesPedido(pedido);
    
    
    let url = "http://127.0.0.1:8000/carrito/" + user_id;
    
    console.log('Pedido realizado correctamente');
    
    //Borrar elementos del carrito
    
    for(let i = 0; i < ids_carrito.length; i++){
        let borrado = await eliminar_item(ids_carrito[i]);
        console.log(borrado);
    }
    window.location = "/compras-y-ventas";
}

async function hacerPedido() {
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

async function anadirDetallesPedido(pedido){
    console.log('Añadiendo detalles del pedido...');
    let url = "http://127.0.0.1:8000/pedidodetalle";
    
    let peticion;
    //Obtención del token CSRF como autenticación
    let token = document.querySelector('meta[name="csrf-token"]').content;

    let libros_carrito = document.getElementsByClassName('idproducto');
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

