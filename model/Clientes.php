
<?php
    require_once 'Database.php';
    class Clientes {
        private $cpf;
		private $nome;
		private $telefone;
		private $banco;
        private $email;
        private $senha;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createClientes() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Clientes (cpf, nome, telefone, email, senha) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $this->cpf, $this->nome, $this->telefone, $this->email, $this->senha);
            return $stmt->execute();
        }
		
        public function deleteClientes() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Clientes WHERE cpf = ?");
            $stmt->bind_param("s", $this->cpf);
            return $stmt->execute();
        }
		
        public function updateClientes() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Clientes SET nome=?, telefone=? WHERE cpf = ?");
            $stmt->bind_param("sss", $this->nome, $this->telefone, $this->cpf );
            $stmt->execute();
        }

        public function login($email, $senha){
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Clientes WHERE email = ? AND senha = ?");
            $stmt->bind_param("ss", $email, $senha);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setCpf($linha->cpf);
				$this->setNome($linha->nome);
				$this->setEmail($linha->email);
				$this->setSenha($linha->senha);
				$this->setTelefone($linha->telefone);
            }
            return $this;  
        }
        public function readClientes($cpf) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Clientes WHERE cpf = ?");
            $stmt->bind_param("s", $cpf);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setCpf($linha->cpf);
				$this->setNome($linha->nome);
				$this->setTelefone($linha->telefone);
				$this->setEmail($linha->email);
				$this->setSenha($linha->senha);
				
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Clientes");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorClientes = array();
            $i=0;
            while ($linha = mysqli_fetch_object($result)) {
                $vetorClientes[$i] = new Clientes();
                $vetorClientes[$i]->setCpf($linha->cpf);
				$vetorClientes[$i]->setNome($linha->nome);
				$vetorClientes[$i]->setTelefone($linha->telefone);
				$vetorClientes[$i]->setTelefone($linha->telefone);
				$vetorClientes[$i]->setEmail($linha->email);
				$vetorClientes[$i]->setSenha($linha->senha);
				
                $i++;
            }
            return $vetorClientes;
        }
		
        public function getCpf() { 
            return $this->cpf; 
        }
		
        public function setCpf($cpf) { 
            $this->cpf = $cpf; 
        }
		
        public function getNome() { 
            return $this->nome; 
        }
		
        public function setNome($nome) { 
            $this->nome = $nome; 
        }
		
        public function getTelefone() { 
            return $this->telefone; 
        }
		
        public function setTelefone($telefone) { 
            $this->telefone = $telefone; 
        }

        public function getSenha()
        {
            return $this->senha;
        }

        public function setSenha($senha)
        {
            $this->senha = $senha;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($email)
        {
            return $this->email = $email;
        }
		
    }
?>
