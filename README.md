# AppPayment
Halo 👋 Selamat Datang di Repository Payment Gateway Saya.
AppPayment adalah sebuah implementasi dan integrasi yang dibangun menggunakan Laravel 9 dalam bentuk API.

#### Tools yang digunakan dalam pengembangan

| Tools                                | Version       |
| -------------                        |:-------------:|
| Composer                             | 2.1.14        |
| Midtrans core API (Payment gateway)  | -             |
| Laravel 9.11                         | 9.11          |
| PHP                                  | 8.0.2         |
| Laravel Sanctum (Authentication)     | 2.15          |
| Laragon                              | 5.0           |
| Postman                              | -             | 

# Instalasi
* Klon Repository ini
* Ekstrak file yang telah didownload
* Jalankan terminal, dan arahkan terminal ke direktori ekstrak file menggunakan `cd pathtodirectory`
* Dalam terminal jalankan `composer install`
* Ubah nama file `.env.example` file ke `.env`
* Edit file _.env_ pada `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD` sesuaikan dengan konfigurasi database anda
* Didalam terminal jalankan `php artisan migrate`
* Lalu jalankan `php artisan db:seed` untuk mengisi database dengan data default 
* Selanjutnya, dalam terminal jalankan `php artisan serve`

Selesai, API berjalan pada localhost:8000/api

# Struktur Basis Data
### Class Diagram
![image](https://user-images.githubusercontent.com/11209553/174085557-32412b6e-87a2-4109-ba75-08261216d112.png)

### PhpMyAdmin Designer
![image](https://user-images.githubusercontent.com/11209553/174084240-83e6c535-904e-4f54-96fb-ee85857f6c3d.png)

# Autentikasi
### Users
Ada dua tipe user pada API ini, diantaranya 
1. User biasa
2. User organisasi

Pembeda dari dua user tersebut ada pada atribut **organization_id** dan **is_organization** pada tabel _users_. 

Pada user oganisasi, atribut _is_organization_ mengandung value true atau nilai 1, dan memiliki relasi dengan entitas **Organization**, dihubungkan dengan _foreign key organization_id_

Berikut adalah use case diagram untuk menggambarkan apa saja yang dapat dilakukkan oleh masing-masing user.

![image](https://user-images.githubusercontent.com/11209553/174103610-7f6a975e-3894-4ea9-a8d2-1b31d7e1b4a0.png)

### Kredensial

Berikut adalah email dan password default untuk melakukan login pada API

| Email                | Password         | Role            |
|----------------------|------------------|-----------------|
|user@test.com         | test123          | User biasa      | 
|kemendikbud@test.com  | test123          | User organisasi |


# Login
| Type  | Endpoint                        |
|-------|---------------------------------|
| POST  |localhost:8000/api/login         |

### Request Format (Body)
| Name     | Description                     |
|----------|---------------------------------|
| email    | required                        |
| password | required                        |

### Sample Response
Berikut adalah contoh response yang akan didapatkan jika login berhasil, silahkan simpan *access_token* pada header, untuk tipe authorization pilih *Bearer*. Token tersebut digunakan untuk mengakses fitur yang membutuhkan login.
```
{
    "status": "success",
    "message": "Login successfully",
    "errors": null,
    "content": {
        "status_code": 200,
        "access_token": "2|pyzsEI59uRqnKFe0NxVMJK9BZH2CnfnSNyy5uUNy",
        "token_type": "Bearer"
    }
}
```

### Contoh

![image](https://user-images.githubusercontent.com/11209553/174108275-dc1c1b8e-9de3-4f6c-895f-399900147e21.png)

# Logout
| Type  | Endpoint                        |
|-------|---------------------------------|
| POST  | localhost:8000/api/logout       |

### Headers 
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |
    
### Response 
```
{
    "status": "success",
    "message": "Logout successfully",
    "errors": null,
    "content": null
}
```
    
### Example
    
![image](https://user-images.githubusercontent.com/11209553/174118590-9fd32ae7-7b68-4981-af9f-a28f69c78ee3.png)

# Event
### Membuat Event
| Type  | Endpoint                         |
|-------|----------------------------------|
| POST  |localhost:8000/api/events         | 

### Request Format (Body)
| Name                 | Description                     |
|----------------------|---------------------------------|
| name                 | required, min 3                 |
| description          | required, min 5                 |
| price                | required, numeric               |
| schedule[]           | required                        |
| location             | required                        |
| location_description | required                        |
| rules                | required                        |

### Headers
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |
