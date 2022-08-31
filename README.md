# NanoFramePHP
NanoFrame es un entorno de trabajo PHP basado en el patrón MVC, ya tiene programado un sistema de usuarios, productos y categorías para que puedas replicar o añadir nuevas funcionalidades

PASARELA DE PAGO

CREATE UN SUBDOMINIO

REPLICAR APP / BALANCER


APACHE / NODE JS EXPRESS
let's encrypt para generar/instalar SSL

investidar DNS SERVER
=====================
 Enginex configuration
 ======== en apache es mas complejo
PROXY INVERSO
server {
    listen 80;
    server_name aap2.miweb.com;

    location / {
        proxy_pass http://localhost:6008/;
    }
}
server {
    listen 80;
    server_name app.miweb.com;

    location / {
        proxy_pass http://localhost:5000/;
    }
}
enginex balancer
REVISAR BALANCEADORES DE CARGA
HAPROXY

Create a certicate:
Empresa
país
etc.
cont letscrip es valido a nivel dominio

> webHook
