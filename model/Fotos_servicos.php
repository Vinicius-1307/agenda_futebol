
<?php
       require_once 'Database.php';

    class Fotos_servicos {
        private $id_foto;
		private $nome_arquivo;
		private $id_servico;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createFotos_servicos() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Fotos_servicos (id_foto, nome_arquivo, id_servico) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $this->id_foto, $this->nome_arquivo, $this->id_servico);
            return $stmt->execute();
        }
		
        public function deleteFotos_servicos() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Fotos_servicos WHERE id_foto = ?");
            $stmt->bind_param("i", $this->id_foto);
            return $stmt->execute();
        }
		
        public function updateFotos_servicos() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Fotos_servicos SET nome_arquivo=?,id_servico=? WHERE id_foto = ?");
            $stmt->bind_param("sii", $this->nome_arquivo, $this->id_servico, $this->id_foto );
            $stmt->execute();
        }
		
        public function readFotos_servicos($id_foto) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Fotos_servicos WHERE id_foto = ?");
            $stmt->bind_param("i", $id_foto);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_foto($linha->id_foto);
				$this->setNome_arquivo($linha->nome_arquivo);
				$this->setId_servico($linha->id_servico);
				
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Fotos_servicos");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorFotos_servicos = array();
            $i=0;
            while ($linha = mysqli_fetch_object($result)) {
                $vetorFotos_servicos[$i] = new Fotos_servicos();
                $vetorFotos_servicos[$i]->setId_foto($linha->id_foto);
				$vetorFotos_servicos[$i]->setNome_arquivo($linha->nome_arquivo);
				$vetorFotos_servicos[$i]->setId_servico($linha->id_servico);
				
                $i++;
            }
            return $vetorFotos_servicos;
        }
		
        public function getId_foto() { 
            return $this->id_foto; 
        }
		
        public function setId_foto($id_foto) { 
            $this->id_foto = $id_foto; 
        }
		
        public function getNome_arquivo() { 
            return $this->nome_arquivo; 
        }
		
        public function setNome_arquivo($nome_arquivo) { 
            $this->nome_arquivo = $nome_arquivo; 
        }
		
        public function getId_servico() { 
            return $this->id_servico; 
        }
		
        public function setId_servico($id_servico) { 
            $this->id_servico = $id_servico; 
        }
		
    }
?>
