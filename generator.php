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
			$value = "negara";
			$template = file_get_contents('template.txt');
			$template = str_replace("#TABLE#", $value, $template);
			$template = str_replace("#MODELNAME#", ucwords($value), $template);
			$newFile = fopen('Result Model/'.ucwords($value).'.php', 'w');
			fwrite($newFile, $template);
			fclose($newFile);
			
			echo "sukses";
		}
	}
	
	// contoh jalananin fungsi dalam sebuah kelas
	$model = new ModelManager;
	$model->makeModel();
?>
