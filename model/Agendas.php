
<?php
       require_once 'Database.php';

    class Agendas {
        private $id;
		private $cpf_cliente;
		private $id_horario;
		private $id_servico_prof;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createAgendas() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Agendas (id, cpf_cliente, id_horario, id_servico_prof) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isii", $this->id, $this->cpf_cliente, $this->id_horario, $this->id_servico_prof);
            return $stmt->execute();
        }
		
        public function deleteAgendas() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Agendas WHERE id = ?");
            $stmt->bind_param("i", $this->id);
            return $stmt->execute();
        }
		
        public function updateAgendas() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Agendas SET cpf_cliente=?,id_horario=?,id_servico_prof=? WHERE id = ?");
            $stmt->bind_param("siii", $this->cpf_cliente, $this->id_horario, $this->id_servico_prof, $this->id );
            $stmt->execute();
        }
		
        public function readAgendas($id) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Agendas WHERE id = ?");
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
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Agendas");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorAgendas = array();
            $i=0;
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
		
        public function getId() { 
            return $this->id; 
        }
		
        public function setId($id) { 
            $this->id = $id; 
        }
		
        public function getCpf_cliente() { 
            return $this->cpf_cliente; 
        }
		
        public function setCpf_cliente($cpf_cliente) { 
            $this->cpf_cliente = $cpf_cliente; 
        }
		
        public function getId_horario() { 
            return $this->id_horario; 
        }
		
        public function setId_horario($id_horario) { 
            $this->id_horario = $id_horario; 
        }
		
        public function getId_servico_prof() { 
            return $this->id_servico_prof; 
        }
		
        public function setId_servico_prof($id_servico_prof) { 
            $this->id_servico_prof = $id_servico_prof; 
        }
		
    }
?>
