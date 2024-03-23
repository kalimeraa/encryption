# Task Assigner

## Stack

* **Laravel**
* **Nginx**
* **Redis**
* **MySQL**
* **Docker**
* **Supervisor**

### Kurulum Gereksinimleri
- Docker

### Kurulum
```
  chmod +x install.sh && ./install.sh
```

### Testleri Çalıştırma
```
  docker-compose --env-file .env.dev exec server bash #containerın içine girin
  php artisan test --env=testing #testleri çalıştırın
```

### Nasıl çalışır ?

user: admin@heyatlas.ai
password: password

http://localhost adresini ziyaret edin ve "Log in" butonuna basın.Yukarıda bulunan bilgilerle Giriş yapın ardından Customer Create ekranında bir customer oluşturun oluşturulan customerları görmek için "Customers" butonuna basabilirsiniz.Customers bölümünde customerların detayına gitmek için "detay" butonuna tıklayın ve encrypte edilmiş customer detaylarını (kimlik bilgileri,resim) orada görebilirsiniz.

