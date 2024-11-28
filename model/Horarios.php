
<?php
       require_once 'Database.php';

    class Horarios {
        private $id_horario;
		private $dia_semana;
		private $horario_inicio;
		private $horario_fim;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createHorarios() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Horarios (id_horario, dia_semana, horario_inicio, horario_fim) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $this->id_horario, $this->dia_semana, $this->horario_inicio, $this->horario_fim);
            $horario = $stmt->execute();
            $id_horario = $this->banco->getConexao()->insert_id;
            $this->setId_horario($id_horario);
            return $horario;
        }
		
        public function deleteHorarios() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Horarios WHERE id_horario = ?");
            $stmt->bind_param("i", $this->id_horario);
            return $stmt->execute();
        }
		
        public function updateHorarios() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Horarios SET dia_semana=?,horario_inicio=?,horario_fim=? WHERE id_horario = ?");
            $stmt->bind_param("i", $this->dia_semana, $this->horario_inicio, $this->horario_fim, $this->id_horario );
            $stmt->execute();
        }
		
        public function readHorarios($id_horario) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Horarios WHERE id_horario = ?");
            $stmt->bind_param("i", $id_horario);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_horario($linha->id_horario);
				$this->setDia_semana($linha->dia_semana);
				$this->setHorario_inicio($linha->horario_inicio);
				$this->setHorario_fim($linha->horario_fim);
				
            }
            return $this;     
        }

        public function buscarHorario($dia_semana, $horario_inicio, $horario_fim, $id_profissional) {
            $stmt = $this->banco->getConexao()->prepare("SELECT 1 FROM Horarios h INNER JOIN Agendas a ON h.id_horario = a.id_horario INNER JOIN servico_profissional sp ON a.id_servico_prof = sp.id_servico_prof WHERE h.dia_semana = ? AND h.horario_inicio = ?  AND h.horario_fim = ?  AND sp.id_prof = ?");
            $stmt->bind_param("sssi", $dia_semana, $horario_inicio, $horario_fim, $id_profissional);
            $stmt->execute();
            $resultado = $stmt->get_result();
        
            return $resultado->num_rows > 0;
        }

        public function verificarHorario($dia_semana, $horario_inicio, $id_profissional) {
            $stmt = $this->banco->getConexao()->prepare("SELECT 1 FROM Horarios h INNER JOIN Agendas a ON h.id_horario = a.id_horario INNER JOIN servico_profissional sp ON a.id_servico_prof = sp.id_servico_prof WHERE h.dia_semana = ? AND ? BETWEEN h.horario_inicio AND h.horario_fim AND sp.id_prof = ?");
            $stmt->bind_param("ssi", $dia_semana, $horario_inicio, $id_profissional);
            $stmt->execute();
            $resultado = $stmt->get_result();
        
            return $resultado->num_rows > 0;
        }      
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Horarios");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorHorarios = array();
            $i=0;
            while ($linha = mysqli_fetch_object($result)) {
                $vetorHorarios[$i] = new Horarios();
                $vetorHorarios[$i]->setId_horario($linha->id_horario);
				$vetorHorarios[$i]->setDia_semana($linha->dia_semana);
				$vetorHorarios[$i]->setHorario_inicio($linha->horario_inicio);
				$vetorHorarios[$i]->setHorario_fim($linha->horario_fim);
				
                $i++;
            }
            return $vetorHorarios;
        }
		
        public function getId_horario() { 
            return $this->id_horario; 
        }
		
        public function setId_horario($id_horario) { 
            $this->id_horario = $id_horario; 
        }
		
        public function getDia_semana() { 
            return $this->dia_semana; 
        }
		
        public function setDia_semana($dia_semana) { 
            $this->dia_semana = $dia_semana; 
        }
		
        public function getHorario_inicio() { 
            return $this->horario_inicio; 
        }
		
        public function setHorario_inicio($horario_inicio) { 
            $this->horario_inicio = $horario_inicio; 
        }
		
        public function getHorario_fim() { 
            return $this->horario_fim; 
        }
		
        public function setHorario_fim($horario_fim) { 
            $this->horario_fim = $horario_fim; 
        }
		
    }
?>
