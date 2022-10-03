Каталог товарів
================================
Тестове завдання

Вимоги
----------
1. [docker](https://www.docker.com/)
2. [git](https://git-scm.com/)

Встановлення
---------
Завантажте код
```
git clone https://github.com/critcat/solomono.git
```
Перейдіть в теку solomono
```
cd solomono
```
Запустіть Docker-контейнер
```
docker-compose up -d
```
Встановіть залежності
```
docker exec solomono-php-fpm composer i
```
Запустіть міграції для створення БД та таблиць
```
docker exec solomono-php-fpm php bin/console doctrine:migrations:migrate -n
```
Застосуйте фікстури для генерації тестових синтетичних даних
```
docker exec solomono-php-fpm php bin/console doctrine:fixtures:load -n
```

Використання
---
1. Каталог товарів: [http://localhost:8081](http://localhost:8081)
2. Побудова дерева категорій: [http://localhost:8081/categories/array](http://localhost:8081/categories/array)
