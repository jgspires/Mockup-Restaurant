<?php
    require_once "ConnectionFactory.php";
    require_once "Comida.php";
    require_once "Bebida.php";
    require_once "Item.php";
    require_once "AuxiliaryFunctions.php";

    class ItemDAO {
        public function search_all($item) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("select * from itens");

                $sql->execute();
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $arr = array();
                $rowCount = 0;

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $rowCount++;
                    if($line['tipo'] == 1) {
                        $newItem = new Comida();
                        $newItem->setDesc($line['descSupplier']);
                        $newItem->setIngredients($line['ingredientes']);
                    }
                    else if($line['tipo'] == 2) {
                        $newItem = new Bebida();
                        $newItem->setSupplier($line['descSupplier']);
                    }
                    $newItem->setCode($line['codItens']);
                    $newItem->setName($line['nome']);
                    $aux = format_bonus($line['preco']);
                    $newItem->setPrice($aux);
                    
                    array_push($arr, $newItem);
                }
                $item->setList($arr);
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function search_code_order($item, $order) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("select * from itens where codItens=:code");
                $code = $item->getCode();
                $sql->bindParam("code", $code);

                $sql->execute();
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $rowCount = 0;

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $rowCount++;
                    if($line['tipo'] == 1) {
                        $item = new Comida();
                        $item->setDesc($line['descSupplier']);
                        $item->setIngredients($line['ingredientes']);
                    }
                    else if($line['tipo'] == 2) {
                        $item = new Bebida();
                        $item->setSupplier($line['descSupplier']);
                    }
                    $item->setCode($line['codItens']);
                    $item->setName($line['nome']);
                    $item->setPrice($line['preco']);
                }
                $order->setItem($item);
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function search_once($item) {
            try{
                if($item instanceof Comida)
                    $tipo = 1;
                else if ($item instanceof Bebida)
                    $tipo = 2;
                else if ($item instanceof Item)
                    $tipo = 'both';
                
                $conn = ConnectionFactory::getConnection();
                
                if($tipo == 1 || $tipo == 2) {
                    $sql = $conn->prepare("select * from itens where nome LIKE :nome AND tipo=:tipo");
                    $sql->bindParam("tipo",$tipo);
                }
                else if($tipo == 'both') {
                    $sql = $conn->prepare("select * from itens where nome LIKE :nome");
                }
    
                $nome = "%".$item->getName()."%";  
                $sql->bindParam("nome",$nome);
                    
                $sql->execute();
                
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $arr = array();

                //echo var_dump($sql);

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    //echo "tipo: ".$line['tipo'];
                    if($line['tipo'] == 1) {
                        $newitem = new Comida();
                        $newitem->setDesc($line['descSupplier']);
                        $newitem->setIngredients($line['ingredientes']);
                    }
                    else if($line['tipo'] == 2){
                        $newitem = new Bebida();
                        $newitem->setSupplier($line['descSupplier']);
                    }
                    $newitem->setCode($line['codItens']);
                    $newitem->setName($line['nome']);
                    $aux = format_bonus($line['preco']);
                    $newitem->setPrice($aux);
                    array_push($arr, $newitem);
                }
                $item->setList($arr);
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;    

        }

        public function insert($item) {
            try{
                $conn = ConnectionFactory::getConnection();
                if($item instanceof Comida) {
                    $sql = $conn->prepare("insert into itens (nome,preco,tipo,descSupplier,ingredientes) VALUES (:nome,:preco,1,:descSupplier,:ingredientes)");
                    $ingredientes = $item->getIngredients();
                    $desc = $item->getDesc();
                    $sql->bindParam("ingredientes",$ingredientes);
                    $sql->bindParam("descSupplier",$desc);
                    echo 'hello';
                }   
                if($item instanceof Bebida) {
                    $sql = $conn->prepare("insert into itens (nome,preco,tipo,descSupplier) VALUES (:nome,:preco,2,:descSupplier)");
                    $supplier = $item->getSupplier();
                    $sql->bindParam("descSupplier",$supplier);
                }     
                $nome = $item->getName();
                $preco = $item->getPrice();
                $sql->bindParam("nome",$nome);
                $sql->bindParam("preco",$preco);

                $sql->execute();
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function update($item) {
            try{
                $conn = ConnectionFactory::getConnection();
                $codItem = $item->getCode();
                if($item instanceof Comida) {
                    $sql = $conn->prepare("update itens set nome=:nome, preco=:preco, tipo=1, descSupplier=:desc, ingredientes=:ingredientes where codItens=:codItem");
                    $ingredientes = $item->getIngredients();
                    $desc = $item->getDesc();
                    $sql->bindParam("ingredientes",$ingredientes);
                    $sql->bindParam("desc",$desc);
                }   
                if($item instanceof Bebida) {
                    $sql = $conn->prepare("update itens set nome=:nome, preco=:preco, tipo=2, descSupplier=:supplier where codItens=:codItem");
                    $supplier = $item->getSupplier();
                    $sql->bindParam("supplier",$supplier);
                }     
                $nome = $item->getName();
                $preco = $item->getPrice();
                $sql->bindParam("nome",$nome);
                $sql->bindParam("preco",$preco);
                $sql->bindParam("codItem",$codItem);

                $sql->execute();
                return true;
            }
            catch(PDOException $e) {
                //echo $e->getMessage();
                return false;
            }
            $conn = null;
        }

        public function delete($item) {
            try{
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("delete from itens where codItens=:codItem");
                $codItem = $item->getCode();
                $sql->bindParam("codItem",$codItem);

                $sql->execute();
                return true;
            }
            catch(PDOException $e) {
                echo $e->getMessage();
                return false;
            }
            $conn = null;
        }
    }

?>