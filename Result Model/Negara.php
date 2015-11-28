<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table 'negara'.
 *
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
			[['id','nama','jumlah'], 'required'],
			[['id'], 'ID'],
			[['nama'], 'Nama'],
			[['jumlah'], 'Jumlah']

			// [['nama', 'jumlah'], 'required'],
			// [['jumlah'], 'integer'],
			// [['nama'], 'string', 'max' => 50]
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
			
			// 'id' => 'ID',
			// 'nama' => 'Nama',
			// 'jumlah' => 'Jumlah',
		];
	}
}