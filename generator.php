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
		public function cekKonfigurasi(){

		}

		// Masukkan semua objek di file konfigurasi ke variable global. Baca referensi.
		public function importToVariable(){

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
					while(strpos($lineParam,"}") === false)
					{
						// jika tidak ada "{"
						if(strpos($lineParam,"{") === false)
						{
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
						$lineParam = fgets($myfile);
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

		}
	}

	Class ModelManager{
		// Bikin file model dari yii2 nya di sini. Ambil data dari variable
		public function makeModel(){
			// model/table name
			$value = "negara";

			// e.g. attribute of table
			$b = array(
				'id' => 'ID',
				'nama' => 'Nama',
				'jumlah' => 'Jumlah'
			);

			// mengambil template
			$template = file_get_contents('template.txt');

			// nama table
			$template = str_replace("#TABLE#", $value, $template);

			// nama model
			$template = str_replace("#MODELNAME#", ucwords($value), $template);

			// memberi rules
			$template = str_replace("#RULES#", $this->rules($b), $template);

			// memberi atribut
			$template = str_replace("#ATTRIBUTE#", $this->attribute($b), $template);

			// menulis ke file
			$newFile = fopen('Result Model/'.ucwords($value).'.php', 'w');
			fwrite($newFile, $template);
			fclose($newFile);

			$this->rules($b);
			echo "sukses";
		}

		public function attribute($data){
			$result = "";
			foreach($data as $key => $value){
				$result = $result."'$key' => '$value',\n			";
			}
			return $result;
		}

		public function rules($data){
			$result = "";
			$required = "";
			$numItems = count($data);
			$i = 0;

			foreach($data as $key => $value){
				if(++$i === $numItems) {
					$required = $required."'$key'";
				} else {
					$required = $required."'$key',";
				}
			}

			$result = $result."[[".$required."], 'required'],\n			";

			$i = 0;
			foreach($data as $key => $value){
				if(++$i === $numItems) {
					$result = $result."[['$key'], '$value']\n";
				} else {
					$result = $result."[['$key'], '$value'],\n			";
				}
			}

			return $result;
		}
	}
	
	// contoh jalananin fungsi dalam sebuah kelas
	// $model = new ModelManager;
	// $model->makeModel();

	// Mulai dari sini udah beneran yaaa
	//Read argument
	$nama_file = $argv[1];

	if(is_null($nama_file))
		echo "Please set file name as an argument\n";
	else
	{
		$readFile = new TextFileManager;
		$readFile->setNamaFile($nama_file);
		$readFile->importToVariable();
		echo $hostname."\n";
		echo $username."\n";
		echo $password."\n";
		echo $databaseName."\n";
		foreach($tables as $table)
		{
			echo "tableName = ".$table->tableName."\n";
			$params = $table->params;

			foreach($params as $param)
			{
				echo "param_name = ".$param->param_name."\n";
				echo "param_type = ".$param->param_type."\n";
				echo "param_long = ".$param->param_long."\n";
				echo "param_other = ".$param->param_other."\n";
			}
		}
	}
?>
