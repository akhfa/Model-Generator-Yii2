<?php
// referensi
// http://stackoverflow.com/questions/1415577/accessing-variables-and-methods-outside-of-class-definitions
	$hostname;
	$password;
	$databaseName;

	Class Params{
		var $param_name;	// nama parameter (id, username, password, dll)
		var $param_type;	// tipe data (int, varchar, text, dll)
		var $param_long;	// panjang tipe data (10,20, dll)
		var $param_other;	// string lain (auto increment, primary key)
	}
	
	Class Table {
		var $params; //-> array of class Params
	}

	$tables = array(); //-> untuk ngisi array, pakai array put

	Class FileManager{
		// Melakukan pengecekan pada konfigurasi file, apakah ada kesalahan
		var $nama_file;
		public function cekKonfigurasi(){

		}

		// Masukkan semua objek di file konfigurasi ke variable global. Baca referensi.
		public function importToVariable(){

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
	$model = new ModelManager;
	$model->makeModel();
?>
