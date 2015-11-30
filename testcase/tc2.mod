Hostname 127.0.0.1
User root
Password akhfa
Database rplsd2 {
	Table keluarga
	{
		Id integer auto_increment primary key
		Anak varchar 15
		Ibu varchar 50
		jum_kakak integer
	}
	Table rumah {
		Id integer auto_increment primary key
		Alamat TEXT
		Kodepos varchar 5
		Kode varchar 10
	}
	Table sekolah {
		id integer auto_increment primary key
		Alamat TEXT
		Telp varchar 25
	}
}
