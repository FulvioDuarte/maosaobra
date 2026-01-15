#!/bin/sh
# Substitui a variável PORT no template do Nginx
envsubst '$PORT' < /etc/nginx/sites-available/default.template > /etc/nginx/sites-available/default
# Inicia Supervisor que roda PHP-FPM + Nginx
supervisord -n
