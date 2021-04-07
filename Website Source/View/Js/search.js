var url = window.location.href;
var screen;
var tab;

if(url.includes("Restaurante/View/cardapio.php")){
    screen = "cardapio";
    
}   
else if(url.includes("Restaurante/View/gerencia.php")){
    screen = "gerencia";
}

if(screen == "gerencia") {
    var itemSearchBar = document.getElementById('find_inputSuccess');
    var costumerSearchBar = document.getElementById('costumers_inputSuccess');
    setTab(0);
}
else if(screen == "cardapio") {
    var searchBar = document.getElementById('inputSuccess');
    searchBar.addEventListener('keypress',search_item);
}

function setTab(id) {
    tab = id;
    if(tab == 0) {
        requestSim("../Controller/ControllerItem.php?mode=search_all");
        itemSearchBar = document.getElementById('find_inputSuccess');
        itemSearchBar.addEventListener('keypress',search_item);
        costumerSearchBar.removeEventListener('keypress',search_costumers);

    }
    else if(tab == 1) {
        requestSim("../Controller/ControllerCliente.php?mode=search_all");
        costumerSearchBar = document.getElementById('costumers_inputSuccess');
        costumerSearchBar.addEventListener('keypress',search_costumers);
        itemSearchBar.removeEventListener('keypress',search_item);
    }
}

if(screen == "gerencia") {
    document.body.addEventListener("load", requestSim("../Controller/ControllerItem.php?mode=search_all"));
}
else if(screen == "cardapio") {
    document.body.addEventListener("load", requestSim("../Controller/ControllerItem.php?mode=search_all"));
}




function requestSim(url) {
    let xhttp = new XMLHttpRequest(); 
    let loader = document.getElementById('load');

    xhttp.onreadystatechange = function() { 
        if (this.readyState == 4 && this.status == 200) { 
            
            loader.style="display:none;";
            /* Pega o JSON enviado pelo banco e decodifica em formato JavaScript Object. Além disso, a função
            decodeURI transforma caracteres UTF-8 em caracteres legiveis. */
            let items = JSON.parse(decodeURIComponent(this.responseText));
            switch(screen) {
                case "cardapio":
                    fillMenuTable(items);
                break;
                case "gerencia":
                    if(tab == 0)
                        fillManagerItemTable(items);
                    else if(tab == 1)
                        fillCostumerTable(items);
                break;
                
            }
        }
        else if(this.readyState == 1 && this.status == 0)
            loader.style="display:block;";

        else if(this.readyState == 4 && this.status == 0){
            loader.style="display:none;";
            searchModal("Erro","Não foi possível se conectar ao servidor.");
        }
            
        else if (this.readyState == 4 && this.status == 404){
            loader.style="display:none;";
            searchModal("Erro","Ops, não achamos essa página.");
        }
            
        else if (this.readyState == 4 && this.status == 403){
            loader.style="display:none;";
            searchModal("Erro","Usuário não autorizado.");
        }
            
    };
 
  xhttp.open("GET", url, true);
  xhttp.responseType="text";
  xhttp.send(); 
}


function search_item(e){
    if(e.keyCode == 13){
        if(screen == "cardapio") {
            var query = searchBar.value;
        }
        else if(screen == "gerencia") {
            var query = itemSearchBar.value;
        }
        let food = document.getElementById('chkbox_food').checked;
        let bvg = document.getElementById('chkbox_beverage').checked;
        requestSim("../Controller/ControllerItem.php?food="+food+"&bvg="+bvg+"&query="+query+"&mode=search_once");
    }
        
}

function search_costumers(e){
    if(e.keyCode == 13){
        var query = costumerSearchBar.value;
        requestSim("../Controller/ControllerCliente.php?query="+query+"&mode=search_table");
    }
        
}


function searchModal(title,body){
    let searchModalTitle = document.getElementById('searchModalTitle');
    let searchModalBody = document.getElementById('searchModalBody');
    
    searchModalTitle.innerHTML = title;
    searchModalBody.innerHTML = body;
    $('#searchModal').modal('show');
}

function fillMenuTable(res){
    let table = document.getElementById('searchTable');
    table.innerHTML="";
    if(res!=0){
        for(let i in res){
            let num = parseInt(i) + 1;
            let row = table.insertRow(i);
            let nome = row.insertCell(-1);
            let preco = row.insertCell(-1);
            let acoes = row.insertCell(-1);
            row.id = num;
            nome.id = "item_name-"+num;
            preco.id = "item_price-"+num;
            acoes.id = "item_actions-"+num;
            nome.innerHTML = "<b>"+res[i].nome+"</b>";
            preco.innerHTML = "R$"+res[i].preco;
            // Atributos escondidos usados para preencher a modal de informações
            let codItem = row.insertCell(-1);
            codItem.innerHTML = res[i].codItem;
            codItem.hidden = true;
            codItem.id = "item_code-"+num;
            if(res[i].desc != null) {
                let desc = row.insertCell(-1);
                desc.innerHTML = res[i].desc;
                desc.hidden = true;
                desc.id = "item_desc-"+num;
                let ingred = row.insertCell(-1);
                ingred.innerHTML = res[i].ingred;
                ingred.hidden = true;
                ingred.id = "item_ingred-"+num;
                let type = row.insertCell(-1);
                type.innerHTML = 1;
                type.hidden = true;
                type.id = "item_type-"+num;
            }
            else if(res[i].supplier != null) {
                let supplier = row.insertCell(-1);
                supplier.innerHTML = res[i].supplier;
                supplier.hidden = true;
                supplier.id = "item_sup-"+num;
                let type = row.insertCell(-1);
                type.innerHTML = 2;
                type.hidden = true;
                type.id = "item_type-"+num;
            }
            //Dá um append de um filho na table data acoes. Cada filho será posto antes do ultimo filho: beforeend
            acoes.insertAdjacentHTML("beforeend",'<span data-toggle="modal" data-target="#infoModal"><button type="button" id="info-" class="kitchenbtn btn-info" onclick=setInfoTextMenu(this.id) data-toggle="tooltip" data-placement="bottom" title="Detalhes"><i class="glyphicon glyphicon-info-sign"></i></button></span>');
            document.getElementById("info-").id = "info-"+num;
            acoes.insertAdjacentHTML("beforeend", '<span data-toggle="modal" data-target="#addModal" style="padding-left:4px;"><button type="button" id="add-" onclick=setAddModalCode(' + codItem.innerHTML + ') class="kitchenbtn btn-success" data-toggle="tooltip" data-placement="bottom" title="Adicionar ao Pedido"><i class="glyphicon glyphicon-plus"></i></button></span>');
            document.getElementById("add-").id = "add-"+num;
        }
    }
    else {
        table.innerHTML = "Nenhum resultado.";
    }
}

function fillManagerItemTable(res){
    let table = document.getElementById('searchTable');
    table.innerHTML="";
    if(res!=0){
        for(let i in res){
            let num = parseInt(i) + 1;
            let row = table.insertRow(i);
            let codItem = row.insertCell(-1);
            let nome = row.insertCell(-1);
            let acoes = row.insertCell(-1);
            codItem.innerHTML = "<b>"+res[i].codItem+"</b>";
            nome.innerHTML = res[i].nome;
            row.id = num;
            nome.id = "item_name-" + num;
            // Atributos Escondidos
            let printCode = row.insertCell(-1);
            let preco = row.insertCell(-1);
            preco.innerHTML = res[i].preco;
            preco.hidden = true;
            preco.id = "item_price-"+num;
            printCode.innerHTML = res[i].codItem;
            printCode.id = "item_code-" + num;
            printCode.hidden = true;
            if(res[i].desc != null) {
                let desc = row.insertCell(-1);
                desc.innerHTML = res[i].desc;
                desc.hidden = true;
                desc.id = "item_desc-"+num;
                let ingred = row.insertCell(-1);
                ingred.innerHTML = res[i].ingred;
                ingred.hidden = true;
                ingred.id = "item_ingred-"+num;
                let type = row.insertCell(-1);
                type.innerHTML = 1;
                type.hidden = true;
                type.id = "item_type-"+num;
            }
            else if(res[i].supplier != null) {
                let supplier = row.insertCell(-1);
                supplier.innerHTML = res[i].supplier;
                supplier.hidden = true;
                supplier.id = "item_sup-"+num;
                let type = row.insertCell(-1);
                type.innerHTML = 2;
                type.hidden = true;
                type.id = "item_type-"+num;
            }
            //Dá um append de um filho na table data acoes. Cada filho será posto antes do ultimo filho: beforeend
            acoes.insertAdjacentHTML("beforeend",'<span data-toggle="modal" data-target="#infoModal"><button type="button" id="info-" onclick=setInfoTextManager(this.id) class="kitchenbtn btn-info" data-toggle="tooltip" data-placement="bottom" title="Detalhes"><i class="glyphicon glyphicon-info-sign"></i></button></span>');
            document.getElementById("info-").id = "info-"+num;
            acoes.insertAdjacentHTML("beforeend",'<span data-toggle="modal" data-target="#alterModal" style="padding-left:4px;"><button type="button" id="alter-" onclick=setAlterModalText(this.id) class="kitchenbtn btn-neutral" data-toggle="tooltip" data-placement="bottom" title="Alterar"><i class="glyphicon glyphicon-pencil"></i></button></span>');
            document.getElementById("alter-").id = "alter-"+num;
            acoes.insertAdjacentHTML("beforeend", '<span data-toggle="modal" data-target="#excludeModal" style="padding-left:4px;"><button type="button"  onclick=setManagerDeleteLinkId(this.id) id="delete_item-" class="kitchenbtn btn-cancel" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="glyphicon glyphicon-trash"></i></button></span>');
            document.getElementById("delete_item-").id = "delete_item-"+num;
        }
    }
    else {
        table.innerHTML = "Nenhum resultado.";
    }
}

function fillCostumerTable(res){
    let table = document.getElementById('costumer_table');
    table.innerHTML="";
    if(res!=0){
        for(let i in res){
            let num = parseInt(i) + 1;
            let row = table.insertRow(i);
            let code = row.insertCell(-1);
            let nome = row.insertCell(-1);
            let bonus = row.insertCell(-1);
            let acoes = row.insertCell(-1);
            row.id = num;
            //code.id = "client_code-"+num;
            nome.id = "client_name-"+num;
            bonus.id = "client_bonus-"+num;
            acoes.id = "client_actions-"+num;
            code.innerHTML = "<b>"+res[i].codCliente+"</b>";
            nome.innerHTML = res[i].nome;
            bonus.innerHTML = "R$"+res[i].bonus_value;
            bonus.innerHTML = bonus.innerHTML.replace('.', ',');
            // Atributo escondido
            let printCode = row.insertCell(-1);
            printCode.innerHTML = res[i].codCliente;
            printCode.id = "client_code-" + num;
            printCode.hidden = true;
            //Dá um append de um filho na table data acoes. Cada filho será posto antes do ultimo filho: beforeend
            acoes.insertAdjacentHTML("beforeend",'<span data-toggle="modal" data-target="#excludeModal"><button type="button" id="delete_costumer-" onclick=setCostumerDeleteLinkId(this.id) class="kitchenbtn btn-cancel" data-toggle="tooltip" data-placement="bottom" title="Excluir Cliente"><i class="glyphicon glyphicon-trash"></i></button></span>');
            document.getElementById("delete_costumer-").id = "delete_costumer-"+num;
        }
    }
    else {
        table.innerHTML = "Nenhum resultado.";
    }
}
{/*  */}