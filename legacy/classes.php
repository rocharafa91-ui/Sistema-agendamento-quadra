<?php
/**
 * ARQUIVO ORIGINAL (legado) — Sistema de reservas em PHP procedural/OOP.
 *
 * Mantido aqui apenas como referência da lógica de negócio.
 * No Laravel, esta lógica foi reorganizada em MVC:
 *   - Models      -> app/Models/*
 *   - Controllers -> app/Http/Controllers/*
 *   - Views       -> resources/views/*
 *
 * Para rodar este arquivo isolado (sem Laravel):
 *   php legacy/classes.php
 */

declare(strict_types=1);

// ------------------------------------------------------------
// CLASSE: Produto
// Representa um produto vendido no bar do estabelecimento.
// ------------------------------------------------------------
class Produto
{
    private int $id;
    private string $nome;
    private float $preco;
    private int $estoque;

    public function __construct(int $id, string $nome, float $preco, int $estoque)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setPreco($preco);
        $this->setEstoque($estoque);
    }

    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getPreco(): float { return $this->preco; }
    public function getEstoque(): int { return $this->estoque; }

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

    public function exibir(): void
    {
        echo "Produto    : {$this->nome}\n";
        echo "Preço      : R$ " . number_format($this->preco, 2, ',', '.') . "\n";
        echo "Estoque    : {$this->estoque} unidade(s)\n";
    }

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

    public static function carregarJson(string $arquivo): self
    {
        $dados = json_decode(file_get_contents($arquivo), true);
        return new self($dados['id'], $dados['nome'], $dados['preco'], $dados['estoque']);
    }
}

// ------------------------------------------------------------
// CLASSE: Bar
// ------------------------------------------------------------
class Bar
{
    private int $id;
    private string $nome;
    /** @var Produto[] */
    private array $produtos = [];

    public function __construct(int $id, string $nome)
    {
        $this->id = $id;
        $this->setNome($nome);
    }

    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }

    public function setNome(string $nome): void
    {
        if (trim($nome) === '') {
            throw new InvalidArgumentException("Nome do bar não pode ser vazio!");
        }
        $this->nome = $nome;
    }

    public function adicionarProduto(Produto $produto): void
    {
        $this->produtos[] = $produto;
    }

    public function getProdutos(): array { return $this->produtos; }

    public function buscarProduto(string $nome): ?Produto
    {
        foreach ($this->produtos as $produto) {
            if (strtolower($produto->getNome()) === strtolower($nome)) {
                return $produto;
            }
        }
        return null;
    }
}

// ------------------------------------------------------------
// CLASSE: Equipamento
// ------------------------------------------------------------
class Equipamento
{
    private int $id;
    private string $nome;
    private string $tipo;
    private bool $disponivel;

    public function __construct(int $id, string $nome, string $tipo, bool $disponivel = true)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setTipo($tipo);
        $this->disponivel = $disponivel;
    }

    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getTipo(): string { return $this->tipo; }
    public function isDisponivel(): bool { return $this->disponivel; }

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

    public function setDisponivel(bool $disponivel): void { $this->disponivel = $disponivel; }
}

// ------------------------------------------------------------
// CLASSE: Quadra
// ------------------------------------------------------------
class Quadra
{
    private int $id;
    private string $nome;
    private string $tipo;
    private bool $disponivel;

    public function __construct(int $id, string $nome, string $tipo, bool $disponivel = true)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setTipo($tipo);
        $this->disponivel = $disponivel;
    }

    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getTipo(): string { return $this->tipo; }
    public function isDisponivel(): bool { return $this->disponivel; }

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

    public function setDisponivel(bool $disponivel): void { $this->disponivel = $disponivel; }
}

// ------------------------------------------------------------
// CLASSE: EspacoLazer
// ------------------------------------------------------------
class EspacoLazer
{
    private int $id;
    private string $nome;
    private int $capacidade;
    private bool $disponivel;

    public function __construct(int $id, string $nome, int $capacidade, bool $disponivel = true)
    {
        $this->id = $id;
        $this->setNome($nome);
        $this->setCapacidade($capacidade);
        $this->disponivel = $disponivel;
    }

    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getCapacidade(): int { return $this->capacidade; }
    public function isDisponivel(): bool { return $this->disponivel; }

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

    public function setDisponivel(bool $disponivel): void { $this->disponivel = $disponivel; }
}

// ------------------------------------------------------------
// CLASSE: Reserva
// ------------------------------------------------------------
class Reserva
{
    private int $id;
    private string $data;
    private string $horario;
    private string $status;
    private ?Quadra $quadra = null;
    private ?EspacoLazer $espacoLazer = null;

    public function __construct(int $id, string $data, string $horario, string $status = 'pendente')
    {
        $this->id = $id;
        $this->setData($data);
        $this->setHorario($horario);
        $this->setStatus($status);
    }

    public function getId(): int { return $this->id; }
    public function getData(): string { return $this->data; }
    public function getHorario(): string { return $this->horario; }
    public function getStatus(): string { return $this->status; }
    public function getQuadra(): ?Quadra { return $this->quadra; }
    public function getEspacoLazer(): ?EspacoLazer { return $this->espacoLazer; }

    public function setData(string $data): void
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
            throw new InvalidArgumentException("Data inválida! Use YYYY-MM-DD.");
        }
        $this->data = $data;
    }

    public function setHorario(string $horario): void
    {
        if (!preg_match('/^\d{2}:\d{2}$/', $horario)) {
            throw new InvalidArgumentException("Horário inválido! Use HH:MM.");
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

    public function setQuadra(Quadra $quadra): void { $this->quadra = $quadra; }
    public function setEspacoLazer(EspacoLazer $espaco): void { $this->espacoLazer = $espaco; }

    public function confirmar(): void
    {
        if ($this->status === 'pendente') {
            $this->setStatus('confirmada');
        }
    }

    public function cancelar(): void
    {
        if ($this->status !== 'cancelada') {
            $this->setStatus('cancelada');
        }
    }
}

// ------------------------------------------------------------
// CLASSE: Usuario
// ------------------------------------------------------------
class Usuario
{
    private int $id;
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

    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getEmail(): string { return $this->email; }
    public function getTelefone(): string { return $this->telefone; }

    public function setNome(string $nome): void
    {
        if (trim($nome) === '') {
            throw new InvalidArgumentException("Nome do usuário não pode ser vazio!");
        }
        $this->nome = $nome;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("E-mail inválido: {$email}");
        }
        $this->email = $email;
    }

    public function setTelefone(string $telefone): void
    {
        $digitos = preg_replace('/\D/', '', $telefone);
        if (strlen($digitos) < 10) {
            throw new InvalidArgumentException("Telefone inválido! Mínimo de 10 dígitos.");
        }
        $this->telefone = $telefone;
    }

    public function fazerReserva(string $data, string $horario): Reserva
    {
        return new Reserva(rand(1, 9999), $data, $horario, 'pendente');
    }

    public function alugarEquipamento(Equipamento $equipamento): void
    {
        if ($equipamento->isDisponivel()) {
            $equipamento->setDisponivel(false);
        }
    }

    public function comprarProduto(Produto $produto): void
    {
        if ($produto->getEstoque() > 0) {
            $produto->setEstoque($produto->getEstoque() - 1);
        }
    }
}
