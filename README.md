cd docker
docker compose build --no-cache (ビルドする)
docker compose up -d (コンテナをたてる)
docker compose exec app bash (app コンテナに入る)
composer create-project --prefer-dist laravel/laravel . "6.*" (src 配下に laraavel6 をインストール)
ブラウザでhttp://localhostにアクセスし、「laravel」が表示されることを確認

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=password
