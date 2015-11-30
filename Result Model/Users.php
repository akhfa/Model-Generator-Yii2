<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table 'users'.
 *
 */
class Users extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'users';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username','password','kode'], 'required'],
			[['Username'], 'string', 'max' => 15],
			[['Password'], 'string', 'max' => 50],
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
			'Username' => 'Username',
			'Password' => 'Password',
			'Kode' => 'Kode',
			
		];
	}
}