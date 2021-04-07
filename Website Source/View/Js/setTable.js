  function getNumId(id) {
    return (id.substring(id.search("-")+1));
  }
  
  function setKitchenDeleteLinkId(id) {
    var id_num = getNumId(id);
    document.getElementById("delete_link").href = "../Controller/ControllerPedido.php?mode=delete_kitchen&id=" + id_num;
  }

  function setMenuDeleteLinkId(id) {
    var id_num = getNumId(id);
    document.getElementById("delete_link").href = "../Controller/ControllerPedido.php?mode=delete_menu&id=" + id_num;
  }

  function setCostumerDeleteLinkId(id) {
    var id_num = getNumId(id);
    var code = document.getElementById("client_code-" + id_num).innerHTML;
    document.getElementById("delete_link").href = "../Controller/ControllerCliente.php?mode=delete&id=" + code;
  }


  function setAddModalCode(id_num) {
    document.getElementById("add_code").value = id_num;
  }

  function setInfoTextKitchen(id) {
    var id_num = getNumId(id);
    var type = document.getElementById("item_type-" + id_num).innerHTML;
    document.getElementById("info_modal_title").innerHTML = document.getElementById("item_name-" + id_num).innerHTML;
    if(type == 1) {
      document.getElementById("info_modal_desc_name").innerHTML = "Descrição:";
      document.getElementById("info_modal_desc_text").innerHTML = document.getElementById("item_desc-" + id_num).innerHTML;
      document.getElementById("info_modal_ingred_text").innerHTML = document.getElementById("item_ingred-" + id_num).innerHTML;
      document.getElementById("info_modal_ingred_li").hidden = false;
      document.getElementById("info_modal_ingred_li").classList.add("list-group-item");
    }
    else {
      document.getElementById("info_modal_desc_name").innerHTML = "Fornecedor:";
      document.getElementById("info_modal_desc_text").innerHTML = document.getElementById("item_sup-" + id_num).innerHTML;
      document.getElementById("info_modal_ingred_li").hidden = true;
      document.getElementById("info_modal_ingred_li").classList.remove("list-group-item");
    }
  }

  function setInfoTextMenu(id) {
    setInfoTextKitchen(id);
    var id_num = getNumId(id);
    document.getElementById("info_modal_code").innerHTML = document.getElementById("item_code-" + id_num).innerHTML;
    document.getElementById("info_modal_price").innerHTML = document.getElementById("item_price-" + id_num).innerHTML;
  }

  function setInfoTextManager(id) {
    setInfoTextKitchen(id);
    setInfoTextMenu(id);
    var id_num = getNumId(id);
    var type = document.getElementById("item_type-" + id_num).innerHTML;
    if(type == 1) {
      document.getElementById("info_modal_type").innerHTML = "Comida";
    }
    else {
      document.getElementById("info_modal_type").innerHTML = "Bebida";
    }
  }

  function setAlterModalText(id) {
    var id_num = getNumId(id);
    document.getElementById("alter_code").value = document.getElementById("item_code-" + id_num).innerHTML;
    var type = document.getElementById("item_type-" + id_num).innerHTML;
    if(type == 1) {
      document.getElementById("alter_food").checked = true;
      document.getElementById("alter_beverage").checked = false;
      toggle("alter");
      document.getElementById("alter_desc").value = document.getElementById("item_desc-" + id_num).innerHTML;
      document.getElementById("alter_ingred").value = document.getElementById("item_ingred-" + id_num).innerHTML;
      document.getElementById("alter_supplier").value = "";
    }
    else {
      document.getElementById("alter_food").checked = false;
      document.getElementById("alter_beverage").checked = true;
      toggle("alter");
      document.getElementById("alter_supplier").value = document.getElementById("item_sup-" + id_num).innerHTML;
      document.getElementById("alter_desc").value = "";
      document.getElementById("alter_ingred").value = "";
    }
    document.getElementById("alter_name").value = document.getElementById("item_name-" + id_num).innerHTML;
    document.getElementById("item_price-" + id_num).innerHTML = document.getElementById("item_price-" + id_num).innerHTML.replace(/,/g, '.')
    document.getElementById("alter_price").value = document.getElementById("item_price-" + id_num).innerHTML;
  }

  // Usado por gerencia.php
  function toggle(which){ // "which" usado para identificar em qual formulário o toggle ocorrerá.
      let food;
      let descDiv;
      let ingredDiv;
      let supplierDiv; 
      let desc;
      let ingred; 
      let supplier; 
      switch(which) {
        case "add":
          food = document.getElementById("food");
          descDiv = document.getElementById("descDiv");
          ingredDiv = document.getElementById("ingredDiv");
          supplierDiv = document.getElementById("supplierDiv");
          desc = document.getElementById('desc');
          ingred = document.getElementById('ingred');
          supplier = document.getElementById('supplier');
          break;
        case "alter":
          food = document.getElementById("alter_food");
          descDiv = document.getElementById("alter_descDiv");
          ingredDiv = document.getElementById("alter_ingredDiv");
          supplierDiv = document.getElementById("alter_supplierDiv");
          desc = document.getElementById('alter_desc');
          ingred = document.getElementById('alter_ingred');
          supplier = document.getElementById('alter_supplier');
          break;
      }
      
      if(food.checked) {
          descDiv.classList.remove("hide");
          ingredDiv.classList.remove("hide");
          supplierDiv.classList.add("hide");
          supplier.removeAttribute("required");
          desc.setAttribute("required", "true");
          ingred.setAttribute("required", "true");
      } 
      else {
          descDiv.classList.add("hide");
          ingredDiv.classList.add("hide");
          supplierDiv.classList.remove("hide");
          desc.removeAttribute("required");
          ingred.removeAttribute("required");
          supplier.setAttribute("required", "true");
      }

  }

  function setManagerDeleteLinkId(id) {
    var id_num = getNumId(id);
    var code = document.getElementById("item_code-" + id_num).innerHTML;
    document.getElementById("delete_link").href = "../Controller/ControllerItem.php?mode=delete&id=" + code;
  }