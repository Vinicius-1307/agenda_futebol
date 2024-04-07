
<?php
    require_once("Database.php");
    class User {
        private $id_user;
		private $name;
		private $email;
		private $password;
		private $is_admin;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createUser() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO User (id_user, name, email, password, is_admin) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssi", $this->id_user, $this->name, $this->email, $this->password, $this->is_admin);
            return $stmt->execute();
        }
		
        public function deleteUser() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM User WHERE id_user = ?");
            $stmt->bind_param("i", $this->id_user);
            return $stmt->execute();
        }
		
        public function updateUser() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE User SET name=?,email=?,password=?,is_admin=? WHERE id_user = ?");
            $stmt->bind_param("sssii", $this->name, $this->email, $this->password, $this->is_admin, $this->id_user );
            $stmt->execute();
        }
		
        public function readUser($id_user) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM User WHERE id_user = ? AND is_admin = 1");
            $stmt->bind_param("i", $id_user);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_user($linha->id_user);
				$this->setName($linha->name);
				$this->setEmail($linha->email);
				$this->setPassword($linha->password);
				$this->setIs_admin($linha->is_admin);
				
            }
            return $this;     
        }
        public function login($email, $senha){
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM User WHERE email = ? AND password = ?  AND is_admin = 1");
            $stmt->bind_param("ss", $email, $senha);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_user($linha->id_user);
				$this->setName($linha->name);
				$this->setEmail($linha->email);
				$this->setPassword($linha->password);
				$this->setIs_admin($linha->is_admin);
			
            }
            return $this;  
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM User");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorUser = array();
            $i=0;
            while ($$linha = mysqli_fetch_object($result)) {
                $vetorUser[$i] = new User();
                $vetorUser[$i]->setId_user($linha->id_user);
				$vetorUser[$i]->setName($linha->name);
				$vetorUser[$i]->setEmail($linha->email);
				$vetorUser[$i]->setPassword($linha->password);
				$vetorUser[$i]->setIs_admin($linha->is_admin);
				
                $i++;
            }
            return $vetorUser;
        }
		
        public function getId_user() { 
            return $this->id_user; 
        }
		
        public function setId_user($id_user) { 
            $this->id_user = $id_user; 
        }
		
        public function getName() { 
            return $this->name; 
        }
		
        public function setName($name) { 
            $this->name = $name; 
        }
		
        public function getEmail() { 
            return $this->email; 
        }
		
        public function setEmail($email) { 
            $this->email = $email; 
        }
		
        public function getPassword() { 
            return $this->password; 
        }
		
        public function setPassword($password) { 
            $this->password = $password; 
        }
		
        public function getIs_admin() { 
            return $this->is_admin; 
        }
		
        public function setIs_admin($is_admin) { 
            $this->is_admin = $is_admin; 
        }
		
    }
?>
