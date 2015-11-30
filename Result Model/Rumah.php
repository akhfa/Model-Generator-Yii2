<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table 'rumah'.
 *
 */
class Rumah extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'rumah';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['alamat','kodepos','kode'], 'required'],
			[['Alamat'], 'string', 'max' => 10],
			[['Kodepos'], 'string', 'max' => 5],
			[['Kode'], 'string', 'max' => 10]

			// e.g
			// [['nama', 'alamat', 'jumlah'], 'required'],
			// [['jumlah'], 'integer'],	#tipe data integer
			// [['alamat'], 'string'], #tipe data TEXT
			// [['nama'], 'string', 'max' => 50] #tipe data varchar
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'Id' => 'Id',
			'Alamat' => 'Alamat',
			'Kodepos' => 'Kodepos',
			'Kode' => 'Kode',
			
		];
	}
}