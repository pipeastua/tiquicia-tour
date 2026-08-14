<?php

require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../Models/Destination.php';

class DestinationController
{
    public function index()
    {
        $destinations = Destination::getAll();
        $toast_messages = [];

        if (isset($_GET['created'])) {
            $toast_messages[] = ['type' => 'success', 'message' => 'Destino creado correctamente.'];
        }
        if (isset($_GET['updated'])) {
            $toast_messages[] = ['type' => 'success', 'message' => 'Destino actualizado correctamente.'];
        }
        if (isset($_GET['deleted'])) {
            $toast_messages[] = ['type' => 'success', 'message' => 'Destino eliminado correctamente.'];
        }

        include __DIR__ . '/../Views/destinations/index.php';
    }

    public function show()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $destination = Destination::findById($id);

        if (!$destination) {
            header('Location: /destination');
            exit;
        }

        $activities = Destination::getActivities($id);

        include __DIR__ . '/../Views/destinations/show.php';
    }

    public function create()
    {
        $errors = [];
        $data = ['nombre' => '', 'provincia' => '', 'canton' => '', 'descripcion' => ''];
        $toast_messages = [];
        $formAction = '/destination/create';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$errors, $data] = $this->validateAndCollect($_POST);

            if (empty($errors)) {
                $result = Destination::create($data['nombre'], $data['provincia'], $data['canton'], $data['descripcion']);

                if ($result['success']) {
                    header('Location: /destination?created=1');
                    exit;
                }

                $errors['general'] = $result['error'];
            }

            if (!empty($errors)) {
                $toast_messages[] = ['type' => 'error', 'message' => 'Por favor, corrige los errores en el formulario.'];
            }
        }

        include __DIR__ . '/../Views/destinations/form.php';
    }

    public function edit()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $destination = Destination::findById($id);

        if (!$destination) {
            header('Location: /destination');
            exit;
        }

        $errors = [];
        $data = $destination;
        $toast_messages = [];
        $formAction = '/destination/edit?id=' . $id;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$errors, $data] = $this->validateAndCollect($_POST);
            $data['id'] = $id;

            if (empty($errors)) {
                $result = Destination::update($id, $data['nombre'], $data['provincia'], $data['canton'], $data['descripcion']);

                if ($result['success']) {
                    header('Location: /destination?updated=1');
                    exit;
                }

                $errors['general'] = $result['error'];
            }

            if (!empty($errors)) {
                $toast_messages[] = ['type' => 'error', 'message' => 'Por favor, corrige los errores en el formulario.'];
            }
        }

        include __DIR__ . '/../Views/destinations/form.php';
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /destination');
            exit;
        }

        if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
            header('Location: /destination');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            Destination::softDelete($id);
        }

        header('Location: /destination?deleted=1');
        exit;
    }

    public function validateAndCollect(array $post): array
    {
        $errors = [];
        $data = [
            'nombre' => Security::sanitizeInput($post['nombre'] ?? ''),
            'provincia' => Security::sanitizeInput($post['provincia'] ?? ''),
            'canton' => Security::sanitizeInput($post['canton'] ?? ''),
            'descripcion' => Security::sanitizeInput($post['descripcion'] ?? '')
        ];

        if (!isset($post['csrf_token']) || !Security::validateCSRFToken($post['csrf_token'])) {
            $errors['general'] = 'Token de seguridad inválido. Intente nuevamente.';
            return [$errors, $data];
        }
        if (empty($data['nombre'])) {
            $errors['nombre'] = 'El nombre es obligatorio.';
        }
        if (empty($data['provincia'])) {
            $errors['provincia'] = 'La provincia es obligatoria.';
        }
        return [$errors, $data];
    }
}
