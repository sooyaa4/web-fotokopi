# web-fotokopi
# Informasi

```bash
Menggunakan laravel versi 8 dengan php versi 8.0. Buat lah database untuk menyimpan 
data dan tabel. Untuk pembuatan database saya menggunakan migration dan 
untuk data user menggunakan seeder.
```


## Installation


```bash
# pertama
composer update

# kedua, lakukan untuk mengcopas env
cp .env.example .env

# ketiga, lakukan untuk meng generate projek
php artisan key:generate

# keempat, lakukan migration 
php artisan migrate --seed

# terakhir, jalankan projek
php artisan serve
```

## Konsep 

```bash
Projek ini adalah bertemakan tentang web pencatatan untuk transaksi maupun barang masuk. Terdapat master 
Jenis produk, produk dan supplier. Alur penggunaan, user mengisi data jenis produk terlebih dahulu, 
lalu user bisa mengisi data produk nya. Untuk satuan produk ini bisa berupa rim dan lembar.
perhitungan nya jika 1 rim maka ada 500 lembar. Jika user ingin melakukan pencatatan barang masuk, maka user
harus mengisi data supplier terlebih dahulu. Untuk transaksi, user bis memilih transaksi tersebut berjumlah rim/lembar.
setelah transaksi tersebut, stok barang akan langsung otomatis berubah.
```
