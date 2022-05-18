let formularioLibros = document.getElementById('f-libro');
let listaLibros = document.getElementById('l-libros');
listaLibros.hidden = true;

let anadirLibro = document.getElementById('anadir-libro');
anadirLibro.addEventListener('click', function (e) {
    mostrar(e);
})

let misLibros = document.getElementById('mis-libros');
misLibros.addEventListener('click', function (e) {
    mostrar(e);
})

let url = "http://127.0.0.1:8000/libros";
fetch(url)
        .then((respuesta) => respuesta.json())
        .then((datos) => imprimir(datos))
        .catch((e) => alert(e.message));

function mostrar(e) {
    let enlace = e.target;
    console.log(enlace.classList);
    switch (enlace.id) {
        case 'anadir-libro':
            formularioLibros.hidden = false;
            listaLibros.hidden = true;
            break;
        case 'mis-libros':
            formularioLibros.hidden = true;
            listaLibros.hidden = false;
            break;
    }
    anadirLibro.classList.toggle('active');
    anadirLibro.classList.toggle('link-dark');
    misLibros.classList.toggle('active');
    misLibros.classList.toggle('link-dark');
}

function imprimir(datos) {
    let mislibros = new Array();
    let cTable = document.getElementById('c-table');
    console.log(cTable);
    for (let i = 0; i < datos.length; i++) {
        if (datos[i].usuario_id == user_id) {
            let libro = datos[i];
            mislibros.push(libro);
        }
    }

    for (let j = 0; j < mislibros.length; j++) {
        let fila = document.createElement('tr');
        let id = document.createElement('td');
        id.innerText = mislibros[j].id;
        id.classList.add('id');
        let isbn = document.createElement('td');
        isbn.innerText = mislibros[j].isbn;
        let titulo = document.createElement('td');
        titulo.innerText = mislibros[j].titulo;
        let autor = document.createElement('td');
        autor.innerText = mislibros[j].autor;
        let categoria = document.createElement('td');
        categoria.innerText = getNombreCategoria(mislibros[j].categoria);
        let precio = document.createElement('td');
        precio.innerText = mislibros[j].precio;
        let eliminarTd = document.createElement('td');
        let eliminar = document.createElement('button');
        eliminar.type = "button";
        eliminar.classList = 'btn btn-danger';
        eliminar.innerText = 'Eliminar';
        eliminar.addEventListener('click', function (e) {
            eliminarLibro(e);
        })

        fila.append(id);
        fila.append(isbn);
        fila.append(titulo);
        fila.append(autor);
        fila.append(categoria);
        fila.append(precio);
        eliminarTd.append(eliminar);
        fila.append(eliminarTd);

        cTable.append(fila);

    }
}

function getNombreCategoria(cat_id) {
    let url = "http://127.0.0.1:8000/categorias";
    let xhReq = new XMLHttpRequest();
    xhReq.open("GET", url, false);
    xhReq.send(null);
    let jsonCategorias = JSON.parse(xhReq.responseText);

    //Obtencion de la categoria correspondiente al libro actual
    let categoria;
    for (let j = 0; j < jsonCategorias.length; j++) {
        if (jsonCategorias[j].id == cat_id) {
            categoria = jsonCategorias[j].titulo;
        }
    }
    return categoria;
}

function eliminarLibro(e) {
    let boton = e.target;
    let fila = boton.closest('tr');
    let id = fila.querySelector('.id').innerText;
    fetch("http://127.0.0.1:8000/libros" + id, {
        method: 'DELETE',
    })
            .then(response => response.json())
            .catch((e) => alert(e.message));
}