
<?php
       require_once 'Database.php';

    class Servicos {
        private $id_servico;
		private $nome_servico;
		private $preco_servico;
        private $foto_servico;
        private $tempo_servico;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createServicos() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Servicos (id_servico, nome_servico) VALUES (?, ?)");
            $stmt->bind_param("is", $this->id_servico, $this->nome_servico);
            $stmt->execute();
            $id_servico = $this->banco->getConexao()->insert_id;
            $this->setId_servico($id_servico);

            return true;

        }
		
        public function deleteServicos() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Servicos WHERE id_servico = ?");
            $stmt->bind_param("i", $this->id_servico);
            return $stmt->execute();
        }
		
        public function updateServicos() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Servicos SET nome_servico=? WHERE id_servico = ?");
            $stmt->bind_param("sii", $this->nome_servico, $this->id_servico );
            $stmt->execute();
        }
		
        public function readServicos($id_servico) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Servicos WHERE id_servico = ?");
            $stmt->bind_param("i", $id_servico);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_servico($linha->id_servico);
				$this->setNome_servico($linha->nome_servico);
				
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Servicos");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorServicos = array();
            $i=0;
            while ($linha = mysqli_fetch_object($result)) {
                $vetorServicos[$i] = new Servicos();
                $vetorServicos[$i]->setId_servico($linha->id_servico);
				$vetorServicos[$i]->setNome_servico($linha->nome_servico);
				
                $i++;
            }
            return $vetorServicos;
        }
        
        public function pegarServicosBarbeiro($id_prof)
        {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Servicos s INNER JOIN servico_profissional sp ON sp.id_servico = s.id_servico WHERE sp.id_prof = ?");
            $stmt->bind_param("i", $id_prof);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $servicos = array();
            $i = 0;
            while ($linha = mysqli_fetch_object($resultado)) { 
                $servicos[$i] = new Servicos();
                $servicos[$i]->setId_servico($linha->id_servico);
                $servicos[$i]->setNome_servico($linha->nome_servico);
                $servicos[$i]->setPreco_servico($linha->preco_servico);
                
                $i++;
            }
            return $servicos;               
        }

        public function pegarServicosCompletosBarbeiro($id_prof)
        {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Servicos s INNER JOIN servico_profissional sp ON sp.id_servico = s.id_servico LEFT JOIN fotos_servicos ON s.id_servico = fotos_servicos.id_servico WHERE sp.id_prof = ?");
            $stmt->bind_param("i", $id_prof);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $servicos = array();
            $i = 0;
            while ($linha = mysqli_fetch_object($resultado)) { 
                $servicos[$i] = new Servicos();
                $servicos[$i]->setId_servico($linha->id_servico);
                $servicos[$i]->setNome_servico($linha->nome_servico);
                $servicos[$i]->setPreco_servico($linha->preco_servico);
                $servicos[$i]->setFoto_servico($linha->nome_arquivo);
                $servicos[$i]->setTempo_servico($linha->tempo_servico);
                $i++;
            }
            return $servicos;
        }
		
        public function getId_servico() { 
            return $this->id_servico; 
        }
		
        public function setId_servico($id_servico) { 
            $this->id_servico = $id_servico; 
        }
		
        public function getNome_servico() { 
            return $this->nome_servico; 
        }
		
        public function setNome_servico($nome_servico) { 
            $this->nome_servico = $nome_servico; 
        }
		
        public function getPreco_servico() { 
            return $this->preco_servico; 
        }
		
        public function setPreco_servico($preco_servico) { 
            $this->preco_servico = $preco_servico; 
        }

        public function getFoto_servico()
        {
            return $this->foto_servico;
        }

        public function setFoto_servico($foto_servico){
            $this->foto_servico = $foto_servico;
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
    }
?>
