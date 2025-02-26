# Take-Home-Assessment

Bu proje, Laravel kullanılarak geliştirilmiş basit bir e-ticaret RESTful API'sidir. Projede **Orders (Siparişler), Products (Ürünler) ve Customers (Müşteriler)** için CRUD işlemleri mevcuttur.

## İçindekiler
- [Kurulum](#kurulum)
- [API Kullanımı](#api-kullanimi)
- [Kaynaklar](#Kaynaklar)

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
   Çevresel Değişkenler:
   `.env` dosyasında aşağıdaki ayarları güncelleyerek kullanabilirsiniz:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
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

## Örnek API Çıktısı
### GET /api/orders Örnek Yanıtı
```json
[
    {
        "id": 1,
        "customerId": 1,
        "items": [
            {
                "productId": 1,
                "quantity": 7,
                "unitPrice": "200.00",
                "total": "1,400.00"
            },
            {
                "productId": 2,
                "quantity": 7,
                "unitPrice": "300.00",
                "total": "2,100.00"
            },
            {
                "productId": 3,
                "quantity": 2,
                "unitPrice": "30.00",
                "total": "60.00"
            }
        ],
        "total": "3,560.00",
        "discounts": [
            {
                "discountReason": "10_PERCENT_OVER_1000",
                "discountAmount": "356.00",
                "subtotal": "3,204.00"
            },
            {
                "discountReason": "BUY_5_GET_1",
                "discountAmount": "300.00",
                "subtotal": "2,904.00"
            },
            {
                "discountReason": "CHEAPEST_CATEGORY_DISCOUNT",
                "discountAmount": "6.00",
                "subtotal": "3,898.00"
            }
        ],
        "finalTotal": "2,898.00"
    }
]
```

---
## İndirim Kuralları
Projede, siparişler belirli şartlara göre indirim uygulamaktadır:
- **Toplam 1000 TL ve üzerinde alışveriş yapan bir müşteri**, siparişin tamamından **%10 indirim** kazanır.
- **2 ID'li kategoriye ait bir üründen 6 adet satın alındığında**, bir tanesi **ücretsiz** olarak verilir.
- **1 ID'li kategoriden iki veya daha fazla ürün satın alındığında**, en ucuz ürüne **%20 indirim** yapılır.

---


## Kaynaklar

Bu proje geliştirilirken Stack Overflow, ChatGPT ve çeşitli çevrimiçi kaynaklardan faydalanılmıştır.