//Consulta de libros. Obtención de datos en JSON con método GET
let url = "http://127.0.0.1:8000/libros";
fetch(url)
        .then((respuesta) => respuesta.json())
        .then((datos) => imprimir(datos))
        .catch((e) => alert(e.message));

let contenedor_libros = document.getElementById('libros');


function imprimir(datos) {
    let load = document.getElementById('c-load');
    load.hidden = true;

    for (let i = 0; i < datos.length; i++) {

        if (datos[i].disponible == 1) {
            //Creación de elementos de cada 'card'
            let card = document.createElement('div');
            card.classList = 'card';
            let card_title = document.createElement('div');
            card_title.classList = 'card-header';
            let card_img = document.createElement('img');
            card_img.classList = 'card-img-top';
            let card_body = document.createElement('div');
            card_body.classList = 'card-body';
            let card_text = document.createElement('div');
            card_text.classList = 'card-text';
            let precio = document.createElement('div');
            precio.classList = 'precio';
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

            //Evento del boton de info y del botón comprar
            button_info.addEventListener('click', function (e) {
                window.location.href = "http://127.0.0.1:8000/libro/" + datos[i].id;
            })

            button_comprar.addEventListener('click', function (e) {
                comprar(datos[i].id);
            });

            card_title.innerText = datos[i].titulo;
            card_text.innerHTML = "<span class='isbn'><b>ISBN: </b>" + datos[i].isbn + "</span><br>" + "<span class='autor'><b>Autor: </b>" + datos[i].autor + "</span><br>" + "<span class='categoria'><b>Categoria: </b>" + categoria + "</span><span class='categoria-id' hidden='hidden'>" + datos[i].categoria + "</span><br>" + "<span class='precio'><div class='precio'" + datos[i].precio + "</span></div>";
            precio.innerText = datos[i].precio + '€';

            if (datos[i].imagen == null) {
                card_img.src = 'https://img.freepik.com/free-vector/blank-book-cover-white-vector-illustration_1284-41903.jpg?t=st=1652052153~exp=1652052753~hmac=164eebdee34e2f8e4bccff592e98e9673cd38ee380948fc667588434c374ba6b&w=740';
            } else {
                card_img.src = datos[i].imagen;
            }


            card.append(card_title);
            card.append(card_img);
            card.append(card_body);
            card_body.append(card_text);
            card_body.append(precio);
            card_body.append(botones);
            botones.append(button_info);
            botones.append(button_comprar);
            contenedor_libros.append(card);
        }
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
    filtrar(seleccion.value);
})


//Función de búsqueda por texto
function buscar(texto) {
    //Texto recibido a minúsculas para evitar descartes por diferencias entre mayúsculas y minúsculas
    texto = texto.toLowerCase();
    let titulos = document.getElementsByClassName('card-header');
    let autores = document.getElementsByClassName('autor');
    let isbns = document.getElementsByClassName('isbn');
    let categorias = document.getElementsByClassName('categoria');

    for (let i = 0; i < titulos.length; i++) {
        titulo = (titulos[i].innerText).toLowerCase();
        autor = (autores[i].innerText).toLowerCase();
        isbn = (isbns[i].innerText);
        categoria = (categorias[i].innerText).toLowerCase();

        let card = titulos[i].parentElement;
        if (texto == '') {
            card.hidden = false;
        } else {
            if (!titulo.includes(texto) && !autor.includes(texto) && !isbn.includes(texto) && !categoria.includes(texto)) {
                card.hidden = true;
            } else {
                card.hidden = false;
            }
        }
    }
}

function filtrar(categoria_id) {
    let cards = document.getElementsByClassName('card');
    for (let i = 0; i < cards.length; i++) {
        cards[i].hidden = true;
        if (categoria_id == 0) {
            cards[i].hidden = false;
        }
    }
    let cat_libros = document.getElementsByClassName('categoria-id');
    for (let j = 0; j < cat_libros.length; j++) {
        if (cat_libros[j].innerText == categoria_id) {
            let card = cat_libros[j].closest('.card');
            card.hidden = false;
        }
    }
}

function comprar(id) {
    console.log(id);

    let url = "http://127.0.0.1:8000/carrito";

    //Obtención del token CSRF como autenticación
    let token = document.querySelector('meta[name="csrf-token"]').content;
    let param = new FormData();
    param.append('token', token);
    param.append('libro_id', id);

    fetch(url, {
        method: 'POST',
        body: JSON.stringify({
            libro_id: id,
            usuario_id: user_id
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    }).then(respuesta => respuesta.json())
            .then((datos) => console.log(datos))
            .catch(e => console.log(e.message));

    window.location.href = '/micarrito';
}