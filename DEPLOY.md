# Guia de Deploy Online

Coloque seu Sistema de Reservas online pra qualquer pessoa acessar de qualquer lugar. Comparação das 3 opções mais populares para projetos Laravel iniciantes.

## Comparação rápida

| Plataforma | Preço | Dificuldade | Banco MySQL grátis | Domínio HTTPS |
|---|---|---|---|---|
| **Railway** | $5/mês de crédito grátis | ⭐ Fácil | ✅ Sim | ✅ `*.up.railway.app` |
| **Render** | Grátis (com limites) | ⭐⭐ Médio | ❌ (só PostgreSQL) | ✅ `*.onrender.com` |
| **InfinityFree** | 100% grátis | ⭐⭐⭐ Difícil | ✅ Sim | ✅ Subdomínio próprio |

**Recomendação:** Use **Railway** se quiser facilidade. **InfinityFree** se for 100% grátis sem cartão.

---

## Opção 1: Railway (Recomendada)

### Por que Railway

- Detecta Laravel automaticamente
- Provisiona MySQL com 1 clique
- Variáveis de ambiente fáceis de configurar
- Deploy a cada `git push` no GitHub

### Passo a passo

**1. Criar conta no Railway**

Acesse https://railway.app/ e clique em **Sign in with GitHub**. Autoriza com a mesma conta que está o repositório (`rocharafa91-ui`).

**2. Criar novo projeto**

- Na dashboard, clica em **+ New Project**
- Escolhe **Deploy from GitHub repo**
- Seleciona `rocharafa91-ui/Sistema-agendamento-quadra`
- Railway começa o deploy automaticamente

**3. Adicionar banco MySQL**

- Dentro do projeto, clica em **+ New** → **Database** → **MySQL**
- Railway provisiona uma instância e gera as variáveis automaticamente

**4. Configurar variáveis de ambiente**

Clica no serviço do Laravel → aba **Variables** e adicione:

```
APP_NAME=SistemaReservas
APP_ENV=production
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}
APP_KEY=base64:GERAR_COM_artisan_key_generate
LOG_CHANNEL=stderr
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

**Gerar APP_KEY localmente:**

```
php artisan key:generate --show
```

Copia a saída (algo como `base64:abc...`) e cola na variável `APP_KEY`.

**5. Rodar migrations no Railway**

- Clica no serviço → aba **Settings** → **Deploy** → **Start Command:**
  ```
  php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
  ```

**6. Pegar a URL pública**

- Aba **Settings** → **Networking** → **Generate Domain**
- Vai gerar algo como `sistema-reservas-production.up.railway.app`

Pronto! Acesse essa URL e seu sistema está online.

---

## Opção 2: Render (Grátis com limites)

**Limitação importante:** o plano grátis do Render hiberna depois de 15min sem acesso. Quando alguém acessa, demora ~30s pra acordar.

**1.** Crie conta em https://render.com/ via GitHub

**2.** **+ New** → **Web Service** → conecte seu repo

**3.** Configure:
- **Name:** `sistema-reservas`
- **Environment:** PHP
- **Build Command:** `composer install --no-dev && php artisan config:cache`
- **Start Command:** `php artisan serve --host 0.0.0.0 --port $PORT`

**4.** Como o plano grátis não tem MySQL, mude pra SQLite no `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=/var/data/database.sqlite
```

**5.** Adicione um disco persistente: **Disks** → **+ Add Disk** → mount em `/var/data`

**6.** Após o deploy, abra o console (**Shell**) e rode:
```
touch /var/data/database.sqlite
php artisan migrate --force
```

---

## Opção 3: InfinityFree (100% grátis sem cartão)

**Atenção:** Hospedagem compartilhada gratuita tem restrições e instabilidade. Bom pra demonstrar, não pra produção.

**1.** Cadastra em https://infinityfree.net/

**2.** Cria conta de hospedagem com subdomínio gratuito (ex: `sistemareservas.epizy.com`)

**3.** Cria um banco MySQL no painel **MySQL Databases**

**4.** Faz upload dos arquivos pelo **File Manager** (ou FTP) — pasta `htdocs/`

   ⚠️ **Importante:** o Laravel precisa do `public/` como pasta raiz. Mova o conteúdo de `public/` pra `htdocs/` e ajuste o `index.php`:
   ```php
   require __DIR__.'/../sistema-reservas/vendor/autoload.php';
   $app = require_once __DIR__.'/../sistema-reservas/bootstrap/app.php';
   ```

**5.** Configura o `.env` com os dados do MySQL do InfinityFree.

**6.** Rode as migrations via SSH (premium) ou exporte o `.sql` localmente e importe pelo phpMyAdmin do InfinityFree.

---

## Preparando o projeto pra produção

Antes de fazer deploy em qualquer plataforma, ajuste estes pontos:

### 1. Otimizar configs

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Compilar assets (se usar Vite)

```bash
npm install
npm run build
```

### 3. Configurar `APP_DEBUG=false` no `.env`

Em produção, **NUNCA** deixe `APP_DEBUG=true` — expõe informações sensíveis.

### 4. HTTPS no Laravel

Adicione no `app/Providers/AppServiceProvider.php`, método `boot()`:

```php
if ($this->app->environment('production')) {
    \URL::forceScheme('https');
}
```

---

## Próximos passos depois do deploy

- Configurar um domínio customizado (ex: `sistemareservas.com.br`)
- Adicionar HTTPS com Let's Encrypt
- Configurar backups automáticos do banco
- Monitorar com ferramentas como Sentry ou Bugsnag
- Configurar fila de jobs para envio de e-mails

---

## Dica final

Pra começar **agora mesmo** sem cartão de crédito e com facilidade máxima, use o **Railway** com o trial grátis ($5 de crédito que dura uns 2-3 meses pra projetos pequenos). Quando acabar, você pode migrar pra InfinityFree ou pagar $5/mês no próprio Railway.

Bom deploy! 🚀
