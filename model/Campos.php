<?php
require_once 'Database.php';

class Campos
{
    private $id_campo;
    private $nome;
    private $inicio_operacao;
    private $fim_operacao;
    private $duracao_slot;
    private $preco_slot;
    private $id_cliente;
    private $banco;

    function __construct()
    {
        $this->banco = new BancoAgendaFutebol();
    }

    public function setPreco_slot($preco)
    {
        $this->preco_slot = $preco;
    }

    public function getPreco_slot()
    {
        return $this->preco_slot;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setInicio_operacao($inicio)
    {
        $this->inicio_operacao = $inicio;
    }

    public function setFim_operacao($fim)
    {
        $this->fim_operacao = $fim;
    }

    public function setDuracao_slot($duracao)
    {
        $this->duracao_slot = $duracao;
    }

    public function getDuracao_slot()
    {
        return $this->duracao_slot;
    }

    public function getId_campo()
    {
        return $this->id_campo;
    }

    public function getInicio_atendimento()
    {
        return $this->inicio_operacao;
    }

    public function getFim_atendimento()
    {
        return $this->fim_operacao;
    }

    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    public function setId_cliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function setId_campo($id_campo)
    {
        $this->id_campo = $id_campo;
    }

    public function createCampo()
    {
        $stmt = $this->banco->getConexao()->prepare("
        INSERT INTO campos (nome, inicio_operacao, fim_operacao, duracao_slot, id_cliente, preco_slot)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
        $stmt->bind_param("sssiii", $this->nome, $this->inicio_operacao, $this->fim_operacao, $this->duracao_slot, $this->id_cliente, $this->preco_slot);
        return $stmt->execute();
    }

    public function getById($id)
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM campos WHERE id_campo = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($linha = mysqli_fetch_object($result)) {
            $campo = new Campos();
            $campo->setId_campo($linha->id_campo);
            $campo->setNome($linha->nome);
            $campo->setInicio_operacao($linha->inicio_operacao);
            $campo->setFim_operacao($linha->fim_operacao);
            $campo->setDuracao_slot($linha->duracao_slot);
            $campo->setPreco_slot($linha->preco_slot);
            $campo->setId_cliente($linha->id_cliente);
            return $campo;
        }

        return null;
    }

    public function getAll()
    {
        $stmt = $this->banco->getConexao()->prepare("SELECT * FROM campos");
        $stmt->execute();
        $result = $stmt->get_result();
        $vetorCampos = array();
        $i = 0;
        while ($linha = mysqli_fetch_object($result)) {
            $vetorCampos[$i] = new Campos();
            $vetorCampos[$i]->setId_campo($linha->id_campo);
            $vetorCampos[$i]->setNome($linha->nome);
            $vetorCampos[$i]->setInicio_operacao($linha->inicio_operacao);
            $vetorCampos[$i]->setFim_operacao($linha->fim_operacao);
            $vetorCampos[$i]->setDuracao_slot($linha->duracao_slot);
            $vetorCampos[$i]->setPreco_slot($linha->preco_slot);
            $i++;
        }
        return $vetorCampos;
    }

    public function getTelefone()
    {
        $stmt = $this->banco->getConexao()->prepare("
        SELECT c.telefone
        FROM campos ca
        JOIN clientes c ON ca.id_cliente = c.id_cliente
        WHERE ca.id_campo = ?
    ");
        $stmt->bind_param("i", $this->id_campo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($linha = mysqli_fetch_object($result)) {
            return $linha->telefone;
        }
        return null;
    }

    public function getHorariosDisponiveis($id_campo, $data_reserva)
    {
        $conn = $this->banco->getConexao();

        // Buscar informações do campo
        $stmt = $conn->prepare("
        SELECT inicio_operacao, fim_operacao, duracao_slot
        FROM campos
        WHERE id_campo = ?
    ");
        $stmt->bind_param("i", $id_campo);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            return [];
        }

        $campo = $result->fetch_assoc();
        $inicio = new DateTime($campo['inicio_operacao']);
        $fim = new DateTime($campo['fim_operacao']);
        $duracao = (int)$campo['duracao_slot'];

        // Buscar reservas já feitas para o campo e data selecionados
        $stmt = $conn->prepare("
        SELECT hora_inicio, hora_fim
        FROM reservas
        WHERE id_campo = ? AND data_reserva = ?
    ");
        $stmt->bind_param("is", $id_campo, $data_reserva);
        $stmt->execute();
        $reservasResult = $stmt->get_result();

        $reservas = [];
        while ($row = $reservasResult->fetch_assoc()) {
            $reservas[] = $row;
        }

        $horariosDisponiveis = [];

        while ($inicio < $fim) {
            $horaInicioStr = $inicio->format('H:i:s');
            $inicio->modify("+{$duracao} minutes");
            $horaFimStr = $inicio->format('H:i:s');

            // Verifica se esse slot conflita com alguma reserva existente
            $ocupado = false;
            foreach ($reservas as $res) {
                if (
                    ($horaInicioStr >= $res['hora_inicio'] && $horaInicioStr < $res['hora_fim']) ||
                    ($horaFimStr > $res['hora_inicio'] && $horaFimStr <= $res['hora_fim'])
                ) {
                    $ocupado = true;
                    break;
                }
            }

            if (!$ocupado && $horaFimStr <= $fim->format('H:i:s')) {
                $horariosDisponiveis[] = [
                    'inicio' => $horaInicioStr,
                    'fim' => $horaFimStr
                ];
            }
        }

        return $horariosDisponiveis;
    }

    public function getCamposByProprietario($id_cliente)
    {
        $stmt = $this->banco->getConexao()->prepare("
        SELECT id_campo, nome, inicio_operacao, fim_operacao, duracao_slot, preco_slot
        FROM campos
        WHERE id_cliente = ?
        ORDER BY nome ASC
    ");
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();

        $campos = [];
        while ($row = $result->fetch_assoc()) {
            $campos[] = $row;
        }

        return $campos;
    }

    public function deleteCampo($id_campo)
    {
        try {
            $stmt = $this->banco->getConexao()->prepare("
            DELETE FROM campos
            WHERE id_campo = ?
        ");
            $stmt->bind_param("i", $id_campo);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            // Verifica se o erro é de constraint de chave estrangeira
            if ($e->getCode() === 1451) {
                // Retorna uma mensagem específica que o controller pode usar
                return 'has_reservations';
            } else {
                // Outros erros genéricos
                return false;
            }
        }
    }
}
