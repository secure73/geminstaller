FROM secure73/gem_lamp

WORKDIR /var/www/html/app

COPY . .

EXPOSE 80