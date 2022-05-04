//Consulta de libros. Obtención de datos en JSON con método GET
let url = "http://127.0.0.1:8000/libros";
fetch(url)
        .then((respuesta) => respuesta.json())
        .then((datos) => imprimir(datos))
        .catch((e) => alert(e.message));

let contenedor_libros = document.getElementById('libros');


function imprimir(datos) {
    console.log(datos);

    for (let i = 0; i < datos.length; i++) {


        //Creación de elementos de cada 'card'
        let card = document.createElement('div');
        card.classList = 'card';
        let card_title = document.createElement('div');
        card_title.classList = 'card-header';
        let card_body = document.createElement('div');
        card_body.classList = 'card-body';
        let card_text = document.createElement('div');
        card_text.classList = 'card-text';
        let botones = document.createElement('div');
        let button_info = document.createElement('button');
        button_info.classList = 'btn btn-dark'
        button_info.innerText = 'Info';
        let button_comprar = document.createElement('button');
        button_comprar.classList = 'btn btn-success';
        button_comprar.innerText = 'Comprar';

        //Obtencion de las categorias
        let url2 = "http://127.0.0.1:8000/categorias";
        let xhReq = new XMLHttpRequest();
        xhReq.open("GET", url2, false);
        xhReq.send(null);
        let jsonCategorias = JSON.parse(xhReq.responseText);

        //Obtencion de la categoria correspondiente al libro actual
        let categoria;
        for (let j = 0; j < jsonCategorias.length; j++) {
            if (jsonCategorias[j].id == datos[i].categoria) {
                categoria = jsonCategorias[j].titulo;
            }
        }

        //Quitamos los libros que pertenecen al usuario autenticado
        if (datos[i].usuario_id == user_id) {
            continue;
        }

        //Evento del boton de info
        button_info.addEventListener('click', function (e) {
            window.location.href = "http://127.0.0.1:8000/libro/" + datos[i].id;
        })

        card_title.innerText = datos[i].titulo;
        card_text.innerHTML = "<b>ISBN: </b>" + datos[i].isbn + "<br>" + "<b>Autor: </b>" + datos[i].autor + "<br>" + "<b>Categoria: </b>" + categoria + "<br>" + "<div class='precio'" + datos[i].precio + "</div>";

        card.append(card_title);
        card.append(card_body);
        card_body.append(card_text);
        card_body.append(botones);
        botones.append(button_info);
        botones.append(button_comprar);
        contenedor_libros.append(card);
    }
}

//Elementos de búsqueda y filtrado
let boton_buscar = document.getElementById('button-addon2');
let barra_busqueda = document.getElementById('b-texto');
let seleccion = document.getElementById('b-seleccion');

//Asignación de eventos a los elementos
boton_buscar.addEventListener('click', function () {
    buscar(barra_busqueda.value);
})
seleccion.addEventListener('change', function () {
    console.log(seleccion.value);
})


//Función de búsqueda por texto
function buscar(texto) {
    //Texto recibido a minúsculas para evitar descartes por diferencias entre mayúsculas y minúsculas
    texto = texto.toLowerCase();
    let titulos = document.getElementsByClassName('card-header');
    for (let i = 0; i < titulos.length; i++) {
        titulo = (titulos[i].innerText).toLowerCase();

        let card = titulos[i].parentElement;
        if (texto == '') {
            card.hidden = false;
        } else {
            if (!titulo.includes(texto)) {
                card.hidden = true;
            } else {
                card.hidden = false;
            }
        }
    }
}