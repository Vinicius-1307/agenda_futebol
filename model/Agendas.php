
<?php
require_once 'Database.php';

class Agendas
{
    private $id;
    private $cpf_cliente;
    private $id_horario;
    private $id_servico_prof;
    private $dia_semana;
    private $horario_inicio;
    private $horario_fim;
    private $banco;

    function __construct()
    {
        $this->banco = new BancoAgendaFutebol();
    }

    public function createAgendas()
    {
        $stmt = $this->banco->getConexao()->prepare("INSERT INTO agendas (id, cpf_cliente, id_horario, id_servico_prof) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $this->id, $this->cpf_cliente, $this->id_horario, $this->id_servico_prof);
        return $stmt->execute();
    }

    public function deleteAgendas()
    {
        $stmt = $this->banco->getConexao()->prepare("DELETE FROM agendas WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function deleteAgendaIdHorario()
    {
        $stmt = $this->banco->getConexao()->prepare("DELETE FROM agendas WHERE id_horario = ?");
        $stmt->bind_param("i", $this->id_horario);
        return $stmt->execute();
    }

    public function deleteServico_profissional(array $ids)
    {
        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $query = "DELETE FROM servico_profissional WHERE id_servico_prof IN ($placeholders)";
            $stmt = $this->banco->getConexao()->prepare($query);

            $types = str_repeat('i', count($ids));

            $stmt->bind_param($types, ...$ids);

            return $stmt->execute();
        }
    }

    public function deleteAgendasArray(array $ids)
    {
        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $query = "DELETE FROM agendas WHERE id_servico_prof IN ($placeholders)";
            $stmt = $this->banco->getConexao()->prepare($query);

            $types = str_repeat('i', count($ids));

            $stmt->bind_param($types, ...$ids);

            return $stmt->execute();
        }
    }

    public function updateAgendas()
    {
        $stmt = $this->banco->getConexao()->prepare("UPDATE agendas SET cpf_cliente=?,id_horario=?,id_servico_prof=? WHERE id = ?");
        $stmt->bind_param("siii", $this->cpf_cliente, $this->id_horario, $this->id_servico_prof, $this->id);
        $stmt->execute();
    }

    public function readAgendas($id)
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM agendas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        while ($linha = $resultado->fetch_object()) {
            $this->setId($linha->id);
            $this->setCpf_cliente($linha->cpf_cliente);
            $this->setId_horario($linha->id_horario);
            $this->setId_servico_prof($linha->id_servico_prof);
        }
        return $this;
    }

    public function agendaHorarioUsuario($cpfCliente)
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM agendas INNER JOIN horarios ON agendas.id = horarios.id_horario WHERE cpf_cliente = ?");
        $stmt->bind_param("s", $cpfCliente);
        $stmt->execute();
        $result = $stmt->get_result();
        $vetorAgendas = array();
        $i = 0;
        while ($linha = mysqli_fetch_object($result)) {
            $vetorAgendas[$i] = new Agendas();
            $vetorAgendas[$i]->setId($linha->id);
            $vetorAgendas[$i]->setCpf_cliente($linha->cpf_cliente);
            $vetorAgendas[$i]->setId_horario($linha->id_horario);
            $vetorAgendas[$i]->setId_servico_prof($linha->id_servico_prof);
            $vetorAgendas[$i]->setHorario_inicio($linha->horario_inicio);
            $vetorAgendas[$i]->setHorario_fim($linha->horario_fim);
            $vetorAgendas[$i]->setDia_semana($linha->dia_semana);

            $i++;
        }
        return $vetorAgendas;
    }

    public function agendaHorarioBarbeiro($idsServicosProf)
    {
        if (empty($idsServicosProf)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($idsServicosProf), '?'));

        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM agendas a INNER JOIN horarios h ON a.id = h.id_horario WHERE a.id_servico_prof IN ($placeholders)");

        $types = str_repeat('i', count($idsServicosProf));
        $stmt->bind_param($types, ...$idsServicosProf);

        $stmt->execute();
        $result = $stmt->get_result();

        $vetorAgendas = [];
        while ($linha = mysqli_fetch_object($result)) {
            $agenda = new Agendas();
            $agenda->setId($linha->id);
            $agenda->setCpf_cliente($linha->cpf_cliente);
            $agenda->setId_horario($linha->id_horario);
            $agenda->setId_servico_prof($linha->id_servico_prof);
            $agenda->setHorario_inicio($linha->horario_inicio);
            $agenda->setHorario_fim($linha->horario_fim);
            $agenda->setDia_semana($linha->dia_semana);
            $vetorAgendas[] = $agenda;
        }
        return $vetorAgendas;
    }

    public function readAll()
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM agendas");
        $stmt->execute();
        $result = $stmt->get_result();
        $vetorAgendas = array();
        $i = 0;
        while ($linha = mysqli_fetch_object($result)) {
            $vetorAgendas[$i] = new Agendas();
            $vetorAgendas[$i]->setId($linha->id);
            $vetorAgendas[$i]->setCpf_cliente($linha->cpf_cliente);
            $vetorAgendas[$i]->setId_horario($linha->id_horario);
            $vetorAgendas[$i]->setId_servico_prof($linha->id_servico_prof);

            $i++;
        }
        return $vetorAgendas;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCpf_cliente()
    {
        return $this->cpf_cliente;
    }

    public function setCpf_cliente($cpf_cliente)
    {
        $this->cpf_cliente = $cpf_cliente;
    }

    public function getId_horario()
    {
        return $this->id_horario;
    }

    public function setId_horario($id_horario)
    {
        $this->id_horario = $id_horario;
    }

    public function getId_servico_prof()
    {
        return $this->id_servico_prof;
    }

    public function setId_servico_prof($id_servico_prof)
    {
        $this->id_servico_prof = $id_servico_prof;
    }


    /**
     * Get the value of horario_fim
     */
    public function getHorario_fim()
    {
        return $this->horario_fim;
    }

    /**
     * Set the value of horario_fim
     *
     * @return  self
     */
    public function setHorario_fim($horario_fim)
    {
        $this->horario_fim = $horario_fim;

        return $this;
    }

    /**
     * Get the value of dia_semana
     */
    public function getDia_semana()
    {
        return $this->dia_semana;
    }

    /**
     * Set the value of dia_semana
     *
     * @return  self
     */
    public function setDia_semana($dia_semana)
    {
        $this->dia_semana = $dia_semana;

        return $this;
    }

    /**
     * Get the value of horario_inicio
     */
    public function getHorario_inicio()
    {
        return $this->horario_inicio;
    }

    /**
     * Set the value of horario_inicio
     *
     * @return  self
     */
    public function setHorario_inicio($horario_inicio)
    {
        $this->horario_inicio = $horario_inicio;

        return $this;
    }
}
