
<?php
    require_once 'Database.php';
    class Clientes {
        private $cpf;
		private $nome;
		private $telefone;
		private $banco;
        private $email;
        private $senha;
        private $is_admin;
		
        function __construct() {
            $this->banco = new BancoAgendaFutebol();
        }
		
        public function createClientes() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO clientes (cpf, nome, telefone, email, senha, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssd", $this->cpf, $this->nome, $this->telefone, $this->email, $this->senha, $this->is_admin);
            return $stmt->execute();
        }
		
        public function deleteClientes() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM clientes WHERE cpf = ?");
            $stmt->bind_param("s", $this->cpf);
            return $stmt->execute();
        }
		
        public function updateClientes() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE clientes SET nome=?, telefone=? WHERE cpf = ?");
            $stmt->bind_param("sss", $this->nome, $this->telefone, $this->cpf );
            $stmt->execute();
        }

        public function login($email, $senha){
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM clientes WHERE email = ? AND senha = ?");
            $stmt->bind_param("ss", $email, $senha);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows < 1) {
                return false;
            }

            while ($linha = $resultado->fetch_object()) { 
                $this->setCpf($linha->cpf);
				$this->setNome($linha->nome);
				$this->setEmail($linha->email);
				$this->setSenha($linha->senha);
				$this->setTelefone($linha->telefone);
                $this->setIs_admin($linha->is_admin);
            }
            return $this;  
        }
        public function readClientes($cpf) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM clientes WHERE cpf = ?");
            $stmt->bind_param("s", $cpf);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setCpf($linha->cpf);
				$this->setNome($linha->nome);
				$this->setTelefone($linha->telefone);
				$this->setEmail($linha->email);
				$this->setSenha($linha->senha);
                $this->setIs_admin($linha->is_admin);
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM clientes");
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
                $vetorClientes[$i]->setIs_admin($linha->is_admin);
				
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
		
        /**
         * Get the value of is_admin
         */ 
        public function getIs_admin()
        {
            return $this->is_admin;
        }

        /**
         * Set the value of is_admin
         *
         * @return  self
         */ 
        public function setIs_admin($is_admin)
        {
            $this->is_admin = $is_admin;
            return $this;
        }
    }
?>
