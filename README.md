# Webscrap Laravel
### _Desafio </> Lexart_

Projeto criado para fazer webscrapping no site do Mercado Livre e Buscapé, filtrado por categorias e busca por palavra-chave.

## Features

- WebScrap do Mercado Livre e Buscapé
- Dados salvos em banco de dados
- Exibição dos dados obtidos

## Tech

Tecnologias utilizadas:

- Laravel
- React
- Mysql
- Goute
- Inertia
- Tailwindcss
- DaisyUi

## Installation

Execute o sail para subir o docker.

```sh
cd webscrap-php
./vendor/bin/sail up
```

Execute a migration para popular o BD...

```sh
php artisan migrate
```

Inicie o Frontend
```sh
npm run dev
```
