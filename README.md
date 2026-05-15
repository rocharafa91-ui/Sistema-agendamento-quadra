# Sistema de Reservas — Laravel 12

Sistema web de gestão de reservas para clubes/estabelecimentos esportivos, com cadastro de usuários, quadras, espaços de lazer, equipamentos para aluguel e produtos de bar. Desenvolvido em **Laravel 12** seguindo o padrão de arquitetura **MVC (Model-View-Controller)**.

## Sobre

Projeto refatorado a partir de um conjunto de classes PHP procedurais (`legacy/classes.php`) para um sistema web completo com banco de dados, telas e CRUD funcional. A lógica original foi preservada e organizada nas três camadas do MVC.

## Funcionalidades

- **Cadastro de usuários** (nome, e-mail, telefone com validação)
- **Cadastro de quadras** esportivas (Futebol, Tênis, Basquete, Vôlei, Poliesportiva)
- **Cadastro de espaços de lazer** (churrasqueiras, salões etc.) com capacidade
- **Cadastro de equipamentos** para aluguel com controle de disponibilidade
- **Cadastro de bares e produtos** com controle de estoque e preço
- **Reservas** vinculadas a usuário + quadra ou espaço de lazer
- **Validação de conflito** — impede 2 reservas no mesmo horário/local
- **Confirmar / cancelar** reservas
- **Alugar / devolver** equipamentos
- **Comprar produto** com decremento automático de estoque
- **Dashboard** com estatísticas e gráfico de reservas por status

## Stack Tecnológica

| Camada | Tecnologia |
|---|---|
| Framework | Laravel 12.58 |
| Linguagem | PHP 8.2+ |
| Banco | SQLite (desenvolvimento) / MySQL (produção) |
| ORM | Eloquent |
| Frontend | Blade + Bootstrap 5.3 + Chart.js |
| Servidor | Apache (XAMPP) |
| Versionamento | Git + GitHub |

## Arquitetura MVC

```
sistema-reservas/
├── app/
│   ├── Models/                    # MODEL — Acesso aos dados (Eloquent)
│   │   ├── Usuario.php
│   │   ├── Bar.php
│   │   ├── Produto.php
│   │   ├── Equipamento.php
│   │   ├── Quadra.php
│   │   ├── EspacoLazer.php
│   │   └── Reserva.php
│   └── Http/Controllers/          # CONTROLLER — Lógica da aplicação
│       ├── DashboardController.php
│       ├── UsuarioController.php
│       ├── BarController.php
│       ├── ProdutoController.php
│       ├── EquipamentoController.php
│       ├── QuadraController.php
│       ├── EspacoLazerController.php
│       └── ReservaController.php
├── database/migrations/           # Estrutura das tabelas
├── resources/views/               # VIEW — Telas Blade
│   ├── layout.blade.php
│   ├── home.blade.php             # Dashboard
│   └── (usuarios|bars|produtos|equipamentos|quadras|espacos_lazer|reservas)/
├── routes/web.php                 # Rotas da aplicação
└── legacy/classes.php             # Código PHP original (referência)
```

## Relacionamentos (Eloquent)

| Origem | Relação | Destino |
|---|---|---|
| Usuario | hasMany | Reserva |
| Reserva | belongsTo | Usuario |
| Reserva | belongsTo (opcional) | Quadra |
| Reserva | belongsTo (opcional) | EspacoLazer |
| Bar | hasMany | Produto |
| Produto | belongsTo | Bar |

## Instalação

### Pré-requisitos

- PHP 8.2+
- Composer 2.x
- XAMPP (Apache + MySQL) ou similar
- Git

### Passo a passo

```bash
# 1. Clonar o repositório
git clone https://github.com/rocharafa91-ui/Sistema-agendamento-quadra.git
cd Sistema-agendamento-quadra

# 2. Instalar dependências
composer install

# 3. Configurar ambiente
copy .env.example .env
php artisan key:generate

# 4. Rodar migrations
php artisan migrate

# 5. Iniciar servidor
php artisan serve
```

Acesse: **http://127.0.0.1:8000**

## Screenshots

> Adicione screenshots aqui depois de rodar o projeto.
> Sugestões de telas para capturar:
> - Dashboard com estatísticas
> - Listagem de reservas
> - Formulário de nova reserva
> - Tela de detalhes de uma reserva confirmada

Para adicionar prints:
1. Tire um print com **Win + Shift + S**
2. Salve numa pasta `docs/screenshots/`
3. Referencie no README: `![Dashboard](docs/screenshots/dashboard.png)`

## Endpoints principais

| Método | URL | Ação |
|---|---|---|
| GET | `/` | Dashboard com estatísticas e gráfico |
| GET | `/reservas` | Listar reservas |
| GET | `/reservas/create` | Formulário de nova reserva |
| POST | `/reservas` | Salvar nova reserva (valida conflito) |
| POST | `/reservas/{id}/confirmar` | Confirmar reserva |
| POST | `/reservas/{id}/cancelar` | Cancelar reserva |
| POST | `/equipamentos/{id}/alugar` | Alugar equipamento |
| POST | `/produtos/{id}/comprar` | Comprar produto (-1 estoque) |

## Origem do código

Construído a partir de um arquivo PHP procedural (`legacy/classes.php`) com 7 classes do domínio, refatorado para Laravel:

- **Atributos privados + getters/setters** → colunas + `$fillable` do Eloquent
- **Validações em setters** → `$request->validate()` nos Controllers
- **`salvarJson()` / `carregarJson()`** → persistência em banco via Eloquent
- **Métodos de domínio** (`confirmar`, `cancelar`, `alugar`, `comprar`) → métodos do Model + endpoints nos Controllers

## Documentação adicional

- [INSTALACAO.md](INSTALACAO.md) — Setup detalhado no XAMPP
- [DEPLOY.md](DEPLOY.md) — Guia de deploy online (Railway, etc.)

## Autor

**Rafael Rocha** — [rarocha@qmctelecom.com](mailto:rarocha@qmctelecom.com)
