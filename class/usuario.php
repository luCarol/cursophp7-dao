<?php

use FFI\Exception;

class Usuario {
    private $idusuario;
    private $deslogin;
    private $desenha;
    private $dtcadastro;

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getDeslogin() {
        return $this->deslogin;
    }

    public function setDeslogin($deslogin) {
        $this->deslogin = $deslogin;
    }

    public function getDesenha() {
        return $this->desenha;
    }

    public function setDesenha($desenha) {
        $this->desenha = $desenha;
    }

    public function getDtcadastro() {
        return $this->dtcadastro;
    }

    public function setDtcadastro($dtcadastro) {
        $this->dtcadastro = $dtcadastro;
    }

    public function loadById($id) {
        
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ":ID"=>$id
        ));

        if (count($results) > 0) {

            $row = $results[0];

            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDesenha($row['desenha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));

        }
    }

    public function __toString() {
        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "desenha"=>$this->getDesenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
        ));
    }

    public static function getList() {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

    }

    public static function search($login) {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH'=>"%".$login."%"
        ));
    }

    public function login($login, $password) {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND desenha = :PASSWORD", array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));

        if (count($results) > 0) {

            $row = $results[0];

            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDesenha($row['desenha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));

        } else {
            throw new Exception("Login e/ou senha inválidos");
        }
    }

}

?>