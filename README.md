[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hirootkit/inely/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hirootkit/inely/?branch=master) [![Codacy Badge](https://img.shields.io/badge/codacy-B-brightgreen.svg)](https://www.codacy.com/app/roof1rst/list) [![Build Status](https://scrutinizer-ci.com/g/Exoticness/madeasy/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/madeasy/build-status/master)

Рабочий сервер
----
Frontend:
http://domain.net

Backend:
http://backend.domain.net

Установка и развёртывание
------------

Минимальные требования подразумевают, что веб-сервер поддерживает PHP 5.4

### Перед началом
При отсутствии [Composer](http://getcomposer.org/), необходимо установить его, следуя инструкциям на [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

После завершения добавьте плагин:
```bash
composer global require "fxp/composer-asset-plugin"
```

Далее клонируйте этот репозиторий и обновите зависимости:
```
cd /path/to/inely
composer update
```

### Инициализация

Инициализируйте приложение, запустив команду из директории с проектом
```
php console/yii app/setup
```

Настройте параметры в `.env` файле
	

	- Укажите ваше текущее окружение
	
	YII_DEBUG   = true
	YII_ENV     = dev
	
	- Конфигурацию базы данных
	
	DB_DSN           = mysql:host=127.0.0.1;port=3306;dbname=inely
	DB_USERNAME      = user
	DB_PASSWORD      = password
	
	- URL-адреса для отдельных доменов

	FRONTEND_URL    = http://inely.local
	BACKEND_URL     = http://backend.inely.local


Запустите миграции, окружение и RBAC
```
php console/yii app/setup
```

И в завершение сконфигурируйте виртуальные хосты:
- inely.local => /path/to/inely/frontend/web
- backend.inely.local => /path/to/inely/backend/web

### Инициализация c Vagrant
Если вам дорого потраченное время, можете использовать Vagrant вместо ручной конфигурации приложения.

1. Установите [Vagrant](https://www.vagrantup.com/).
2. Откройте терминал и перейдите в директорию madeasy.
3. Поднимите виртуальную машину ```vagrant up``` и сделайте перерыв. :coffee:
4. Инициализируйте окружение ```php console/yii app/setup```.

На этом всё. После этих действий приложение будет доступно по адресу madeasy.local на базе сервера Apache 2.4. Управление БД происходит через /adminer или MySQLWorkbench.

p.s. Если возникла необходимость проброса портов к MySQL через Vagrant и вы не смогли подключиться к базе, то зайдите через ```vagrant ssh``` выполните команду ```sudo nano /etc/mysql/my.cnf``` и закомментируйте строки:
```bash
bind-address: 127.0.0.1
skip-external-locking
```
