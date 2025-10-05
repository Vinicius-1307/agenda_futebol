<?php
require_once 'Database.php';

class Campos
{
    private $id_campo;
    private $nome;
    private $inicio_jogos;
    private $final_jogos;
    private $banco;

    function __construct()
    {
        $this->banco = new BancoAgendaFutebol();
    }

    public function createCampo()
    {
        $stmt = $this->banco->getConexao()->prepare("INSERT INTO campos (id_campo, nome, inicio_jogos, final_jogos) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issss", $this->id_campo, $this->nome, $this->inicio_jogos, $this->final_jogos);
        return $stmt->execute();
    }
}
