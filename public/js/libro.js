/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function comprar(id) {
    console.log(id);
    console.log(usuario_id);
    let url = "http://127.0.0.1:8000/carrito";

    //Obtención del token CSRF como autenticación
    let token = document.querySelector('meta[name="csrf-token"]').content;
    
    fetch(url, {
        method: 'POST',
        body: JSON.stringify({
            libro_id: id,
            usuario_id: usuario_id
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    }).then(respuesta => respuesta.json())
            .then((datos) => {
                console.log(datos);
                window.location.href = '/micarrito';
            })
            .catch(e => console.log(e.message));
}