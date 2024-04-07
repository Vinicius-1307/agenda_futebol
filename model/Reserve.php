
<?php
    class Reserve {
        private $id_reserve;
		private $id_schedule;
		private $id_barber;
		private $id_user;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createReserve() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Reserve (id_reserve, id_schedule, id_barber, id_user) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $this->id_reserve, $this->id_schedule, $this->id_barber, $this->id_user);
            return $stmt->execute();
        }
		
        public function deleteReserve() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Reserve WHERE id_reserve = ?");
            $stmt->bind_param("i", $this->id_reserve);
            return $stmt->execute();
        }
		
        public function updateReserve() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Reserve SET id_schedule=?,id_barber=?,id_user=? WHERE id_reserve = ?");
            $stmt->bind_param("iiii", $this->id_schedule, $this->id_barber, $this->id_user, $this->id_reserve );
            $stmt->execute();
        }
		
        public function readReserve($id_reserve) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Reserve WHERE id_reserve = ?");
            $stmt->bind_param("i", $id_reserve);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_reserve($linha->id_reserve);
				$this->setId_schedule($linha->id_schedule);
				$this->setId_barber($linha->id_barber);
				$this->setId_user($linha->id_user);
				
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Reserve");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorReserve = array();
            $i=0;
            while ($$linha = mysqli_fetch_object($result)) {
                $vetorReserve[$i] = new Reserve();
                $vetorReserve[$i]->setId_reserve($linha->id_reserve);
				$vetorReserve[$i]->setId_schedule($linha->id_schedule);
				$vetorReserve[$i]->setId_barber($linha->id_barber);
				$vetorReserve[$i]->setId_user($linha->id_user);
				
                $i++;
            }
            return $vetorReserve;
        }
		
        public function getId_reserve() { 
            return $this->id_reserve; 
        }
		
        public function setId_reserve($id_reserve) { 
            $this->id_reserve = $id_reserve; 
        }
		
        public function getId_schedule() { 
            return $this->id_schedule; 
        }
		
        public function setId_schedule($id_schedule) { 
            $this->id_schedule = $id_schedule; 
        }
		
        public function getId_barber() { 
            return $this->id_barber; 
        }
		
        public function setId_barber($id_barber) { 
            $this->id_barber = $id_barber; 
        }
		
        public function getId_user() { 
            return $this->id_user; 
        }
		
        public function setId_user($id_user) { 
            $this->id_user = $id_user; 
        }
		
    }
?>
