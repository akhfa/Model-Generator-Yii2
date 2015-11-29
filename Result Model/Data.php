<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table 'data'.
 *
 */
class Data extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'data';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['alamat','kodepos'], 'required'],
			[['Alamat'], 'string'],
			[['Kodepos'], 'string', 'max' => 5]

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
			
		];
	}
}