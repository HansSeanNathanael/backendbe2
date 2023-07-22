Instalasi:

1. Jalankan pada powershell 
```bash
cp .env.example .env
```

2. Pindahkan working directory powershell pada directory aplikasi

3. Jalankan command berikut pada powershell:
```bash
compose install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Berikut adalah daftar route berdasarkan nomor setiap soal:
1. Semua tidak membutuhkan autentikasi token dan semua menggunakan method GET.
    a. ``` /categories/all ```
    b. ``` /categories/all-sorted-freq ```
    c. ``` /products/all-with-assets ```
    d. ``` /products/all-from-expensive ```

Untuk Nomor 2 hingga 6 harus menggunakan autentikasi. Untuk autentikasi adalah dengan mengirim request post
menuju ``` /login ```. Dengan body:
```json
{
    "name" : "admin",
    "password" : "admin"
}
```
Response sistem adalah token yang menjadi token autentikasi Bearer.

2. Request POST menuju ``` /products ```.
    Bentuk request:
    ```json
    {
        "category_id" : number,
        "name" : string,
        "slug" : string,
        "price" : number, 
        "assets" : files[]
    }
     ```

3. Request POST menuju ``` /products/edit ```.
    Bentuk request:
    ```json
    {
        "id" : number,
        "category_id" : number,
        "name" : string,
        "slug" : string,
        "price" : number
    }
     ```

4. Request DELETE menuju ``` /products/{id} ```.
    id adalah id dari product

5. Request POST menuju ``` /assets ```.
    Bentuk request:
    ```json
    {
        "product_id" : number,
        "image" : file
    }
     ```

6. Request DELETE menuju ``` /assets/{id} ```.
