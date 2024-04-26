
<?php
    require_once("Database.php");
    class Schedules {
        private $id_schedule;
		private $initial_hour;
		private $final_hour;
		private $banco;
		
        function __construct() {
            $this->banco = new BancoTcc_rodrigo();
        }
		
        public function createSchedules() {
            $stmt = $this->banco->getConexao()->prepare("INSERT INTO Schedules (id_schedule, initial_hour, final_hour) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $this->id_schedule, $this->initial_hour, $this->final_hour);
            return $stmt->execute();
        }
		
        public function deleteSchedules() {
            $stmt = $this->banco->getConexao()->prepare("DELETE FROM Schedules WHERE id_schedule = ?");
            $stmt->bind_param("i", $this->id_schedule);
            return $stmt->execute();
        }
		
        public function updateSchedules() {
            $stmt = $this->banco->getConexao()->prepare("UPDATE Schedules SET initial_hour=?,final_hour=? WHERE id_schedule = ?");
            $stmt->bind_param("i", $this->initial_hour, $this->final_hour, $this->id_schedule );
            $stmt->execute();
        }
		
        public function readSchedules($id_schedule) {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Schedules WHERE id_schedule = ?");
            $stmt->bind_param("i", $id_schedule);
            $stmt->execute();
            $resultado = $stmt->get_result();
            while ($linha = $resultado->fetch_object()) { 
                $this->setId_schedule($linha->id_schedule);
				$this->setinitial_hour($linha->initial_hour);
				$this->setFinal_hour($linha->final_hour);
				
            }
            return $this;     
        }
		
        public function readAll() {
            $stmt = $this->banco->getConexao()->prepare("SELECT * FROM Schedules");
            $stmt->execute();
            $result = $stmt->get_result();
            $vetorSchedules = array();
            $i=0;
            while ($$linha = mysqli_fetch_object($result)) {
                $vetorSchedules[$i] = new Schedules();
                $vetorSchedules[$i]->setId_schedule($linha->id_schedule);
				$vetorSchedules[$i]->setinitial_hour($linha->initial_hour);
				$vetorSchedules[$i]->setFinal_hour($linha->final_hour);
				
                $i++;
            }
            return $vetorSchedules;
        }
		
        public function getId_schedule() { 
            return $this->id_schedule; 
        }
		
        public function setId_schedule($id_schedule) { 
            $this->id_schedule = $id_schedule; 
        }
		
        public function getinitial_hour() { 
            return $this->initial_hour; 
        }
		
        public function setinitial_hour($initial_hour) { 
            $this->initial_hour = $initial_hour; 
        }
		
        public function getFinal_hour() { 
            return $this->final_hour; 
        }
		
        public function setFinal_hour($final_hour) { 
            $this->final_hour = $final_hour; 
        }
		
    }
?>
