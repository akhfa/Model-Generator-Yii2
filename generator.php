// referensi
// http://stackoverflow.com/questions/1415577/accessing-variables-and-methods-outside-of-class-definitions
<?php
	$hostname;
	$password;
	$databaseName;

	Class Params{
		var $param_name;
		var $param_type;
		var $param_long;
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
		public function makeModel{

		}
	}
?>
