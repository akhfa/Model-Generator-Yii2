<?php
// referensi
// http://stackoverflow.com/questions/1415577/accessing-variables-and-methods-outside-of-class-definitions
	$nama_file;
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
			global $password;
			global $databaseName;
			global $tables;

			$myfile = fopen($this->nama_file, "r") or die("Unable to open file!");
			// Output one line until end-of-file
			while(!feof($myfile)) {
			  	$line = fgets($myfile);
				if(strpos($line, "ostname") === 1)
				{
					$line = explode(" ", $line);
					$hostname = $line[1];
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
			$file_model = fopen("newfile.php", "w") or die("Unable to open file!");
			$template = "<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table 'negara'.
 *
 * @property integer \$id
 * @property string \$nama
 * @property integer \$jumlah
 */
class Negara extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'negara';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['nama', 'jumlah'], 'required'],
			[['jumlah'], 'integer'],
			[['nama'], 'string', 'max' => 50]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'nama' => 'Nama',
			'jumlah' => 'Jumlah',
		];
	}
}

			";
			fwrite($file_model, $template);
			fclose($file_model);
			
			echo "sukses";
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
		echo $hostname;
//		echo $nama_file."\n";
//		echo $readFile->nama_file;
	}
?>
