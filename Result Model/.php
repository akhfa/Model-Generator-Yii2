<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table ''.
 *
 */
class  extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[[], 'required'],
			
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
			
		];
	}
}