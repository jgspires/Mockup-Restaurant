<?php
    require_once "ConnectionFactory.php";
    require_once "Funcionario.php";
    class FuncionarioDAO {

        public function search($funcionario) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("select * from funcionarios where cpf=:cpf AND senha=:pwd");
                $cpf = $funcionario->getCpf();
                $pwd = $funcionario->getPassword();
                $sql->bindParam("cpf", $cpf);
                $sql->bindParam("pwd", $pwd);

                $sql->execute();
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $rowCount = 0;

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $rowCount++;
                    $funcionario->setCpf($line['cpf']);
                    $funcionario->setName($line['nome']);
                    $funcionario->setPassword($line['senha']);
                    $funcionario->setIs_admin($line['gerente']);
                }
                if(!$rowCount) // Se não houver linhas, retorna falso.
                    return false;
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function insert($funcionario) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("insert into funcionarios
                VALUES (:cpf, :nome, :senha, :gerente)");
                $nome = $funcionario->getName();
                $cpf = $funcionario->getCpf();
                $senha = $funcionario->getPassword();
                $gerente = $funcionario->getIs_admin();
                $sql->bindParam("cpf", $cpf);
                $sql->bindParam("nome", $nome);
                $sql->bindParam("senha", $senha);
                $sql->bindParam("gerente", $gerente);

                $sql->execute();

                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }
    }
?>