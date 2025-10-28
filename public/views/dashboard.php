<?php
$user = $_SESSION['user'] ?? [];
$tickets = json_decode(file_get_contents('tickets.json'), true) ?? [];

$stats = [
    'total' => count($tickets),
    'open' => count(array_filter($tickets, fn($t) => $t['status'] === 'open')),
    'inProgress' => count(array_filter($tickets, fn($t) => $t['status'] === 'in_progress')),
    'closed' => count(array_filter($tickets, fn($t) => $t['status'] === 'closed'))
];

$content = <<<'HTML'
<div style="min-height: 100vh; background-color: #f9fafb;">
    <header>
        <div class="header-content">
            <h1>HNG Ticket Manager</h1>
            <div class="header-buttons" style="gap: 1rem; align-items: center;">
                <span class="text-sm text-gray-600">{{ user.email }}</span>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="button">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="mb-8">
            <h2 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem;">Dashboard</h2>
            <p class="text-gray-600">Welcome back, {{ user.name || user.email }}!</p>
        </div>

        <div class="grid grid-4 mb-12">
            <div class="card stat-card">
                <div class="stat-label">Total Tickets</div>
                <div class="stat-value">{{ stats.total }}</div>
            </div>
            <div class="card stat-card open">
                <div class="stat-label">Open</div>
                <div class="stat-value">{{ stats.open }}</div>
            </div>
            <div class="card stat-card in-progress">
                <div class="stat-label">In Progress</div>
                <div class="stat-value">{{ stats.inProgress }}</div>
            </div>
            <div class="card stat-card closed">
                <div class="stat-label">Closed</div>
                <div class="stat-value">{{ stats.closed }}</div>
            </div>
        </div>

        <div class="card large text-center">
            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Ready to manage your tickets?</h3>
            <p class="text-gray-600 mb-6">Create, view, edit, and delete tickets to keep your workflow organized.</p>
            <a href="/twig/public/tickets" class="button primary" style="padding: 0.75rem 2rem;">Go to Ticket Management</a>
        </div>
    </main>
</div>
HTML;

// Replace template variables
$content = str_replace('{{ user.email }}', htmlspecialchars($user['email'] ?? ''), $content);
$content = str_replace('{{ user.name || user.email }}', htmlspecialchars($user['name'] ?? $user['email'] ?? ''), $content);
$content = str_replace('{{ stats.total }}', $stats['total'], $content);
$content = str_replace('{{ stats.open }}', $stats['open'], $content);
$content = str_replace('{{ stats.inProgress }}', $stats['inProgress'], $content);
$content = str_replace('{{ stats.closed }}', $stats['closed'], $content);

include 'layout.html';
