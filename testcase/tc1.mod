Hostname 127.0.0.1
User root
Password akhfa
Database rplsd1 {
	Table Users
	{
		Id integer auto_increment primary key
		Username varchar 15
		Password varchar 50
		Kode varchar 10
	}
	Table rumah {
		Id integer auto_increment primary key
		Alamat TEXT 10
		Kodepos varchar 5
		Kode varchar 10
	}
}
