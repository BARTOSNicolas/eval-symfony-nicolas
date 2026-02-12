# Eval SYMFONY du 12/02/26
## Voici mon évaluation

### Comment je fais pour tester !

D'abord télécharger le projet : 
```bash
git clone https://github.com/BARTOSNicolas/eval-symfony-nicolas.git
```

Ensuite placer vous dans le projet
```bash
cd eval-symfony-nicolas
```

Lancer docker 
```bash
docker compose up -d --build
```

Dans evalsymfony :
```bash
cd evalsymfony
```

Créer un fichier .env :
```
APP_ENV=dev
APP_SECRET=
APP_SHARE_DIR=var/share
DEFAULT_URI=http://localhost
DATABASE_URL=
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
MAILER_DSN=null://null
```

Puis créer un fichier .env.dev :
```
APP_SECRET=045beda3d50a10a4a5c97660864c9c78
DATABASE_URL="mysql://root:root@mysql:3306/task?serverVersion=8.0&charset=utf8mb4"
```

On revient dans le dossier parent : 
```bash
cd .. 
```

Ensuite on se branche en bash dans le conteneur php :
```bash
docker compose exec php bash
```

On entre dans le dossier evalsymfony (/var/www/html/evalsymfony#)
```bash
cd evalsymfony
```

On créer la base : 
```bash
php bin/console doctrine:database:create
ou 
symfony console doctrine:database:create
```

On lance la migration (fichier déjà dans migration) :
```bash
php bin/console doctrine:migrations:migrate
ou
symfony console doctrine:migrations:migrate
```

Ensuite on lance le serveur en mode compatible container Docker: 
```bash
symfony serve --no-tls --allow-http --port=8000 --listen-ip=0.0.0.0
```




