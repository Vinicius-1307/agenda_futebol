
<?php
       require_once 'Database.php';

    class Servico_profissional {
        private $id_servico_prof;
		private $id_servico;
		private $id_prof;
        private $tempo_servico;
        private $preco_servico;
        private $profissional;
        private $servico;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createServico_profissional() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Servico_profissional (id_servico_prof, id_servico, id_prof, preco_servico, tempo_servico) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiss", $this->id_servico_prof, $this->id_servico, $this->id_prof, $this->preco_servico, $this->tempo_servico);
            return $stmt->execute();
        }
		
        public function deleteServico_profissional(array $ids) {
            if (!empty($ids)) {
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
            
                $query = "DELETE FROM Servico_profissional WHERE id_servico_prof IN ($placeholders)";
                $stmt = $this->banco->getConexao()->prepare($query);
            
                $types = str_repeat('i', count($ids));
            
                $stmt->bind_param($types, ...$ids);
            
                return $stmt->execute();
            }
        }
		
        public function updateServico_profissional() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Servico_profissional SET id_servico=?,id_prof=?,preco_servico=?,tempo_servico=? WHERE id_servico_prof = ?");
            $stmt->bind_param("iii", $this->id_servico, $this->id_prof, $this->preco_servico, $this->tempo_servico, $this->id_servico_prof);
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
                $this->setPreco_servico($linha->preco_servico);
                $this->setTempo_servico($linha->tempo_servico);
				
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
                $vetorServico_profissional[$i]->setPreco_servico($linha->preco_servico);
                $vetorServico_profissional[$i]->setTempo_servico($linha->tempo_servico);
				
                $i++;
            }
            return $vetorServico_profissional;
        }

        public function pegarTempoServico($id_servico) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Servico_profissional sp INNER JOIN Servicos s ON sp.id_servico = s.id_servico WHERE sp.id_servico = ?");
            $stmt->bind_param("i", $id_servico);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_servico_prof($linha->id_servico_prof);
				$this->setId_servico($linha->id_servico);
				$this->setId_prof($linha->id_prof);
                $this->setPreco_servico($linha->preco_servico);
                $this->setTempo_servico($linha->tempo_servico);
            }
            return $this;     
        }

        public function pegarProfissionalServico($id_servico_prof) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Servico_profissional sp INNER JOIN Servicos s ON sp.id_servico = s.id_servico INNER JOIN Profissionais p ON sp.id_prof = p.id_prof WHERE sp.id_servico_prof = ?");
            $stmt->bind_param("i", $id_servico_prof);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setProfissional($linha->nome);
                $this->setServico($linha->nome_servico);
            }
            return $this;     
        }

        public function pegarServicosProfissional($id_prof) {
            $stmt = $this->banco->getConexao()->prepare("SELECT sp.id_servico_prof FROM Servico_profissional sp INNER JOIN Servicos s ON sp.id_servico = s.id_servico WHERE sp.id_prof = ?");
            $stmt->bind_param("i", $id_prof);
            $stmt->execute();
            $result = $stmt->get_result();
            $idServicoProfArray = array();
        
            while ($linha = $result->fetch_object()) {
                $idServicoProfArray[] = $linha->id_servico_prof;
            }
        
            return $idServicoProfArray;
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

        /**
         * Get the value of tempo_servico
         */ 
        public function getTempo_servico()
        {
            return $this->tempo_servico;
        }

        /**
         * Set the value of tempo_servico
         *
         * @return  self
         */ 
        public function setTempo_servico($tempo_servico)
        {
            $this->tempo_servico = $tempo_servico;
            return $this;
        }

        /**
         * Get the value of preco_servico
         */ 
        public function getPreco_servico()
        {
            return $this->preco_servico;
        }

        /**
         * Set the value of preco_servico
         *
         * @return  self
         */ 
        public function setPreco_servico($preco_servico)
        {
            $this->preco_servico = $preco_servico;

            return $this;
        }

        /**
         * Get the value of profissional
         */ 
        public function getProfissional()
        {
            return $this->profissional;
        }

        /**
         * Set the value of profissional
         *
         * @return  self
         */ 
        public function setProfissional($profissional)
        {
            $this->profissional = $profissional;

            return $this;
        }

        /**
         * Get the value of servico
         */ 
        public function getServico()
        {
            return $this->servico;
        }

        /**
         * Set the value of servico
         *
         * @return  self
         */ 
        public function setServico($servico)
        {
            $this->servico = $servico;

            return $this;
        }
    }
?>
