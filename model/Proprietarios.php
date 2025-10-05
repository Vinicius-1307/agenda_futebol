<?php
require_once 'Database.php';

class Proprietarios
{
    private $id_prop;
    private $nome;
    private $cpf;
    private $rg;
    private $telefone;
    private $email;
    private $senha;
    private $banco;

    function __construct()
    {
        $this->banco = new BancoAgendaFutebol();
    }

    public function createProprietario()
    {
        $stmt = $this->banco->getConexao()->prepare("INSERT INTO proprietarios (id_prop, cpf, rg, telefone, nome, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $this->id_prop, $this->cpf, $this->rg, $this->telefone, $this->nome, $this->email, $this->senha);
        return $stmt->execute();
    }

    public function deleteProfissionais()
    {
        $stmt = $this->banco->getConexao()->prepare("DELETE FROM profissionais WHERE id_prof = ?");
        $stmt->bind_param("i", $this->id_prof);
        return $stmt->execute();
    }

    public function updateProfissionais()
    {
        $stmt = $this->banco->getConexao()->prepare("UPDATE profissionais SET cpf=?,rg=?,telefone=?,ano_cadastro=?,nome=? WHERE id_prof = ?");
        $stmt->bind_param("sssssi", $this->cpf, $this->rg, $this->telefone, $this->ano_cadastro, $this->nome, $this->id_prof);
        $stmt->execute();
    }

    public function login($email, $senha)
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM profissionais WHERE email = ? AND senha = ?");
        $stmt->bind_param("ss", $email, $senha);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows < 1) {
            return false;
        }
        while ($linha = $resultado->fetch_object()) {
            $this->set_id_prop($linha->id_prof);
            $this->setCpf($linha->cpf);
            $this->setRg($linha->rg);
            $this->setTelefone($linha->telefone);
            $this->setAno_cadastro($linha->ano_cadastro);
            $this->setNome($linha->nome);
            $this->setEmail($linha->email);
            $this->setSenha($linha->senha);
        }
        return $this;
    }
    public function readProfissionais($id_prof)
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM profissionais WHERE id_prof = ?");
        $stmt->bind_param("i", $id_prof);
        $stmt->execute();
        $resultado = $stmt->get_result();
        while ($linha = $resultado->fetch_object()) {
            $this->set_id_prop($linha->id_prof);
            $this->setCpf($linha->cpf);
            $this->setRg($linha->rg);
            $this->setTelefone($linha->telefone);
            $this->setAno_cadastro($linha->ano_cadastro);
            $this->setNome($linha->nome);
        }
        return $this;
    }

    public function readAll()
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM proprietarios");
        $stmt->execute();
        $result = $stmt->get_result();
        $vetorProprietarios = array();
        $i = 0;
        while ($linha = mysqli_fetch_object($result)) {
            $vetorProprietarios[$i] = new Proprietarios();
            $vetorProprietarios[$i]->set_id_prop($linha->id_prop);
            $vetorProprietarios[$i]->setCpf($linha->cpf);
            $vetorProprietarios[$i]->setRg($linha->rg);
            $vetorProprietarios[$i]->setTelefone($linha->telefone);
            $vetorProprietarios[$i]->setNome($linha->nome);
            $vetorProprietarios[$i]->setEmail($linha->email);

            $i++;
        }
        return $vetorProprietarios;
    }

    public function getId_prof()
    {
        return $this->id_prof;
    }

    public function set_id_prop($id_prof)
    {
        $this->id_prof = $id_prof;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getAno_cadastro()
    {
        return $this->ano_cadastro;
    }

    public function setAno_cadastro($ano_cadastro)
    {
        $this->ano_cadastro = $ano_cadastro;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of senha
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     *
     * @return  self
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }
}
