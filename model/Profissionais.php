<?php
       require_once 'Database.php';

    class Profissionais {
        private $id_prof;
		private $cpf;
		private $rg;
		private $telefone;
		private $ano_cadastro;
		private $nome;
		private $inicio_atendimento;
		private $fim_atendimento;
		private $email;
		private $senha;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoAgendaFutebol();
        }
		
        public function createProfissionais() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO profissionais (id_prof, cpf, rg, telefone, ano_cadastro, nome, inicio_atendimento, fim_atendimento, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssssss", $this->id_prof, $this->cpf, $this->rg, $this->telefone, $this->ano_cadastro, $this->nome, $this->inicio_atendimento, $this->fim_atendimento, $this->email, $this->senha);
            return $stmt->execute();
        }
		
        public function deleteProfissionais() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM profissionais WHERE id_prof = ?");
            $stmt->bind_param("i", $this->id_prof);
            return $stmt->execute();
        }
		
        public function updateProfissionais() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE profissionais SET cpf=?,rg=?,telefone=?,ano_cadastro=?,nome=?,inicio_atendimento=?,fim_atendimento=? WHERE id_prof = ?");
            $stmt->bind_param("sssssi", $this->cpf, $this->rg, $this->telefone, $this->ano_cadastro, $this->nome, $this->inicio_atendimento, $this->fim_atendimento, $this->id_prof );
            $stmt->execute();
        }

        public function login($email, $senha){
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM profissionais WHERE email = ? AND senha = ?");
            $stmt->bind_param("ss", $email, $senha);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows < 1) {
                return false;
            }
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_prof($linha->id_prof);
				$this->setCpf($linha->cpf);
				$this->setRg($linha->rg);
				$this->setTelefone($linha->telefone);
				$this->setAno_cadastro($linha->ano_cadastro);
				$this->setNome($linha->nome);
				$this->setInicio_atendimento($linha->inicio_atendimento);
				$this->setFim_atendimento($linha->fim_atendimento);
				$this->setEmail($linha->email);
				$this->setSenha($linha->senha);
            }
            return $this;  
        }
        public function readProfissionais($id_prof) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM profissionais WHERE id_prof = ?");
            $stmt->bind_param("i", $id_prof);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_prof($linha->id_prof);
				$this->setCpf($linha->cpf);
				$this->setRg($linha->rg);
				$this->setTelefone($linha->telefone);
				$this->setAno_cadastro($linha->ano_cadastro);
				$this->setNome($linha->nome);
				$this->setInicio_atendimento($linha->inicio_atendimento);
				$this->setFim_atendimento($linha->fim_atendimento);
				
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM profissionais");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorProfissionais = array();
            $i=0;
            while ($linha = mysqli_fetch_object($result)) {
                $vetorProfissionais[$i] = new Profissionais();
                $vetorProfissionais[$i]->setId_prof($linha->id_prof);
				$vetorProfissionais[$i]->setCpf($linha->cpf);
				$vetorProfissionais[$i]->setRg($linha->rg);
				$vetorProfissionais[$i]->setTelefone($linha->telefone);
				$vetorProfissionais[$i]->setAno_cadastro($linha->ano_cadastro);
				$vetorProfissionais[$i]->setNome($linha->nome);
				$vetorProfissionais[$i]->setInicio_atendimento($linha->inicio_atendimento);
				$vetorProfissionais[$i]->setFim_atendimento($linha->fim_atendimento);
                $vetorProfissionais[$i]->setEmail($linha->email);
				
                $i++;
            }
            return $vetorProfissionais;
        }
		
        public function getId_prof() { 
            return $this->id_prof; 
        }
		
        public function setId_prof($id_prof) { 
            $this->id_prof = $id_prof; 
        }
		
        public function getCpf() { 
            return $this->cpf; 
        }
		
        public function setCpf($cpf) { 
            $this->cpf = $cpf; 
        }
		
        public function getRg() { 
            return $this->rg; 
        }
		
        public function setRg($rg) { 
            $this->rg = $rg; 
        }
		
        public function getTelefone() { 
            return $this->telefone; 
        }
		
        public function setTelefone($telefone) { 
            $this->telefone = $telefone; 
        }
		
        public function getAno_cadastro() { 
            return $this->ano_cadastro; 
        }
		
        public function setAno_cadastro($ano_cadastro) { 
            $this->ano_cadastro = $ano_cadastro; 
        }
		
        public function getNome() { 
            return $this->nome; 
        }
		
        public function setNome($nome) { 
            $this->nome = $nome; 
        }
		
        public function getInicio_atendimento() { 
            return $this->inicio_atendimento; 
        }
		
        public function setInicio_atendimento($inicio_atendimento) { 
            $this->inicio_atendimento = $inicio_atendimento; 
        }
		
        public function getFim_atendimento() { 
            return $this->fim_atendimento; 
        }
		
        public function setFim_atendimento($fim_atendimento) { 
            $this->fim_atendimento = $fim_atendimento; 
        }

		/**
		 * Get the value of email
		 */ 
		public function getEmail()
		{
            return $this->email;
		}

		/**
		 * Set the value of email
		 *
		 * @return  self
		 */ 
		public function setEmail($email)
		{
            $this->email = $email;

            return $this;
		}

		/**
		 * Get the value of senha
		 */ 
		public function getSenha()
		{
            return $this->senha;
		}

		/**
		 * Set the value of senha
		 *
		 * @return  self
		 */ 
		public function setSenha($senha)
		{
            $this->senha = $senha;

            return $this;
		}
    }
?>
