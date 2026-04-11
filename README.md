Título do Projeto: Sistema de Agendamento de Quadras e Espaços de Lazer
Resumo do Projeto
O presente projeto tem como objetivo desenvolver um sistema de agendamento para quadras esportivas e espaços de lazer. A plataforma permitirá que usuários realizem reservas de quadra de futebol society e quadra de vôlei de forma simples e organizada. Além do agendamento das quadras, o sistema oferecerá a opção de locação de equipamentos esportivos, como bola de futebol e chuteira para a quadra de futebol, e bola de vôlei e viseira para a quadra de vôlei.

O sistema também contará com a disponibilidade de três espaços com churrasqueira para locação, permitindo que os usuários reservem áreas destinadas a confraternizações e eventos. Além disso, haverá integração com um bar local dentro do espaço, possibilitando a compra de produtos como cerveja, água, refrigerantes e sucos.

O objetivo principal do projeto é facilitar o gerenciamento das reservas, melhorar a organização do espaço esportivo e proporcionar maior comodidade aos usuários, centralizando em um único sistema todas as opções de agendamento, locação de equipamentos e compra de produtos.



uml

Usuario
- id
- nome
- email
- telefone
- fazerReserva()
- alugarEquipamento()
- comprarProduto()

        |
        | faz
        v

Reserva
- id
- data
- horario
- status
- confirmar()
- cancelar()

Reserva --> Quadra
Reserva --> EspacoLazer

Quadra
- id
- nome
- tipo
- disponivel

EspacoLazer
- id
- nome
- capacidade
- disponivel

Equipamento
- id
- nome
- tipo
- disponivel

Bar
- id
- nome

Bar --> Produto

Produto
- id
- nome
- preco
- estoque

<img width="1024" height="1536" alt="Diagrama de sistema de reservas" src="https://github.com/user-attachments/assets/fe94f464-cd70-4497-97c1-211b370af32f" />


<?php

// ============================================================
//  SISTEMA DE RESERVAS — POO com PHP 
//  Conceitos aplicados: encapsulamento, getters/setters com
//  validação, construtor, exibir(), persistência JSON.
// ============================================================


// ------------------------------------------------------------
// CLASSE: Produto
// Representa um produto vendido no bar.
// ------------------------------------------------------------
class Produto
{
    // Atributos PRIVADOS — ninguém de fora acessa diretamente
    private int    $id;
    private string $nome;
    private float  $preco;
    private int    $estoque;

    /**
     * Construtor: inicializa via setters para garantir validação
     */
    public function __construct(int $id, string $nome, float $preco, int $estoque)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setPreco($preco);
        $this->setEstoque($estoque);
    }

    // ---- GETTERS ----
    public function getId(): int      { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getPreco(): float { return $this->preco; }
    public function getEstoque(): int { return $this->estoque; }

    // ---- SETTERS COM VALIDAÇÃO ----
    public function setNome(string $nome): void
    {
        if (trim($nome) === '') {
            throw new InvalidArgumentException("Nome do produto não pode ser vazio!");
        }
        $this->nome = $nome;
    }

    public function setPreco(float $preco): void
    {
        if ($preco < 0) {
            throw new InvalidArgumentException("Preço não pode ser negativo!");
        }
        $this->preco = $preco;
    }

    public function setEstoque(int $estoque): void
    {
        if ($estoque < 0) {
            throw new InvalidArgumentException("Estoque não pode ser negativo!");
        }
        $this->estoque = $estoque;
    }

    /**
     * Exibe os dados do produto no terminal
     */
    public function exibir(): void
    {
        echo "Produto   : {$this->nome}\n";
        echo "Preço     : R$ " . number_format($this->preco, 2, ',', '.') . "\n";
        echo "Estoque   : {$this->estoque} unidade(s)\n";
    }

    /**
     * Salva o produto em arquivo JSON
     */
    public function salvarJson(string $arquivo): void
    {
        $json = json_encode([
            'id'      => $this->id,
            'nome'    => $this->nome,
            'preco'   => $this->preco,
            'estoque' => $this->estoque,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        file_put_contents($arquivo, $json);
        echo "Produto salvo em {$arquivo}\n";
    }

    /**
     * Carrega um Produto a partir de arquivo JSON
     */
    public static function carregarJson(string $arquivo): self
    {
        $dados = json_decode(file_get_contents($arquivo), true);
        return new self($dados['id'], $dados['nome'], $dados['preco'], $dados['estoque']);
    }
}


// ------------------------------------------------------------
// CLASSE: Bar
// Representa o bar do estabelecimento; possui uma lista de
// produtos (associação Bar → Produto).
// ------------------------------------------------------------
class Bar
{
    private int    $id;
    private string $nome;

    /** @var Produto[] */
    private array $produtos = [];

    public function __construct(int $id, string $nome)
    {
        $this->id   = $id;
        $this->setNome($nome);
    }

    // ---- GETTERS ----
    public function getId(): int      { return $this->id; }
    public function getNome(): string { return $this->nome; }

    // ---- SETTER COM VALIDAÇÃO ----
    public function setNome(string $nome): void
    {
        if (trim($nome) === '') {
            throw new InvalidArgumentException("Nome do bar não pode ser vazio!");
        }
        $this->nome = $nome;
    }

    /**
     * Adiciona um produto ao cardápio do bar
     */
    public function adicionarProduto(Produto $produto): void
    {
        $this->produtos[] = $produto;
        echo "Produto '{$produto->getNome()}' adicionado ao bar '{$this->nome}'.\n";
    }

    /**
     * Retorna todos os produtos do bar
     * @return Produto[]
     */
    public function getProdutos(): array
    {
        return $this->produtos;
    }

    /**
     * Busca produto pelo nome (case-insensitive)
     */
    public function buscarProduto(string $nome): ?Produto
    {
        foreach ($this->produtos as $produto) {
            if (strtolower($produto->getNome()) === strtolower($nome)) {
                return $produto;
            }
        }
        return null;
    }

    /**
     * Exibe o cardápio completo do bar
     */
    public function exibir(): void
    {
        echo "=== Bar: {$this->nome} ===\n";
        if (empty($this->produtos)) {
            echo "  Nenhum produto cadastrado.\n";
            return;
        }
        foreach ($this->produtos as $produto) {
            echo "  - {$produto->getNome()} — R$ "
               . number_format($produto->getPreco(), 2, ',', '.') . "\n";
        }
    }
}


// ------------------------------------------------------------
// CLASSE: Equipamento
// Representa um equipamento disponível para aluguel.
// ------------------------------------------------------------
class Equipamento
{
    private int    $id;
    private string $nome;
    private string $tipo;
    private bool   $disponivel;

    public function __construct(int $id, string $nome, string $tipo, bool $disponivel = true)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setTipo($tipo);
        $this->disponivel = $disponivel;
    }

    // ---- GETTERS ----
    public function getId(): int          { return $this->id; }
    public function getNome(): string     { return $this->nome; }
    public function getTipo(): string     { return $this->tipo; }
    public function isDisponivel(): bool  { return $this->disponivel; }

    // ---- SETTERS COM VALIDAÇÃO ----
    public function setNome(string $nome): void
    {
        if (trim($nome) === '') {
            throw new InvalidArgumentException("Nome do equipamento não pode ser vazio!");
        }
        $this->nome = $nome;
    }

    public function setTipo(string $tipo): void
    {
        if (trim($tipo) === '') {
            throw new InvalidArgumentException("Tipo do equipamento não pode ser vazio!");
        }
        $this->tipo = $tipo;
    }

    public function setDisponivel(bool $disponivel): void
    {
        $this->disponivel = $disponivel;
    }

    /**
     * Exibe os dados do equipamento
     */
    public function exibir(): void
    {
        $status = $this->disponivel ? 'Disponível' : 'Indisponível';
        echo "Equipamento : {$this->nome} ({$this->tipo})\n";
        echo "Status      : {$status}\n";
    }
}


// ------------------------------------------------------------
// CLASSE: Quadra
// Representa uma quadra esportiva reservável.
// ------------------------------------------------------------
class Quadra
{
    private int    $id;
    private string $nome;
    private string $tipo;       // ex: 'Futebol', 'Tênis', 'Basquete'
    private bool   $disponivel;

    public function __construct(int $id, string $nome, string $tipo, bool $disponivel = true)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setTipo($tipo);
        $this->disponivel = $disponivel;
    }

    // ---- GETTERS ----
    public function getId(): int         { return $this->id; }
    public function getNome(): string    { return $this->nome; }
    public function getTipo(): string    { return $this->tipo; }
    public function isDisponivel(): bool { return $this->disponivel; }

    // ---- SETTERS COM VALIDAÇÃO ----
    public function setNome(string $nome): void
    {
        if (trim($nome) === '') {
            throw new InvalidArgumentException("Nome da quadra não pode ser vazio!");
        }
        $this->nome = $nome;
    }

    public function setTipo(string $tipo): void
    {
        $tiposValidos = ['Futebol', 'Tênis', 'Basquete', 'Vôlei', 'Poliesportiva'];
        if (!in_array($tipo, $tiposValidos)) {
            throw new InvalidArgumentException(
                "Tipo inválido! Use: " . implode(', ', $tiposValidos)
            );
        }
        $this->tipo = $tipo;
    }

    public function setDisponivel(bool $disponivel): void
    {
        $this->disponivel = $disponivel;
    }

    /**
     * Exibe os dados da quadra
     */
    public function exibir(): void
    {
        $status = $this->disponivel ? 'Disponível' : 'Indisponível';
        echo "Quadra  : {$this->nome} — Tipo: {$this->tipo}\n";
        echo "Status  : {$status}\n";
    }
}


// ------------------------------------------------------------
// CLASSE: EspacoLazer
// Representa um espaço de lazer reservável (ex: churrasqueira).
// ------------------------------------------------------------
class EspacoLazer
{
    private int    $id;
    private string $nome;
    private int    $capacidade;
    private bool   $disponivel;

    public function __construct(int $id, string $nome, int $capacidade, bool $disponivel = true)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setCapacidade($capacidade);
        $this->disponivel = $disponivel;
    }

    // ---- GETTERS ----
    public function getId(): int          { return $this->id; }
    public function getNome(): string     { return $this->nome; }
    public function getCapacidade(): int  { return $this->capacidade; }
    public function isDisponivel(): bool  { return $this->disponivel; }

    // ---- SETTERS COM VALIDAÇÃO ----
    public function setNome(string $nome): void
    {
        if (trim($nome) === '') {
            throw new InvalidArgumentException("Nome do espaço não pode ser vazio!");
        }
        $this->nome = $nome;
    }

    public function setCapacidade(int $capacidade): void
    {
        if ($capacidade <= 0) {
            throw new InvalidArgumentException("Capacidade deve ser maior que zero!");
        }
        $this->capacidade = $capacidade;
    }

    public function setDisponivel(bool $disponivel): void
    {
        $this->disponivel = $disponivel;
    }

    /**
     * Exibe os dados do espaço de lazer
     */
    public function exibir(): void
    {
        $status = $this->disponivel ? 'Disponível' : 'Indisponível';
        echo "Espaço      : {$this->nome}\n";
        echo "Capacidade  : {$this->capacidade} pessoa(s)\n";
        echo "Status      : {$status}\n";
    }
}


// ------------------------------------------------------------
// CLASSE: Reserva
// Representa uma reserva feita por um usuário.
// Pode ser associada a uma Quadra OU a um EspacoLazer.
// ------------------------------------------------------------
class Reserva
{
    private int    $id;
    private string $data;
    private string $horario;
    private string $status;   // 'pendente' | 'confirmada' | 'cancelada'

    // Associações com outros objetos (Reserva → Quadra / EspacoLazer)
    private ?Quadra      $quadra      = null;
    private ?EspacoLazer $espacoLazer = null;

    public function __construct(int $id, string $data, string $horario, string $status = 'pendente')
    {
        $this->id = $id;
        $this->setData($data);
        $this->setHorario($horario);
        $this->setStatus($status);
    }

    // ---- GETTERS ----
    public function getId(): int             { return $this->id; }
    public function getData(): string        { return $this->data; }
    public function getHorario(): string     { return $this->horario; }
    public function getStatus(): string      { return $this->status; }
    public function getQuadra(): ?Quadra     { return $this->quadra; }
    public function getEspacoLazer(): ?EspacoLazer { return $this->espacoLazer; }

    // ---- SETTERS COM VALIDAÇÃO ----
    public function setData(string $data): void
    {
        // Valida formato YYYY-MM-DD
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
            throw new InvalidArgumentException("Data inválida! Use o formato YYYY-MM-DD.");
        }
        $this->data = $data;
    }

    public function setHorario(string $horario): void
    {
        // Valida formato HH:MM
        if (!preg_match('/^\d{2}:\d{2}$/', $horario)) {
            throw new InvalidArgumentException("Horário inválido! Use o formato HH:MM.");
        }
        $this->horario = $horario;
    }

    public function setStatus(string $status): void
    {
        $statusValidos = ['pendente', 'confirmada', 'cancelada'];
        if (!in_array($status, $statusValidos)) {
            throw new InvalidArgumentException(
                "Status inválido! Use: " . implode(', ', $statusValidos)
            );
        }
        $this->status = $status;
    }

    // ---- ASSOCIAÇÕES ----
    public function setQuadra(Quadra $quadra): void
    {
        $this->quadra = $quadra;
        echo "Quadra '{$quadra->getNome()}' vinculada à reserva #{$this->id}.\n";
    }

    public function setEspacoLazer(EspacoLazer $espaco): void
    {
        $this->espacoLazer = $espaco;
        echo "Espaço '{$espaco->getNome()}' vinculado à reserva #{$this->id}.\n";
    }

    /**
     * Confirma a reserva (sobreposição de comportamento via status)
     */
    public function confirmar(): void
    {
        if ($this->status === 'pendente') {
            $this->setStatus('confirmada');
            echo "Reserva #{$this->id} CONFIRMADA para {$this->data} às {$this->horario}.\n";
        } else {
            echo "Reserva #{$this->id} não pode ser confirmada (status: {$this->status}).\n";
        }
    }

    /**
     * Cancela a reserva
     */
    public function cancelar(): void
    {
        if ($this->status !== 'cancelada') {
            $this->setStatus('cancelada');
            echo "Reserva #{$this->id} CANCELADA.\n";
        } else {
            echo "Reserva #{$this->id} já estava cancelada.\n";
        }
    }

    /**
     * Exibe os dados completos da reserva
     */
    public function exibir(): void
    {
        echo "Reserva #  : {$this->id}\n";
        echo "Data       : {$this->data}\n";
        echo "Horário    : {$this->horario}\n";
        echo "Status     : {$this->status}\n";

        if ($this->quadra !== null) {
            echo "Quadra     : {$this->quadra->getNome()} ({$this->quadra->getTipo()})\n";
        }
        if ($this->espacoLazer !== null) {
            echo "Espaço     : {$this->espacoLazer->getNome()}\n";
        }
    }

    /**
     * Salva a reserva em arquivo JSON (persistência)
     */
    public function salvarJson(string $arquivo): void
    {
        $dados = [
            'id'      => $this->id,
            'data'    => $this->data,
            'horario' => $this->horario,
            'status'  => $this->status,
        ];

        if ($this->quadra !== null) {
            $dados['quadra'] = $this->quadra->getNome();
        }
        if ($this->espacoLazer !== null) {
            $dados['espacoLazer'] = $this->espacoLazer->getNome();
        }

        $json = json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($arquivo, $json);
        echo "Reserva salva em {$arquivo}\n";
    }
}


// ------------------------------------------------------------
// CLASSE: Usuario
// Representa um usuário do sistema.
// Relacionamento: Usuario "faz" Reserva (associação direta).
// ------------------------------------------------------------
class Usuario
{
    private int    $id;
    private string $nome;
    private string $email;
    private string $telefone;

    public function __construct(int $id, string $nome, string $email, string $telefone)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setTelefone($telefone);
    }

    // ---- GETTERS ----
    public function getId(): int          { return $this->id; }
    public function getNome(): string     { return $this->nome; }
    public function getEmail(): string    { return $this->email; }
    public function getTelefone(): string { return $this->telefone; }

    // ---- SETTERS COM VALIDAÇÃO ----
    public function setNome(string $nome): void
    {
        if (trim($nome) === '') {
            throw new InvalidArgumentException("Nome do usuário não pode ser vazio!");
        }
        $this->nome = $nome;
    }

    public function setEmail(string $email): void
    {
        // filter_var valida o formato do e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("E-mail inválido: {$email}");
        }
        $this->email = $email;
    }

    public function setTelefone(string $telefone): void
    {
        // Remove tudo que não for dígito e verifica mínimo de 10 dígitos
        $digitos = preg_replace('/\D/', '', $telefone);
        if (strlen($digitos) < 10) {
            throw new InvalidArgumentException("Telefone inválido! Mínimo de 10 dígitos.");
        }
        $this->telefone = $telefone;
    }

    /**
     * MÉTODO: fazerReserva()
     * Cria e retorna um objeto Reserva vinculado a este usuário.
     */
    public function fazerReserva(string $data, string $horario): Reserva
    {
        $reserva = new Reserva(rand(1, 9999), $data, $horario, 'pendente');
        echo "Reserva criada por {$this->nome} — {$data} às {$horario}.\n";
        return $reserva;
    }

    /**
     * MÉTODO: alugarEquipamento()
     * Marca o equipamento como indisponível ao alugar.
     */
    public function alugarEquipamento(Equipamento $equipamento): void
    {
        if ($equipamento->isDisponivel()) {
            $equipamento->setDisponivel(false);
            echo "{$this->nome} alugou: {$equipamento->getNome()}.\n";
        } else {
            echo "Equipamento '{$equipamento->getNome()}' indisponível para aluguel.\n";
        }
    }

    /**
     * MÉTODO: comprarProduto()
     * Reduz o estoque do produto em 1 unidade ao comprar.
     */
    public function comprarProduto(Produto $produto): void
    {
        if ($produto->getEstoque() > 0) {
            $produto->setEstoque($produto->getEstoque() - 1);
            echo "{$this->nome} comprou '{$produto->getNome()}'. "
               . "Estoque restante: {$produto->getEstoque()}.\n";
        } else {
            echo "Produto '{$produto->getNome()}' sem estoque.\n";
        }
    }

    /**
     * Exibe os dados do usuário
     */
    public function exibir(): void
    {
        echo "Usuário   : {$this->nome}\n";
        echo "E-mail    : {$this->email}\n";
        echo "Telefone  : {$this->telefone}\n";
    }
}


// ============================================================
//  DEMONSTRAÇÃO DE USO — rode com: php classes.php
// ============================================================

echo "========================================\n";
echo "  SISTEMA DE RESERVAS — DEMONSTRAÇÃO\n";
echo "========================================\n\n";

// --- Criando usuário ---
$usuario = new Usuario(1, 'Rafael', 'rafael@email.com', '(11) 99999-0000');
echo "[ Usuário criado ]\n";
$usuario->exibir();

echo "\n--- Reserva de Quadra ---\n";
$reserva1 = $usuario->fazerReserva('2026-04-20', '10:00');
$quadra    = new Quadra(1, 'Quadra A', 'Futebol');
$reserva1->setQuadra($quadra);
$reserva1->confirmar();
$reserva1->exibir();

// Persistência JSON
$reserva1->salvarJson('reserva1.json');

echo "\n--- Reserva de Espaço de Lazer ---\n";
$reserva2    = $usuario->fazerReserva('2026-04-21', '14:00');
$churrasqueira = new EspacoLazer(1, 'Churrasqueira 1', 30);
$reserva2->setEspacoLazer($churrasqueira);
$reserva2->confirmar();
$reserva2->cancelar(); // cancelar após confirmar
$reserva2->exibir();

echo "\n--- Aluguel de Equipamento ---\n";
$bola = new Equipamento(1, 'Bola de Futebol', 'Futebol');
$bola->exibir();
$usuario->alugarEquipamento($bola);
$usuario->alugarEquipamento($bola); // tenta alugar de novo — indisponível

echo "\n--- Bar e Produtos ---\n";
$bar     = new Bar(1, 'Bar Central');
$suco    = new Produto(1, 'Suco de Laranja', 8.50, 5);
$cerveja = new Produto(2, 'Cerveja Gelada',  7.00, 3);
$bar->adicionarProduto($suco);
$bar->adicionarProduto($cerveja);
$bar->exibir();

echo "\n";
$usuario->comprarProduto($suco);
$usuario->comprarProduto($suco);

// Salva produto em JSON
$suco->salvarJson('suco.json');

echo "\n--- Ligação Dinâmica (Polimorfismo) ---\n";
// Todas as reservas se comportam de forma correta
// quando chamamos o mesmo método confirmar() em objetos distintos
$reservas = [
    $usuario->fazerReserva('2026-05-01', '09:00'),
    $usuario->fazerReserva('2026-05-02', '11:00'),
];
foreach ($reservas as $r) {
    $r->confirmar();
}

echo "\n========================================\n";
echo "  FIM DA DEMONSTRAÇÃO\n";
echo "========================================\n";

