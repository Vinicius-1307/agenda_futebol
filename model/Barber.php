
<?php
    class Barber {
        private $id_barber;
		private $name;
		private $haircut_price;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createBarber() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Barber (id_barber, name, haircut_price) VALUES (?, ?, ?)");
            $stmt->bind_param("isd", $this->id_barber, $this->name, $this->haircut_price);
            return $stmt->execute();
        }
		
        public function deleteBarber() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Barber WHERE id_barber = ?");
            $stmt->bind_param("i", $this->id_barber);
            return $stmt->execute();
        }
		
        public function updateBarber() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Barber SET name=?,haircut_price=? WHERE id_barber = ?");
            $stmt->bind_param("sdi", $this->name, $this->haircut_price, $this->id_barber );
            $stmt->execute();
        }
		
        public function readBarber($id_barber) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Barber WHERE id_barber = ?");
            $stmt->bind_param("i", $id_barber);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_barber($linha->id_barber);
				$this->setName($linha->name);
				$this->setHaircut_price($linha->haircut_price);
				
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Barber");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorBarber = array();
            $i=0;
            while ($$linha = mysqli_fetch_object($result)) {
                $vetorBarber[$i] = new Barber();
                $vetorBarber[$i]->setId_barber($linha->id_barber);
				$vetorBarber[$i]->setName($linha->name);
				$vetorBarber[$i]->setHaircut_price($linha->haircut_price);
				
                $i++;
            }
            return $vetorBarber;
        }
		
        public function getId_barber() { 
            return $this->id_barber; 
        }
		
        public function setId_barber($id_barber) { 
            $this->id_barber = $id_barber; 
        }
		
        public function getName() { 
            return $this->name; 
        }
		
        public function setName($name) { 
            $this->name = $name; 
        }
		
        public function getHaircut_price() { 
            return $this->haircut_price; 
        }
		
        public function setHaircut_price($haircut_price) { 
            $this->haircut_price = $haircut_price; 
        }
		
    }
?>
