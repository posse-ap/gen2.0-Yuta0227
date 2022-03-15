# web/Dockerfile
# FROM php:7.4-apache
FROM nginx:latest

# wgetをインストールするよう修正
RUN apt-get update && apt-get install -y wget

RUN apt-get install -y vim
RUN docker-php-ext-install pdo_mysql
# ホスト環境で作ったmailhog.iniをコンテナにコピー
COPY mailhog.ini /usr/local/etc/php/conf.d/mailhog.ini

# mhsendmailコマンドのインストール。CURLでダウンロードしてインストールします。
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail