/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

console.log(lib_usu_id)

//Obtencion del usuario dueño del libro
        let url = "http://127.0.0.1:8000/users/"+lib_usu_id;
        let xhReq = new XMLHttpRequest();
        xhReq.open("GET", url, false);
        xhReq.send(null);
        let lib_usu = JSON.parse(xhReq.responseText);
        
console.log(lib_usu);

let p_vendedor = document.getElementById('vendedor');
p_vendedor.innerText = p_vendedor.innerText +' '+ lib_usu[0].name;