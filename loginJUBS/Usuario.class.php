<?php
// usuario.php
declare(strict_types=1);

require_once __DIR__ . '/naosei.php';

class Usuario {
    private ?int $id;
    private ?int $external_id; // campo opcional se quiser enviar id via formulário
    private string $email;
    private string $senhaHash; // armazena hash

    public function __construct(?int $id, ?int $external_id, string $email, string $senhaHash) {
        $this->id = $id;
        $this->external_id = $external_id;
        $this->email = trim($email);
        $this->senhaHash = $senhaHash;
    }

    // getters
    public function getId(): ?int { return $this->id; }
    public function getExternalId(): ?int { return $this->external_id; }
    public function getEmail(): string { return $this->email; }
    // Observação: não expor hash em produção. Aqui só para debug/testes.
    public function getSenhaHash(): string { return $this->senhaHash; }

    // validação básica conforme seu fluxograma
    public function construtor(): bool {
        $okEmail = filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
        $okSenha = is_string($this->senhaHash) && strlen($this->senhaHash) > 0;
        // external_id pode ser null ou inteiro
        return $okEmail && $okSenha;
    }

    // Converte linha do DB em objeto
    public static function fromRow(array $row): Usuario {
        return new Usuario(
            isset($row['id']) ? (int)$row['id'] : null,
            isset($row['external_id']) && $row['external_id'] !== null ? (int)$row['external_id'] : null,
            $row['email'] ?? '',
            $row['senha'] ?? ''
        );
    }
}

/* ===========================
   Funções que usam PDO
   =========================== */

/**
 * Registra usuário.
 * @param int|null $externalId valor opcional (id vindo do formulário)
 * @param string $email
 * @param string $plainSenha senha em texto puro — será hasheada
 * @return array [bool success, string message]
 */
function registerUserPDO(?int $externalId, string $email, string $plainSenha): array {
    $pdo = getPDO();

    // validação básica
    $email = trim($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [false, 'Email inválido.'];
    }
    if (strlen($plainSenha) < 4) {
        return [false, 'Senha muito curta (mínimo 4 caracteres).'];
    }

    try {
        // checar duplicado
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            return [false, 'Já existe usuário com esse email.'];
        }

        // criar hash
        $hash = password_hash($plainSenha, PASSWORD_DEFAULT);

        // inserir (external_id pode ser null)
        $stmt = $pdo->prepare("INSERT INTO users (external_id, email, senha) VALUES (:external_id, :email, :senha)");
        $stmt->bindValue(':external_id', $externalId, $externalId === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $hash, PDO::PARAM_STR);
        $stmt->execute();

        return [true, 'Usuário cadastrado com sucesso.'];
    } catch (PDOException $e) {
        // Em produção: log e mensagem genérica
        return [false, 'Erro no registro: ' . $e->getMessage()];
    }
}

/**
 * Autentica usuário por email/senha
 * @param string $email
 * @param string $plainSenha
 * @return Usuario|null
 */
function authenticateUserPDO(string $email, string $plainSenha): ?Usuario {
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => trim($email)]);
        $row = $stmt->fetch();
        if (!$row) return null;

        $hash = $row['senha'];
        if (password_verify($plainSenha, $hash)) {
            return Usuario::fromRow($row);
        }
        return null;
    } catch (PDOException $e) {
        return null;
    }
}

/**
 * Busca todos os usuários (retorna array de Usuario)
 * @return Usuario[]
 */
function getAllUsersPDO(): array {
    $pdo = getPDO();
    try {
        $stmt = $pdo->query("SELECT id, external_id, email, senha, created_at FROM users ORDER BY id ASC");
        $rows = $stmt->fetchAll();
        $out = [];
        foreach ($rows as $r) $out[] = Usuario::fromRow($r);
        return $out;
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Atualiza email (verifica duplicidade)
 * @return array [bool, string]
 */
function changeUserEmailPDO(int $id, string $newEmail): array {
    $pdo = getPDO();
    $newEmail = trim($newEmail);
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) return [false, 'Email inválido.'];

    try {
        // checar duplicado
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND id <> :id LIMIT 1");
        $stmt->execute([':email' => $newEmail, ':id' => $id]);
        if ($stmt->fetch()) return [false, 'Já existe usuário com esse email.'];

        $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
        $stmt->execute([':email' => $newEmail, ':id' => $id]);
        return [true, 'Email atualizado.'];
    } catch (PDOException $e) {
        return [false, 'Erro ao atualizar email: ' . $e->getMessage()];
    }
}

/**
 * Atualiza senha (gera novo hash)
 */
function changeUserSenhaPDO(int $id, string $newSenha): array {
    if (strlen($newSenha) < 4) return [false, 'Senha muito curta.'];

    $pdo = getPDO();
    $hash = password_hash($newSenha, PASSWORD_DEFAULT);
    try {
        $stmt = $pdo->prepare("UPDATE users SET senha = :senha WHERE id = :id");
        $stmt->execute([':senha' => $hash, ':id' => $id]);
        return [true, 'Senha atualizada.'];
    } catch (PDOException $e) {
        return [false, 'Erro ao atualizar senha: ' . $e->getMessage()];
    }
}

/**
 * Excluir usuário (apenas para testes)
 */
function deleteUserPDO(int $id): array {
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return [true, 'Usuário excluído.'];
    } catch (PDOException $e) {
        return [false, 'Erro ao excluir: ' . $e->getMessage()];
    }
}
