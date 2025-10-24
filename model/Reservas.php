<?php
require_once 'Database.php';

class Reservas
{
    private $banco;

    private $id_reserva;
    private $id_campo;
    private $id_cliente;
    private $data_reserva;
    private $hora_inicio;
    private $hora_fim;
    private $valor_total;
    private $status;

    function __construct()
    {
        $this->banco = new BancoAgendaFutebol();
    }

    // Getters e setters
    public function setIdCampo($id)
    {
        $this->id_campo = $id;
    }
    public function setIdCliente($id)
    {
        $this->id_cliente = $id;
    }
    public function setDataReserva($data)
    {
        $this->data_reserva = $data;
    }
    public function setHoraInicio($hora)
    {
        $this->hora_inicio = $hora;
    }
    public function setHoraFim($hora)
    {
        $this->hora_fim = $hora;
    }
    public function setValorTotal($valor)
    {
        $this->valor_total = $valor;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function verificarConflito($id_campo, $data, $hora_inicio, $hora_fim)
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM reservas
            WHERE id_campo = ?
            AND data_reserva = ?
            AND (
                (hora_inicio <= ? AND hora_fim > ?) OR
                (hora_inicio < ? AND hora_fim >= ?)
            )");

        $stmt->bind_param(
            "isssss",
            $id_campo,
            $data,
            $hora_inicio,
            $hora_inicio,
            $hora_fim,
            $hora_fim
        );

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function create()
    {
        $stmt = $this->banco->getConexao()->prepare("INSERT INTO reservas 
                (id_campo, id_cliente, data_reserva, hora_inicio, hora_fim, valor_total, status)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissssi", $this->id_campo, $this->id_cliente, $this->data_reserva, $this->hora_inicio, $this->hora_fim, $this->valor_total, $this->status);
        return $stmt->execute();
    }

    public function getReservasByCliente($id_cliente)
    {
        $stmt = $this->banco->getConexao()->prepare("
        SELECT r.*, c.nome AS nome_campo
        FROM reservas r
        JOIN campos c ON r.id_campo = c.id_campo
        WHERE r.id_cliente = ?
        ORDER BY r.data_reserva DESC, r.hora_inicio ASC
    ");

        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();

        $reservas = [];
        while ($row = $result->fetch_assoc()) {
            $reservas[] = $row;
        }

        return $reservas;
    }

    public function getReservasByProprietario($id_cliente)
    {
        $sql = "
        SELECT 
            r.id_reserva,
            r.data_reserva,
            r.hora_inicio,
            r.hora_fim,
            r.valor_total,
            r.status,
            c.nome AS nome_campo,
            cli.nome AS nome_cliente
        FROM reservas r
        INNER JOIN campos c ON r.id_campo = c.id_campo
        INNER JOIN clientes cli ON r.id_cliente = cli.id_cliente
        WHERE c.id_cliente = ?  -- aqui pegamos os campos do dono
        ORDER BY r.data_reserva DESC, r.hora_inicio ASC
    ";

        $stmt = $this->banco->getConexao()->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();

        $reservas = [];
        while ($row = $result->fetch_assoc()) {
            $reservas[] = $row;
        }

        return $reservas;
    }
}
