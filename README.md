# Take-Home-Assessment

Bu proje, Laravel kullanılarak geliştirilmiş basit bir e-ticaret RESTful API'sidir. Projede **Orders (Siparişler), Products (Ürünler) ve Customers (Müşteriler)** için CRUD işlemleri mevcuttur.

## İçindekiler
- [Kurulum](#kurulum)
- [API Kullanımı](#api-kullanimi)
- [Çevresel Değişkenler](#çevresel-degiskenler)
- [Test Çalıştırma](#test-calistirma)
- [Katkıda Bulunma](#katkida-bulunma)
- [Lisans](#lisans)

---

## Kurulum

### Gereksinimler
- PHP 8.1+
- Composer
- MySQL 5.7+
- Laravel 9.*

### Adımlar
1. Depoyu klonlayın:
   ```sh
   git clone https://github.com/SyntaxTR/Take-Home-Assessment.git
   cd Take-Home-Assessment
   ```
2. Bağımlıları yükleyin:
   ```sh
   composer install
   ```
3. Ortam dosyasını oluşturun:
   ```sh
   cp .env.example .env
   ```
4. Veritabanını ve migrasyonları çalıştırın:
   ```sh
   php artisan migrate
   ```
5. Laravel geliştirme sunucusunu başlatın:
   ```sh
   php artisan serve
   ```

Artık API'yi `http://127.0.0.1:8000/api` üzerinden kullanabilirsiniz.

---

## API Kullanımı

### 1. Customers (Müşteriler)
- **Tüm müşterileri listele:** `GET /api/customers`
- **Belirli bir müşteriyi getir:** `GET /api/customers/{id}`
- **Yeni bir müşteri ekle:** `POST /api/customers`
- **Müşteriyi güncelle:** `PUT /api/customers/{id}`
- **Müşteriyi sil:** `DELETE /api/customers/{id}`

### 2. Products (Ürünler)
- **Tüm ürünleri listele:** `GET /api/products`
- **Belirli bir ürünü getir:** `GET /api/products/{id}`
- **Yeni bir ürün ekle:** `POST /api/products`
- **Ürünü güncelle:** `PUT /api/products/{id}`
- **Ürünü sil:** `DELETE /api/products/{id}`

### 3. Orders (Siparişler)
- **Tüm siparişleri listele:** `GET /api/orders`
- **Belirli bir siparişi getir:** `GET /api/orders/{id}`
- **Yeni bir sipariş oluştur:** `POST /api/orders`
- **Siparişi güncelle:** `PUT /api/orders/{id}`
- **Siparişi sil:** `DELETE /api/orders/{id}`

Tüm endpointler JSON formatında veri döndürmektedir ve ilgili HTTP metoduna uygun olarak çalışmaktadır.

---

## Çevresel Değişkenler
`.env` dosyasında aşağıdaki ayarları güncelleyerek kullanabilirsiniz:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

## Test Çalıştırma
Testleri çalıştırmak için aşağıdaki komutu kullanabilirsiniz:
```sh
php artisan serve
```

---

