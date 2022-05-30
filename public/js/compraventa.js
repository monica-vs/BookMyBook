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

function mostrar(e) {
    let enlace = e.target;
    console.log(enlace.classList);
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