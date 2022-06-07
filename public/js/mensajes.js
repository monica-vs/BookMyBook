/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function marcarLeido(id) {
    console.log(id);

    let url = "http://127.0.0.1:8000/mensaje/" + id;

    //Obtención del token CSRF como autenticación
    let token = document.querySelector('meta[name="csrf-token"]').content;
    console.log(url, token);

    let xhr = new XMLHttpRequest();
    xhr.open("PUT", url);

    xhr.setRequestHeader("Accept", "*/*");
    xhr.setRequestHeader('X-CSRF-TOKEN', token);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log(xhr.status);
            console.log(xhr.responseText);
        }
    };

    xhr.send();
    window.location.href = '/mensajes';
}