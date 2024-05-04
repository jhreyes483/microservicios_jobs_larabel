#!/bin/bash
# Script para ejecutar jobs de Laravel

# Navega al directorio donde está el proyecto Laravel
cd /var/www/html

# Ejecuta el comando de Laravel para correr los jobs programados
php artisan schedule:work
