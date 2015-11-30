<?php
// referensi
// http://stackoverflow.com/questions/1415577/accessing-variables-and-methods-outside-of-class-definitions
	$nama_file;
	$hostname;
	$username;
	$password;
	$databaseName;

	Class Param{
		public $param_name;	// nama parameter (id, username, password, dll)
		public $param_type;	// tipe data (int, varchar, text, dll)
		public $param_long;	// panjang tipe data (10,20, dll)
		public $param_other;	// string lain (auto increment, primary key)
	}
	
	Class Table {
		public $tableName;
		public $params; //-> array of class Params
	}

	$tables = array(); //-> untuk ngisi array, pakai array put

	Class JsonFileManager{
		// Melakukan pengecekan pada konfigurasi file, apakah ada kesalahan
		var $nama_file;

		function setNamaFile($_filename)
		{
			$this->nama_file = $_filename;
		}

		function getNamaFile()
		{
			return $this->nama_file;
		}

		public function cekKonfigurasi(){
			return (strcmp($this->nama_file,"") == 0);
		}

		// Masukkan semua objek di file konfigurasi ke variable global. Baca referensi.
		public function importToVariable(){
			global $hostname;
			global $username;
			global $password;
			global $databaseName;
			global $tables;
			$myfile = fopen($this->nama_file, "r") or die("Unable to open file!");
			$json = fread($myfile,filesize($this->nama_file));
			fclose($myfile);
			$json_decode = json_decode($json);
			$hostname = $json_decode->hostname;
			$username = $json_decode->username;
			$password = $json_decode->password;
			$databaseName = $json_decode->database->databasename;
			$tables = $json_decode->database->tables;
			foreach ($tables as $table){
				$table->params = array();
				foreach ($table->param as $lineParam){
					$param = new Param;
					$lineParam = explode(" ", $lineParam, 4);
					$param->param_name = preg_replace('/\s+/S', "", $lineParam[0]);
					$param->param_type = $lineParam[1];

					if(is_numeric($lineParam[2]))
					{
						$param->param_long = $lineParam[2];
						$param->param_other = $lineParam[3];
					}
					else
					{
						$param->param_long = 0;
						$param->param_other = $lineParam[2]." ".$lineParam[3];
					}
					array_push($table->params, $param);
				}
			}
			var_dump($tables);
		}
	}

	Class TextFileManager{
		private $nama_file;

		function setNamaFile($_filename)
		{
			$this->nama_file = $_filename;
		}

		function getNamaFile()
		{
			return $this->nama_file;
		}

		function cekKonfigurasi(){

		}

		// Masukkan semua objek di file konfigurasi ke variable global. Baca referensi.
		function importToVariable(){
			global $hostname;
			global $username;
			global $password;
			global $databaseName;
			global $tables;

			$myfile = fopen($this->nama_file, "r") or die("Unable to open file!");
			// Output one line until end-of-file
			while(!feof($myfile)) {
			  	$line = fgets($myfile);

			  	// hilangkan newline
			  	$line = trim(preg_replace('/\s+/', ' ', $line));
				
				if(strpos(strtolower($line), "hostname") === 0)
				{
					$line = explode(" ", $line);
					$hostname = $line[1];
				}
				else if(strpos(strtolower($line),"user") === 0)
				{
					$line = explode(" ", $line);
					$username = $line[1];
				}
				else if(strpos(strtolower($line),"pass") === 0)
				{
					$line = explode(" ", $line);
					$password = $line[1];
				}
				else if(strpos(strtolower($line),"data") === 0)
				{
					$line = explode(" ", $line);
					$databaseName = $line[1];
				}
				else if(strpos(strtolower($line),"table") !== false)
				{
					$table = new Table;
					$table->params = array();

					$line = explode(" ", $line);
					$table->tableName = $line[1];

					// Cari parameternya
					$lineParam = fgets($myfile);
					$lineParam = trim(preg_replace('/\s+/', ' ', $lineParam));

					while(strpos($lineParam,"}") === false)
					{
						// jika tidak ada "{"
						if(strpos($lineParam,"{") === false)
						{
							$param = new Param;
							$lineParam = explode(" ", $lineParam, 4);
							$param->param_name = preg_replace('/\s+/S', "", $lineParam[0]);
							$param->param_type = $lineParam[1];

							// echo "is_numeric ".$lineParam[2]." = ".is_numeric($lineParam[2])."\n";
							if(is_numeric($lineParam[2]))
							{
								$param->param_long = $lineParam[2];
								$param->param_other = $lineParam[3];
							}
							else
							{
								$param->param_long = 0;
								$param->param_other = $lineParam[2]." ".$lineParam[3];
							}
							array_push($table->params, $param);
						}
						$lineParam = fgets($myfile);
						$lineParam = trim(preg_replace('/\s+/', ' ', $lineParam));
					}
					array_push($tables, $table);
				}
			}
			fclose($myfile);
		}
	}

	Class DatabaseManager{
		// Ambil data data yang ada di variable global, terus masukkan ke database
		
		public function createDatabase()
		{
			global $servername;
			global $databaseName;
			global $username;
			global $password;
			global $hostname;

			try {
			    $conn = new PDO("mysql:host=$hostname", $username, $password);
			    
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $sql = "CREATE DATABASE ".$databaseName;

			    // use exec() because no results are returned
			    $conn->exec($sql);
			    echo "Database created successfully\n";
		    }
			catch(PDOException $e){
				// jika error database exist
				if(strpos($e->getMessage(), "database exists") !== false)
				{
					$this->dropDatabase();
					return $this->createDatabase();
				}
				else
				{
					echo $sql . " --> " . $e->getMessage()."\n";
					return false;
				}
	    	}

			$conn = null;
			return $this->createTable();
		}

		public function dropDatabase()
		{
			global $servername;
			global $databaseName;
			global $username;
			global $password;
			global $hostname;
			$sql;
			try{
				$conn = new PDO("mysql:host=$hostname", $username, $password);
			    
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $sql = "DROP DATABASE ".$databaseName;

			    // use exec() because no results are returned
			    $conn->exec($sql);
			    return true;
			}
			catch(PDOException $e)
			{
				echo $sql . " --> " . $e->getMessage()."\n";
				return false;
			}
		}

		public function createTable() {

			global $servername;
			global $databaseName;
			global $username;
			global $password;
			global $tables;
			$sql;

			try {
			    $conn = new PDO("mysql:host=$servername;dbname=$databaseName", $username, $password);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			    foreach($tables as $table) {
			    	$sql = "CREATE TABLE ".$table->tableName." (";
			    	$param = "";
			    	foreach($table->params as $argument) {
			    		if($argument->param_long === 0)
			    		{
			    			$param = $param.$argument->param_name." ".$argument->param_type." ".$argument->param_other.", ";
			    		}
			    		else
			    		{
			    			$param = $param.$argument->param_name." ".$argument->param_type."(".$argument->param_long.") ".$argument->param_other.", ";
			    		}
					}
					$postfix = ")";
				echo $sql.chop($param, " ,").$postfix."\n";

			    // use exec() because no results are returned
			    $conn->exec($sql.chop($param, " ,").$postfix);
			    echo "Table ".$table->tableName." created successfully\n";
		    	}
			}
			catch(PDOException $e){
			    echo $sql . "\n" . $e->getMessage();
			    return false;
		    }

			$conn = null;

			return true;
		}
	}

	Class ModelManager{
		/* Generate model */
		public function makeModel($table, $params){
			// mengambil template
			$template = file_get_contents('template.txt');

			// nama table
			$template = str_replace("#TABLE#", strtolower($table), $template);

			// nama model
			$template = str_replace("#MODELNAME#", ucwords($table), $template);

			// memberi rules
			$template = str_replace("#RULES#", $this->rules($params), $template);

			// memberi atribut
			$template = str_replace("#ATTRIBUTE#", $this->attribute($params), $template);

			// menulis ke file
			$newFile = fopen('Result Model/'.ucwords($table).'.php', 'w');
			fwrite($newFile, $template);
			fclose($newFile);

			echo "sukses";
		}

		/* Generate atribut pada model */
		public function attribute($data){
			$result = "";
			foreach($data as $value){
				$result = $result."'".$value->param_name."' => '".$value->param_name."',\n			";
			}

			return $result;
		}

		/* Generate atribut pada model */
		public function rules($data){
			array_shift($data);			// skip first element 'id'
			
			$required = "";				// hasil pertama
			$result = "";				// hasil akhir
			$numItems = count($data);	// menghitung jumlah element
			
			## Tahap pertama : 'required'  ##
			// mengambil dara dari table
			$i = 0;
			foreach($data as $value){
				if(++$i === $numItems) {
					$required = $required."'".strtolower($value->param_name)."'";
				} else {
					$required = $required."'".strtolower($value->param_name)."',";
				}
			}

			// hasil pertama berupa record yang 'required' disimpan pada $result
			$result = $result."[[".$required."], 'required'],\n			";

			## Tahap kedua : rules ##
			// mengambil data dari table
			$i = 0;
			foreach($data as $value){
				if(++$i === $numItems) {	// jika element terakhir
					if(empty($value->param_long) || (!strcmp($value->param_long, "0")) || (!strcmp($this->data_type($value->param_type), "integer"))){
						// jika tidak ada param_long atau '0' atau param_type='integer'
						$result = $result."[['".$value->param_name."'], '".$this->data_type($value->param_type)."']\n";
					} else {
						$result = $result."[['".$value->param_name."'], '".$this->data_type($value->param_type)."', 'max' => ".$value->param_long."]\n";
					}
				} else {	// jika bukan element terakhir
					if(empty($value->param_long) || (!strcmp($value->param_long, "0")) || (!strcmp($this->data_type($value->param_type), "integer"))){
						// jika tidak ada param_long atau '0' atau param_type='integer'
						$result = $result."[['".$value->param_name."'], '".$this->data_type($value->param_type)."'],\n			";
					} else {
						$result = $result."[['".$value->param_name."'], '".$this->data_type($value->param_type)."', 'max' => ".$value->param_long."],\n			";
					}
				}
			}
			
			// hasil dari tahap pertama dan tahap kedua
			return $result;
		}
		
		/* Konvert tipe data */
		public function data_type($data){
			switch (strtolower($data)) {
				case "integer":
					return "integer";
					break;
				case "varchar":
					return "string";
					break;
				case "text":
					return "string";
					break;
				default:
					return "";
			}
		}
	}

	//main procedure
	//Read argument
	$nama_file = $argv[1];
	$file_parts = pathinfo($nama_file);
	$readFile;
	if(is_null($nama_file))
		echo "Please set file name as an argument\n";
	else if (strcmp($file_parts['extension'],"json") == 0){
		$readFile = new JsonFileManager;
		$readFile->setNamaFile($nama_file);
		$readFile->importToVariable();
		echo $nama_file."\n";
		echo $hostname."\n";
		echo $username."\n";
		echo $password."\n";
		echo $databaseName."\n";
	}
	else
	{
		$readFile = new TextFileManager;
		$readFile->setNamaFile($nama_file);
		$readFile->importToVariable();
		echo $hostname."\n";
		echo $username."\n";
		echo $password."\n";
		echo $databaseName."\n";
	}

	// tulis model ke php
	$dbManager = new DatabaseManager;
	
	if($dbManager->createDatabase())
	{
		// Generate yii model
		foreach($tables as $table)
		{
			$model = new ModelManager;
			$model->makeModel($table->tableName, $table->params);
			echo "create model for table ".$table->tableName." success\n";
		}
	}
	else
	{
		echo "database fail\n";
	}
?>
