<?php
$model = new adatbazis();
$model->kapcsolodas();
$model->select();
$model->kapcsolatbontas();

$insert = new adatbazis();
$insert->kapcsolodas();
$insert->selcet_ordernumber_form();
$insert->kapcsolatbontas();	

if (isset($_GET["action"]) and $_GET["action"]=="cmd_ordernumber"){
	$insert = new adatbazis();
	$insert->kapcsolodas();
	$insert->selcet_ordernumber();
	$insert->kapcsolatbontas();	
}

class adatbazis{
	public	$servername = "localhost:3307";
	public	$username = "root";
	public	$password = "";
	public	$dbname = "classicmodels";
	public $conn = NULL;
	public $sql = NULL;
	public $result = NULL;
	public $row = NULL;
	
	public function kapcsolodas(){
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}	
		$this->conn->query("SET NAMES 'UTF8';");
    }
    public function select(){
		$this->sql = "SELECT 
						`productCode`, 
						`productName`,
                        `productLine`,
                        `productScale`,
                        `productVendor`,
                        `productDescription`,
                        `quantityInStock`,
                        `buyPrice`,
                        `MSRP`
				    FROM 
                        `products`
                    WHERE
                    `buyPrice`>=90 AND `buyPrice`<=100";
		$this->result = $this->conn->query($this->sql);

		if ($this->result->num_rows > 0) {
			while($this->row = $this->result->fetch_assoc()) {
				echo "<p style=display:inline;>";
					echo $this->row["productCode"] . " - ";
                    echo $this->row["productName"] . " - ";
                    echo $this->row["productLine"] . " - ";
                    echo $this->row["productScale"] . " - ";
                    echo $this->row["productVendor"] . " - ";
                    echo $this->row["productDescription"] . " - ";
                    echo $this->row["quantityInStock"] . " - ";
                    echo $this->row["buyPrice"] . " - ";
                    echo $this->row["MSRP"] . "<br />";
				echo "</p>";
			}
		} else {
			echo "Nincs adat az adatbázisban.";
        }	
        echo "<br/><br/><br/>";	
    }

    public function selcet_ordernumber_form(){
		?>
		<h1>OrderNumber</h1>
		<form method="GET">
			Add meg az ordernumbert: <br />
			<input type="number" name="input_ON"><br />	
			<input type="hidden" name="action" value="cmd_ordernumber">
			<input type="submit" value="Keresés">
		</form>			
		<?php
    }
    public function selcet_ordernumber(){
                $this->sql = "SELECT 
                o.orderNumber,
                o.orderDate,
                o.requiredDate,
                o.shippedDate,
                o.status,
                o.comments,
                o.customerNumber,
                od.productCode,
                od.quantityOrdered,
                od.priceEach,
                od.orderLineNumber,
                p.productName                    
            FROM 
                orders o
            INNER JOIN orderdetails od 
                ON od.orderNumber=o.orderNumber
            INNER JOIN products p 
                ON p.productCode=od.productCode
            WHERE
            o.orderNumber=".$_GET["input_ON"]."";
        
		$this->result = $this->conn->query($this->sql);

		if ($this->result->num_rows > 0) {
			while($this->row = $this->result->fetch_assoc()) {
				echo "<p style=display:inline;>";
					echo $this->row["orderNumber"] . " - ";
                    echo $this->row["orderDate"] . " - ";
                    echo $this->row["requiredDate"] . " - ";
                    echo $this->row["shippedDate"] . " - ";
                    echo $this->row["status"] . " - ";
                    echo $this->row["comments"] . " - ";
                    echo $this->row["customerNumber"] . " - ";
                    echo $this->row["productCode"] . " - ";
                    echo $this->row["quantityOrdered"] . " - ";
                    echo $this->row["priceEach"] . " - ";
                    echo $this->row["orderLineNumber"] . " - ";
                    echo $this->row["productName"] . " <br /> ";
				echo "</p>";
			}
		} else {
			echo "Nincs adat az adatbázisban.";
        }	
	}



    public function kapcsolatbontas(){
        $this->conn->close();		
    }
}
?>