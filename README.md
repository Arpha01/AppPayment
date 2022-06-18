# AppPayment
Halo 👋 Selamat Datang di Repository Payment Gateway Saya.
AppPayment adalah sebuah implementasi dan integrasi payment gateway yang dibangun menggunakan Laravel 9 dalam bentuk API.

Creator: Mohammad Arfan Maulana

API ini tidak hanya mencakup payment gateway checkout dan pembayaran saja, namun juga mencakup pengelolaan event (membuat, mengupdate, menghapus, melihat daftar event), dan juga kelola transaksi (membatalkan, melihat daftar transaksi)

#### Tools yang digunakan dalam pengembangan

| Tools                                | Version       |
| -------------                        |:-------------:|
| Composer                             | 2.1.14        |
| Midtrans core API (Payment gateway)  | -             |
| Laravel                              | 9.11          |
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
Sebelum menggunakan fitur lain, diharuskan login terlebih dahulu

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
Berikut screenshot contoh request login menggunakan aplikasi postman

![image](https://user-images.githubusercontent.com/11209553/174108275-dc1c1b8e-9de3-4f6c-895f-399900147e21.png)

# Logout
Setelah selesai melakukan aktivitas, user dapat melakukan logout
| Type  | Endpoint                        |
|-------|---------------------------------|
| POST  | localhost:8000/api/logout       |

### Headers 
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |
    
### Sample Response 
Berikut adalah contoh response yang akan didapatkan jika logout berhasil, token yang digunakan sebelumnya tidak akan lagi berfungsi.
```
{
    "status": "success",
    "message": "Logout successfully",
    "errors": null,
    "content": null
}
```
    
### Example
Berikut screenshot contoh request logout menggunakan aplikasi postman 

![image](https://user-images.githubusercontent.com/11209553/174118590-9fd32ae7-7b68-4981-af9f-a28f69c78ee3.png)

# Mendapatkan Daftar Event
User dapat melihat event apa saja yang terdapat pada sistem, berikut adalah cara mendapatkan daftar event, daftar event dilimit default 10 item menggunakan pagination
| Type  | Endpoint                         |
|-------|----------------------------------|
| GET   |localhost:8000/api/events         | 

### Headers
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |

### Sample Response
Berikut adalah contoh response yang akan didapatkan jika request berhasil
```
{
    "data": [
        {
            "id": 4,
            "name": "Pemanfaatan Data Mining pada Revolusi Industri 4.0",
            "description": "Memanfaatkan secara maksimal prosedur data mining",
            "price": "Rp. 50.000",
            "schedule": "[\"11-06-2022\", \"12-06-2022\"]",
            "location": "Tangerang Selatan",
            "location_description": "Depan Pasar Ciputat",
            "rules": "Mengenakan Masker dan faceshield",
            "organization": {
                "id": 1,
                "name": "Kemendikbud RI",
                "slug": "kemendikbud-ri",
                "created_at": "14-06-2022"
            }
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/events?page=1",
        "last": "http://localhost:8000/api/events?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/events?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://localhost:8000/api/events",
        "per_page": 10,
        "to": 2,
        "total": 2
    },
    "success": true,
    "total": 2,
    "code": 206
}
```

### Example
Berikut screenshot contoh request daftar event menggunakan aplikasi postman 

![image](https://user-images.githubusercontent.com/11209553/174245636-51c2df39-599b-492e-a188-233dfb9cac83.png)


# Membuat Event
Jika user yang digunakan adalah tipe __user organisasi__, user dapat membuat event baru, berikut adalah cara dan format membuat event baru
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

### Sample Response
Berikut adalah contoh response yang akan didapatkan jika event berhasil dibuat
```
{
    "data": {
        "id": 4,
        "name": "Contoh nama event",
        "description": "deskripsi panjang event",
        "price": "Rp. 40.000",
        "schedule": "[\"11-06-2022\",\"12-07-2022\"]",
        "location": "Tangerang Selatan",
        "location_description": "Depan Pasar Ciputat",
        "rules": "Mengenakan Masker",
        "organization": {
            "id": 1,
            "name": "Kemendikbud RI",
            "slug": "kemendikbud-ri",
            "created_at": "14-06-2022"
        }
    },
    "success": true,
    "total": 2,
    "code": 206
}
```

### Example
Berikut screenshot contoh request membuat event menggunakan aplikasi postman 

![image](https://user-images.githubusercontent.com/11209553/174242872-098adcb4-f1f5-442a-89ca-770cb2ebfe64.png)
![image](https://user-images.githubusercontent.com/11209553/174242938-442e5a02-e328-4d4c-a630-891480b134d5.png)


# Mengupdate Event 
Jika user yang digunakan adalah tipe __user organisasi__, user dapat mengedit event, berikut adalah cara dan format mengedit event. Event yang akan diedit haruslah memiliki atribut _organization_id_ yang sama dengan user.
| Type  | Endpoint                            |
|-------|-------------------------------------|
| PUT   |localhost:8000/api/events/{eventid}  | 

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

### Sample Response
Berikut adalah contoh response yang akan didapatkan jika event berhasil diupdate.
```
{
    "data": {
        "id": 4,
        "name": "Contoh nama event",
        "description": "Memanfaatkan secara maksimal prosedur data mining",
        "price": "Rp. 50.000",
        "schedule": "[\"11-06-2022\",\"12-06-2022\"]",
        "location": "Tangerang Selatan",
        "location_description": "Depan Pasar Ciputat",
        "rules": "Mengenakan Masker dan faceshield",
        "organization": {
            "id": 1,
            "name": "Kemendikbud RI",
            "slug": "kemendikbud-ri",
            "created_at": "14-06-2022"
        }
    },
    "success": true,
    "total": 2,
    "code": 206
}
```

### Example
Berikut screenshot contoh request mengedit event menggunakan aplikasi postman 

![image](https://user-images.githubusercontent.com/11209553/174245284-7bb3c1b5-72fb-44f5-b1dd-9f126a69b340.png)
![image](https://user-images.githubusercontent.com/11209553/174245349-58b78708-6a46-4f01-89d9-f27f6b324238.png)


# Menghapus Event
Jika user yang digunakan adalah tipe __user organisasi__, user dapat menghapus event, berikut adalah cara dan format mengedit event. Event yang akan dihapus haruslah memiliki atribut _organization_id_ yang sama dengan user.
| Type   | Endpoint                            |
|--------|-------------------------------------|
| DELETE | localhost:8000/api/events/{eventid} | 

### Headers
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |

### Sample Response 
Berikut adalah contoh response yang akan didapatkan jika event berhasil dihapus.
```
{
    "success": true,
    "code": 200
}
```

### Example
Berikut adalah contoh response menghapus event menggunakan aplikasi postman.

![image](https://user-images.githubusercontent.com/11209553/174246157-19d029c5-3526-4f02-9b22-a7f2031e190f.png)


# Checkout Event
Berikut adalah bagian checkout tiket event

| Type  | Endpoint                            |
|-------|-------------------------------------|
| POST  |localhost:8000/api/checkout          |

### Request Format (Body)
Pada event_id diharuskan sesuai dengan id event yang ada.

| Name                 | Description                                           |
|----------------------|-------------------------------------------------------|
| event_id             | required, numeric, exists                             |
| amount               | required, numeric                                     |
| payment_method       | required, enum:bni,bca,bri,indomaret,alfamart,gopay   |
| ticket_schedules[]    | required                                              |

### Headers
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |

### Sample Response 
Berikut adalah contoh response yang akan didapatkan jika checkout tiket berhasil.
```
{
    "data": {
        "id": "order-1-1-1655548920",
        "event_id": "1",
        "amount": "2",
        "total_price": 80000,
        "status": "pending",
        "payment_method": "indomaret",
        "payment_code": "052179521795",
        "expired_at": "19-06-2022 10:42",
        "ticket_schedule": [
            "11-06-2022"
        ],
        "event": {
            "id": 1,
            "name": "Pemanfaatan Data Mining pada Revolusi Industri 4.0",
            "description": "Memanfaatkan secara maksimal prosedur data mining",
            "price": "Rp. 40.000",
            "schedule": "[\"11-06-2022\", \"12-07-2022\"]",
            "location": "Tangerang Selatan",
            "location_description": "Depan Pasar Ciputat",
            "rules": "Mengenakan Masker",
            "organization": {
                "id": 1,
                "name": "Kemendikbud RI",
                "slug": "kemendikbud-ri",
                "created_at": "18-06-2022"
            }
        }
    },
    "success": true,
    "total": 1,
    "code": 206
}
```

Setelah berhasil checkout, transaksi akan terbuat namun pembayaran masih dalam status __pending__

### Example
Berikut adalah contoh response checkout menggunakan aplikasi postman.

![image](https://user-images.githubusercontent.com/11209553/174434178-eeee9928-c6d6-40e0-b1f7-949e2938ee09.png)


# Verifikasi atau Konfirmasi Pembayaran
Sebelum melakukan konfirmasi atau verifikasi pembayaran ini, diharuskan terlebih dahulu untuk membayar atau menggunakan simulasi pembayaran yang disediakan oleh Midtrans sebagai berikut: 
(Sesuaikan dengan metode pembayarannya)

| Nama                          | Link                                                   |
|-------------------------------|----------------------------                            |
| Indomaret simulator           | https://simulator.sandbox.midtrans.com/indomaret/index |
| Alfamart simulator            | https://simulator.sandbox.midtrans.com/alfamart/index  |
| BCA Virtual Account simulator | https://simulator.sandbox.midtrans.com/bca/va/index    |
| BNI Virtual Account simulator | https://simulator.sandbox.midtrans.com/bni/va/index    |
| BRI Virtual Account simulator | https://simulator.sandbox.midtrans.com/bri/va/index    |

### Cara penggunaan simulator
1. Ikuti sesuai petunjuk yang tertera. Pada halaman simulator, dalam contoh ini saya menggunakan metode pembayaran Indomaret, pada kolom payment code masukkan payment code yang didapat saat checkout.
2. Lalu tekan tombol __Inquire__
![image](https://user-images.githubusercontent.com/11209553/174251595-6333211a-c01a-4229-aced-661e7afd6bb8.png)
3. Setelah itu akan muncul detail tiket event yang dibeli, klik tombol __Pay__
![image](https://user-images.githubusercontent.com/11209553/174251824-a6623d98-b8e7-4c00-a9f3-8aa874fb76aa.png)
4. Akan muncul message success transaction. lalu lakukkan konfirmasi pembayaran pada API



| Type  | Endpoint                                |
|-------|-----------------------------------------|
| POST  |localhost:8000/api/payment/verify/{id}   |

Ket : 
__id__ diisi dengan id yang didapat pada saat checkout, dalam format order-x-x-xxxxxx, contoh `localhost:8000/api/payment/verify/order-6-3-1655451787`

### Headers
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |

### Sample Response 
Berikut adalah contoh response yang akan didapatkan jika verifikasi pembayaran sukses.

```
{
    "data": {
        "id": "order-1-1-1655548920",
        "event_id": 1,
        "amount": 2,
        "total_price": "80000",
        "status": "paid",
        "payment_method": "indomaret",
        "payment_code": "052179521795",
        "expired_at": "19-06-2022 10:42",
        "ticket_schedule": [
            "11-06-2022"
        ],
        "event": {
            "id": 1,
            "name": "Pemanfaatan Data Mining pada Revolusi Industri 4.0",
            "description": "Memanfaatkan secara maksimal prosedur data mining",
            "price": "Rp. 40.000",
            "schedule": "[\"11-06-2022\", \"12-07-2022\"]",
            "location": "Tangerang Selatan",
            "location_description": "Depan Pasar Ciputat",
            "rules": "Mengenakan Masker",
            "organization": {
                "id": 1,
                "name": "Kemendikbud RI",
                "slug": "kemendikbud-ri",
                "created_at": "18-06-2022"
            }
        }
    },
    "success": true,
    "total": 1,
    "code": 206
}
```

Dalam response tersebut, akan terlihat bahwa status akan berubah menjadi _paid_ jika dalam kondisi sudah dibayar atau menggunakan simulator.

### Example
Berikut adalah contoh response verifikasi pembayaran menggunakan aplikasi postman.

![image](https://user-images.githubusercontent.com/11209553/174256187-67f79896-5fa5-4e5f-aa38-e286e3bb7697.png)


# Melihat daftar transaksi
Fitur ini digunakan untuk melihat daftar transaksi user yang sedang login

| Type   | Endpoint                            |
|--------|-------------------------------------|
| GET    | localhost:8000/api/transaction      | 

### Headers
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |

### Sample Response
Berikut adalah contoh response yang akan didapatkan jika daftar transaksi berhasil didapat.
```
{
    "data": [
        {
            "id": "order-2-3-1655202009",
            "event_id": 3,
            "amount": 3,
            "total_price": "934320",
            "status": "pending",
            "payment_method": "gopay",
            "payment_code": null,
            "expired_at": "15-06-2022 10:20",
            "ticket_schedule": "\"[\\\"1995-05-23\\\",\\\"1985-12-20\\\"]\"",
            "event": {
                "id": 3,
                "name": "Iste quos pariatur reprehenderit doloribus voluptas.",
                "description": "Quo repellendus quisquam ut ut voluptatibus impedit. Vitae rem modi quos et sunt eaque. Et quos voluptatem est.",
                "price": "Rp. 311.440",
                "schedule": "\"[\\\"1995-05-23\\\",\\\"1985-12-20\\\"]\"",
                "location": "Reidview",
                "location_description": "Voluptatem doloremque.",
                "rules": "Consequatur voluptates iusto quo rerum molestiae. Dolorum sit libero voluptatem ipsum. Corrupti voluptatem ut dolores fugiat dolorum reiciendis quia.",
                "organization": {
                    "id": 1,
                    "name": "Kemendikbud RI",
                    "slug": "kemendikbud-ri",
                    "created_at": "14-06-2022"
                }
            }
        },
        {
            "id": "order-6-3-1655451787",
            "event_id": 3,
            "amount": 1,
            "total_price": "311440",
            "status": "paid",
            "payment_method": "indomaret",
            "payment_code": "926537065370",
            "expired_at": "18-06-2022 07:43",
            "ticket_schedule": [
                "11-06-2022"
            ],
            "event": {
                "id": 3,
                "name": "Iste quos pariatur reprehenderit doloribus voluptas.",
                "description": "Quo repellendus quisquam ut ut voluptatibus impedit. Vitae rem modi quos et sunt eaque. Et quos voluptatem est.",
                "price": "Rp. 311.440",
                "schedule": "\"[\\\"1995-05-23\\\",\\\"1985-12-20\\\"]\"",
                "location": "Reidview",
                "location_description": "Voluptatem doloremque.",
                "rules": "Consequatur voluptates iusto quo rerum molestiae. Dolorum sit libero voluptatem ipsum. Corrupti voluptatem ut dolores fugiat dolorum reiciendis quia.",
                "organization": {
                    "id": 1,
                    "name": "Kemendikbud RI",
                    "slug": "kemendikbud-ri",
                    "created_at": "14-06-2022"
                }
            }
        }
    ]
}
```
### Example
Berikut adalah contoh response daftar transaksi menggunakan aplikasi postman.

![image](https://user-images.githubusercontent.com/11209553/174256029-d810e3fe-cc81-45c8-8d41-91ee96aa8c0e.png)


# Melihat detail transaksi
User juga dapat melihat detail transaksi dengan id tertentu

| Type   | Endpoint                                 |
|--------|------------------------------------------|
| GET    | localhost:8000/api/transaction/{id}      | 

Keterangan : _id_ diisi dengan id transaksi, dalam format order-x-x-xxxx, contoh `localhost:8000/api/transaction/order-6-3-1655451787`

### Headers
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |

### Sample Response
Berikut adalah contoh response yang akan didapatkan jika detail transaksi berhasil didapatkan.
```
{
    "data": {
        "id": "order-6-3-1655451787",
        "event_id": 3,
        "amount": 1,
        "total_price": "311440",
        "status": "paid",
        "payment_method": "indomaret",
        "payment_code": "926537065370",
        "expired_at": "18-06-2022 07:43",
        "ticket_schedule": [
            "11-06-2022"
        ],
        "event": {
            "id": 3,
            "name": "Iste quos pariatur reprehenderit doloribus voluptas.",
            "description": "Quo repellendus quisquam ut ut voluptatibus impedit. Vitae rem modi quos et sunt eaque. Et quos voluptatem est.",
            "price": "Rp. 311.440",
            "schedule": "\"[\\\"1995-05-23\\\",\\\"1985-12-20\\\"]\"",
            "location": "Reidview",
            "location_description": "Voluptatem doloremque.",
            "rules": "Consequatur voluptates iusto quo rerum molestiae. Dolorum sit libero voluptatem ipsum. Corrupti voluptatem ut dolores fugiat dolorum reiciendis quia.",
            "organization": {
                "id": 1,
                "name": "Kemendikbud RI",
                "slug": "kemendikbud-ri",
                "created_at": "14-06-2022"
            }
        }
    },
    "success": true,
    "total": 6,
    "code": 206
}
```

### Example
Berikut adalah contoh response detail transaksi menggunakan aplikasi postman.

![image](https://user-images.githubusercontent.com/11209553/174255883-c83f1143-c0cf-4e05-b21d-ce4f16fc9f08.png)


# Membatalkan transaksi
| Type   | Endpoint                                 |
|--------|------------------------------------------|
| DELETE | localhost:8000/api/transaction/{id}      | 

### Headers
| Key            | Value                           |
|----------------|---------------------------------|
| Authorization  | Bearer tokendisini              |

### Sample Response
Berikut adalah contoh response yang akan didapatkan jika transaksi berhasil dibatalkan.
```
{
    "data": {
        "id": "order-6-3-1655451787",
        "event_id": 3,
        "amount": 1,
        "total_price": "311440",
        "status": "cancelled",
        "payment_method": "indomaret",
        "payment_code": "926537065370",
        "expired_at": "18-06-2022 07:43",
        "ticket_schedule": [
            "11-06-2022"
        ],
        "event": {
            "id": 3,
            "name": "Iste quos pariatur reprehenderit doloribus voluptas.",
            "description": "Quo repellendus quisquam ut ut voluptatibus impedit. Vitae rem modi quos et sunt eaque. Et quos voluptatem est.",
            "price": "Rp. 311.440",
            "schedule": "\"[\\\"1995-05-23\\\",\\\"1985-12-20\\\"]\"",
            "location": "Reidview",
            "location_description": "Voluptatem doloremque.",
            "rules": "Consequatur voluptates iusto quo rerum molestiae. Dolorum sit libero voluptatem ipsum. Corrupti voluptatem ut dolores fugiat dolorum reiciendis quia.",
            "organization": {
                "id": 1,
                "name": "Kemendikbud RI",
                "slug": "kemendikbud-ri",
                "created_at": "14-06-2022"
            }
        }
    },
    "success": true,
    "total": 6,
    "code": 206
}
```
### Example
Berikut adalah contoh response membatalkan transaksi menggunakan aplikasi postman.

![image](https://user-images.githubusercontent.com/11209553/174255682-17b537b7-1738-4aed-9bcd-8aa496c5d804.png)
