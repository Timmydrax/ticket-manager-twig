<?php
session_start();

// Simple router
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = str_replace('/twig/public', '', $request_uri);
if (empty($request_uri))
    $request_uri = '/';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($email === 'demo@example.com' && $password === 'password123') {
            $_SESSION['user'] = [
                'email' => $email,
                'token' => 'mock-token-' . time(),
                'createdAt' => date('c')
            ];
            header('Location: /twig/public/dashboard');
            exit;
        } else {
            $login_error = 'Invalid email or password';
        }
    } elseif ($action === 'signup') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($name && $email && $password === $confirm_password && strlen($password) >= 6) {
            $_SESSION['user'] = [
                'email' => $email,
                'name' => $name,
                'token' => 'mock-token-' . time(),
                'createdAt' => date('c')
            ];
            header('Location: /twig/public/dashboard');
            exit;
        }
    } elseif ($action === 'logout') {
        session_destroy();
        header('Location: /twig/public/');
        exit;
    } elseif ($action === 'create_ticket') {
        if (!isset($_SESSION['user'])) {
            header('Location: /twig/public/auth/login');
            exit;
        }

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'open';

        if ($title) {
            $tickets = json_decode(file_get_contents('tickets.json'), true) ?? [];
            $tickets[] = [
                'id' => time(),
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'createdAt' => date('c')
            ];
            file_put_contents('tickets.json', json_encode($tickets));
            header('Location: /twig/public/tickets');
            exit;
        }
    } elseif ($action === 'delete_ticket') {
        if (!isset($_SESSION['user'])) {
            header('Location: /twig/public/auth/login');
            exit;
        }

        $ticket_id = $_POST['ticket_id'] ?? '';
        $tickets = json_decode(file_get_contents('tickets.json'), true) ?? [];
        $tickets = array_filter($tickets, fn($t) => $t['id'] != $ticket_id);
        file_put_contents('tickets.json', json_encode(array_values($tickets)));
        header('Location: /twig/public/tickets');
        exit;
    } elseif ($action === 'update_ticket') {
        if (!isset($_SESSION['user'])) {
            header('Location: /twig/public/auth/login');
            exit;
        }

        $ticket_id = $_POST['ticket_id'] ?? '';
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'open';

        if ($title) {
            $tickets = json_decode(file_get_contents('tickets.json'), true) ?? [];
            foreach ($tickets as &$t) {
                if ($t['id'] == $ticket_id) {
                    $t['title'] = $title;
                    $t['description'] = $description;
                    $t['status'] = $status;
                    break;
                }
            }
            file_put_contents('tickets.json', json_encode($tickets));
            header('Location: /twig/public/tickets');
            exit;
        }
    }
}

// Route handling
switch ($request_uri) {
    case '/':
        include 'views/landing.php';
        break;
    case '/auth/login':
        include 'views/login.php';
        break;
    case '/auth/signup':
        include 'views/signup.php';
        break;
    case '/dashboard':
        if (!isset($_SESSION['user'])) {
            header('Location: /twig/public/auth/login');
            exit;
        }
        include 'views/dashboard.php';
        break;
    case '/tickets':
        if (!isset($_SESSION['user'])) {
            header('Location: /twig/public/auth/login');
            exit;
        }
        include 'views/tickets.php';
        break;
    case preg_match('/^\/tickets\/(\d+)$/', $request_uri, $matches) ? true : false:
        if (!isset($_SESSION['user'])) {
            header('Location: /twig/public/auth/login');
            exit;
        }
        $ticket_id = $matches[1];
        include 'views/edit-ticket.php';
        break;
    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}

