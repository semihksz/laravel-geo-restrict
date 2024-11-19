# Laravel Geo-Restriction Middleware

Bu proje, **Laravel** framework'ü kullanarak belirli bir coğrafi bölgeye veya ülkeye göre içerik erişimini sınırlamak amacıyla bir middleware uygulamasını içermektedir. Örneğin, kullanıcıların IP adreslerine dayalı olarak konum bilgilerini tespit ediyor ve yalnızca belirlenen ülkelerden gelen kullanıcılara erişim izni veriyor. Eğer kullanıcı izin verilen ülkelerde değilse, özel bir hata sayfasına yönlendirilir.

## 📖 Proje Özeti

Bu proje, aşağıdaki özellikleri içerir:

-   Kullanıcının IP adresine göre ülkesini tespit etme.
-   Sadece izin verilen ülkelerden gelen kullanıcıların erişmesine izin verme.
-   Diğer durumlarda kullanıcıları özel bir hata sayfasına yönlendirme.
-   Laravel middleware yapısını kullanarak IP tabanlı konum denetimi sağlama.
-   Hata sayfası için basit bir tasarım.

---

## 📚 Projede Yapılanlar

### 1. **IP Tabanlı Konum Bilgisi Elde Etme**

-   Projede IP tabanlı konum tespiti için `stevebauman/location` paketi kullanıldı.
-   Paketi yüklemek için:
    ```bash
    composer require stevebauman/location
    ```

### 2. **Middleware Oluşturma**

-   Belirli bir IP'nin ülkesini kontrol eden ve uygun olmayan durumlarda kullanıcıyı hata sayfasına yönlendiren bir middleware oluşturduk:

```bash
    php artisan make:middleware GeoRestriction
```

Middleware içinde şu işlemler yapılmaktadır:

-   Kullanıcının IP adresi alınır.
-   IP'ye göre kullanıcı konumu tespit edilir.
-   Kullanıcının bulunduğu ülke, izin verilen ülkeler listesiyle karşılaştırılır.
-   Erişim izni yoksa özel hata sayfasına yönlendirilir.

### 3. **Middleware Tanımlama**

-   Laravel 11 ile artık kernel.php dosyası olmadığı için oluşturduğumuz middlewareyi bootstrap içerisindeki app.php içerisinde tanımlıyoruz.

```bash
    └── bootstrap
        └── app.php
```

### 4. **Rota Yapılandırması**

-   Middleware, belirli rotalarda uygulanmak üzere web.php dosyasında tanımlandı. Ayrıca, özel hata sayfası için bir rota oluşturuldu:

```bash
    Route::middleware('GeoRestriction')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    });
    Route::get('/geo-restricted', function () {
        return view('403');
    })->name('geo-restricted');

    Route::get('/geo-location-error', function () {
        return view('404');
    })->name('geo-location-error');
```

### 5. **Hata Sayfası**

-   Hata durumunda kullanıcıların yönlendirileceği bir hata sayfası tasarlandı.

### 6. **Konum Testi**

-   Türkiye için örnek bir IP (88.255.216.0) kullanılarak middleware içinde testler gerçekleştirildi.

## 📂 Dosya Yapısı

```bash
    ├── app
    │   └── Http
    │       └── Middleware
    │           └── GeoRestriction.php
    ├── resources
    │   └── views
    │       ├── welcome.blade.php
    │       └── 403.blade.php
    │       └── 404.blade.php
    └── routes
        └── web.php
```
