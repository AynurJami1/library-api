# Library CRUD REST API

Sadə kitabxana idarəetməsi üçün qatlı arxitektura (layered architecture) 
əsasında qurulmuş REST API. Laravel/PHP ilə hazırlanıb.

## Texnologiyalar
- PHP 8.3
- Laravel 11
- MySQL
- Swagger/OpenAPI (l5-swagger)

## Arxitektura
Controller → Service → Repository qatlı strukturu:
- **Controller** — sorğuları qəbul edir, validasiya aparır, cavab qaytarır
- **Service** — biznes məntiqini idarə edir
- **Repository** — verilənlər bazası əməliyyatlarını yerinə yetirir

## Entity-lər
- **Author** (id, name, email)
- **Book** (id, title, isbn, published_year, author_id) — Author ilə one-to-many əlaqə

## Quraşdırma addımları

1. Repository-ni klonla:

git clone https://github.com/AynurJami1/library-api.git
cd library-api


2. Asılılıqları quraşdır:

composer install


3. `.env` faylını yarat və doldur:

cp .env.example .env
php artisan key:generate

   `.env` faylında DB məlumatlarını doldur:

DB_CONNECTION=mysql
DB_DATABASE=library
DB_USERNAME=root
DB_PASSWORD=


4. Migration-ları işə sal:

php artisan migrate


5. Serveri başlat:

php artisan serve


## API Endpoint-ləri

| Method | Endpoint | Təsvir |
|--------|----------|--------|
| GET | /api/books | Bütün kitabları göstər (sort, order, pagination) |
| GET | /api/books/{id} | Tək kitabı göstər |
| POST | /api/books | Yeni kitab yarat |
| PUT | /api/books/{id} | Kitabı yenilə |
| DELETE | /api/books/{id} | Kitabı sil |

## API Sənədləşdirməsi (Swagger)

Server işə salındıqdan sonra:

http://127.0.0.1:8000/api/documentation


## Testlər

php artisan test --filter=BookServiceTest