# 🗂️ Licitação

Aplicação Laravel + Vue.js para captura de licitações no [ComprasNet](http://comprasnet.gov.br/ConsultaLicitacoes/ConsLicitacaoDia.asp), utilizando Docker e MySQL.

---

## 🚀 Tecnologias

- Laravel 10+
- Vue.js 3 (com Vite)
- Docker + Docker Compose
- Nginx
- MySQL 8.0
- PHP 8.2

---

## ✅ Requisitos

- [Docker](https://www.docker.com/products/docker-desktop)
- [Git](https://git-scm.com/)
- (Opcional) [Node.js + NPM](https://nodejs.org/) para rodar o Vite localmente

---

## 🛠️ Instalação

1. **Clone o repositório**

```bash
git clone TODONOMEREPO
```

2. **Copie o .env**

3. **Suba os containers**

```bash
docker-compose up -d --build
```

3. **Executar setup**

```bash
./setup.sh

```

4. **Rodar frontend (Vue + Vite)**

```bash
docker exec -it laravel-vite sh
npm run dev
exit

```

---

## 🌐 Acessar a aplicação

- Laravel: http://localhost:8000
- Vite: http://localhost:5173

---

## 🔍 Estrutura dos containers

| Serviço | Porta  | Descrição | 
| ---- | ---- | ----  | 
| nginx  | 8000  | Servidor Web  |
| mysql  | 3306  | Banco de dados  |
| vite | 5173  | Dev Server Vue.js  |

---


## 🔐 Variáveis de ambiente

```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel

```

---

## 🧪 Comandos úteis

```bash
docker-compose up -d        # Sobe os containers
docker-compose down         # Para os containers
docker exec -it laravel-app bash  # Acessa o container da aplicação
```

> Rodar os comandos abaixo dentro do container `docker exec -it laravel-app bash`

```bash
php artisan migrate         # Roda as migrations
npm run dev                 # Roda o frontend com Vite
php artisan app:consultar-licitacao-scraper # testa scraper ConsultaLicitacoes
php artisan app:consultar-licitacao-item-scraper # testa scraper ConsultaLicitacaoItem
./vendor/bin/php-cs-fixer fix #fixer arquivos
```



--- 

## ✨ Contribuidores

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tbody>
    <tr>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/karenyov"><img src="https://avatars.githubusercontent.com/u/11029857?v=4?s=100" width="100px;" alt="Karen Vicente"/><br /><sub><b>Karen Vicente</b></sub></a><br /><a href="https://github.com/karenyov/licitacao/commits?author=karenyov" title="Code">💻</a> <a href="#infra-karenyov" title="Infrastructure (Hosting, Build-Tools, etc)">🚇</a></td>
    </tr>
  </tbody>
</table>

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->

Este projeto segue a especificação [all-contributors](https://allcontributors.org/), contribuições de todos os tipos são bem-vindas!


--- 

📄 Licença

Este projeto está licenciado sob os termos da [MIT license](https://opensource.org/licenses/MIT).
