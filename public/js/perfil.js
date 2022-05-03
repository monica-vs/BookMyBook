let editar1 = document.getElementById('editar1');
editar1.addEventListener('click', function(e){
    habilitar(e);
});
let editar2 = document.getElementById('editar2');
editar2.addEventListener('click', function(e){
    habilitar(e);
});
let editar3 = document.getElementById('editar3');
editar3.addEventListener('click', function(e){
    habilitar(e);
});

function habilitar(e){
    let b_id = e.target.id; //Obtención del elemento disparador del evento
    let id = b_id.slice(-1) //Obtención del número diferenciador del elemento
    
    let field = document.getElementById('field'+id);
    let guardar = document.getElementById('guardar'+id);
    
    field.disabled = false;
    guardar.disabled = false;
    guardar.hidden = false;
    e.target.hidden = true;
    
}