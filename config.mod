Hostname 127.0.0.1 
User root 
Password akhfa 
Database Mysistem { 
	Table Users 
	{ 
		Id integer auto increment
		Username varchar 15 primary key 
		Password varchar 50 
	} 
	Table rumah { 
		Id integer auto increment 
		Alamat TEXT 500 
		Kodepos varchar 5 
	} 
}
