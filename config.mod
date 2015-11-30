Hostname 127.0.0.1 
User root 
Password
Database rplsd1 { 
	Table Users 
	{ 
		Id integer 5 auto increment 
		Username varchar 15 primary key 
		Password varchar 50 
		Kode varchar 10 
	} 
	Table rumah { 
		Id integer 5 auto increment 
		Alamat TEXT 10 
		Kodepos varchar 5 
		Kode varchar 10 
	} 
} 
