<?php

require_once __DIR__ . '/../core/DataBase.php';

class User
{
    // Constantes
    private const MAX_ATTEMPTS = 5;
    private const BLOCK_MINS = 15;

    // Validaciones
    public static function findByEmail(string $email): ?array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT id, nombre, email, password, role, activo, intentos_fallidos, ultimo_intento
            FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public static function emailExist(string $email): bool
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch() !== false;
    }

    public static function findById(int $id): ?array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT id, nombre, email, role, created_at FROM usuarios WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function updateProfile(int $id, string $nombre, string $email): array
    {
        $pdo = DataBase::getConnection();
        $exists = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email AND id != :id");
        $exists->execute(['email' => $email, 'id' => $id]);
        if ($exists->fetch()) return ['success' => false, 'error' => 'Ese correo ya está en uso.'];
        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id AND deleted_at IS NULL");
            $stmt->execute(compact('id', 'nombre', 'email'));
            return ['success' => true];
        } catch (PDOException $e) {
            error_log('Error en User::updateProfile: ' . $e->getMessage());
            return ['success' => false, 'error' => 'No se pudo actualizar el perfil.'];
        }
    }

    // Funciones de usuario
    public static function create(string $nombre, string $email, string $password): array
    {
        if (self::emailExist($email)) {
            return ['success' => false, 'error' => 'Ese correo electrónico ya está registrado.'];
        }

        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare(
            "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)"
        );

        try {
            $stmt->execute([
                'nombre' => $nombre,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            return ['success' => true, 'id' => (int) $pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log('Error en Usuario::create: ' . $e->getMessage());
            return ['success' => false, 'error' => 'No se pudo crear la cuenta. Intente nuevamente.'];
        }
    }

    public static function attemptLogin(string $email, string $password): array
    {
        if (!Security::checkRateLimit('login', 5, 300)) {
            return ['success' => false, 'error' => 'Demasiados intentos. Intente nuevamente en unos minutos.'];
        }

        $user = self::findByEmail($email);

        if (!$user || !$user['activo']) {
            return ['success' => false, 'error' => 'Correo electrónico o contraseña incorrectos.'];
        }

        if (
            $user['intentos_fallidos'] >= self::MAX_ATTEMPTS &&
            $user['ultimo_intento'] && (time() - strtotime($user['ultimo_intento'])) < self::BLOCK_MINS * 60
        ) {
            return [
                'success' => false,
                'error' => 'Cuenta bloqueada temporalmente por intentos fallidos. Intente en ' . self::BLOCK_MINS . ' minutos.'
            ];
        }

        if (!password_verify($password, $user['password'])) {
            self::logFailedAttempt($user['id']);
            return ['success' => false, 'error' => 'Correo electrónico o contraseña incorrectos.'];
        }

        self::restartFailedAttempts($user['id']);

        return ['success' => true, 'user' => $user];
    }

    private static function logFailedAttempt(int $id): void
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare(
            "UPDATE usuarios SET intentos_fallidos = intentos_fallidos + 1, ultimo_intento = NOW() WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
    }

    private static function restartFailedAttempts(int $id): void
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare(
            "UPDATE usuarios SET intentos_fallidos = 0, ultimo_intento = NULL WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
    }
}
