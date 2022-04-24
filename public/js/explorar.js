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
        for(let j= 0; j < jsonCategorias.length; j++){
            if(jsonCategorias[j].id == datos[i].categoria){
                categoria = jsonCategorias[j].titulo;
            }
        }
        
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