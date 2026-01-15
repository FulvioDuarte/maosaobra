#!/bin/sh
# Substitui a porta do Railway no template Nginx
envsubst '$PORT' < /etc/nginx/sites-available/default.template > /etc/nginx/sites-available/default

# Inicia Supervisor (roda PHP-FPM + Nginx)
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
