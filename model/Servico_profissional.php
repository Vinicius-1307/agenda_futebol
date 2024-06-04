
<?php
       require_once 'Database.php';

    class Servico_profissional {
        private $id_servico_prof;
		private $id_servico;
		private $id_prof;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createServico_profissional() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Servico_profissional (id_servico_prof, id_servico, id_prof) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $this->id_servico_prof, $this->id_servico, $this->id_prof);
            return $stmt->execute();
        }
		
        public function deleteServico_profissional() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Servico_profissional WHERE id_servico_prof = ?");
            $stmt->bind_param("i", $this->id_servico_prof);
            return $stmt->execute();
        }
		
        public function updateServico_profissional() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Servico_profissional SET id_servico=?,id_prof=? WHERE id_servico_prof = ?");
            $stmt->bind_param("iii", $this->id_servico, $this->id_prof, $this->id_servico_prof );
            $stmt->execute();
        }
		
        public function readServico_profissional($id_servico_prof) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Servico_profissional WHERE id_servico_prof = ?");
            $stmt->bind_param("i", $id_servico_prof);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_servico_prof($linha->id_servico_prof);
				$this->setId_servico($linha->id_servico);
				$this->setId_prof($linha->id_prof);
				
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Servico_profissional");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorServico_profissional = array();
            $i=0;
            while ($linha = mysqli_fetch_object($result)) {
                $vetorServico_profissional[$i] = new Servico_profissional();
                $vetorServico_profissional[$i]->setId_servico_prof($linha->id_servico_prof);
				$vetorServico_profissional[$i]->setId_servico($linha->id_servico);
				$vetorServico_profissional[$i]->setId_prof($linha->id_prof);
				
                $i++;
            }
            return $vetorServico_profissional;
        }
		
        public function getId_servico_prof() { 
            return $this->id_servico_prof; 
        }
		
        public function setId_servico_prof($id_servico_prof) { 
            $this->id_servico_prof = $id_servico_prof; 
        }
		
        public function getId_servico() { 
            return $this->id_servico; 
        }
		
        public function setId_servico($id_servico) { 
            $this->id_servico = $id_servico; 
        }
		
        public function getId_prof() { 
            return $this->id_prof; 
        }
		
        public function setId_prof($id_prof) { 
            $this->id_prof = $id_prof; 
        }
		
    }
?>
