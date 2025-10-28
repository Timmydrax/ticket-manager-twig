<?php
$tickets = json_decode(file_get_contents('tickets.json'), true) ?? [];
$show_form = $_GET['show_form'] ?? false;

$content = <<<'HTML'
<div style="min-height: 100vh; background-color: #f9fafb;">
    <header>
        <div class="header-content">
            <h1>HNG Ticket Manager</h1>
            <a href="/twig/public/dashboard" class="button">Back to Dashboard</a>
        </div>
    </header>

    <main class="container">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem;">Tickets</h2>
                <p class="text-gray-600">Manage all your tickets in one place</p>
            </div>
            <a href="?show_form=1" class="button primary">Create Ticket</a>
        </div>

        {{ form_section }}

        <div class="space-y-4">
            {{ tickets_list }}
        </div>
    </main>
</div>
HTML;

// Build form section
$form_section = '';
if ($show_form) {
    $form_section = <<<'FORM'
<div class="card mb-8">
    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Create New Ticket</h3>
    <form method="POST" class="space-y-4">
        <input type="hidden" name="action" value="create_ticket">
        
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" placeholder="Ticket title" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" placeholder="Ticket description (optional)" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="open">Open</option>
                <option value="in_progress">In Progress</option>
                <option value="closed">Closed</option>
            </select>
        </div>

        <button type="submit" class="primary" style="width: 100%; padding: 0.5rem;">Create Ticket</button>
    </form>
</div>
FORM;
}

// Build tickets list
$tickets_list = '';
if (empty($tickets)) {
    $tickets_list = <<<'EMPTY'
<div class="card" style="padding: 3rem; text-align: center;">
    <p class="text-gray-600 mb-4">No tickets yet. Create one to get started!</p>
    <a href="?show_form=1" class="button primary">Create First Ticket</a>
</div>
EMPTY;
} else {
    foreach ($tickets as $ticket) {
        $status_class = $ticket['status'];
        $status_label = str_replace('_', ' ', ucfirst($ticket['status']));
        $date = date('m/d/Y', strtotime($ticket['createdAt']));

        $tickets_list .= <<<TICKET
<div class="card">
    <div class="ticket-card">
        <div class="ticket-info" style="flex: 1;">
            <h3>{$ticket['title']}</h3>
            <p>{$ticket['description']}</p>
            <div class="ticket-meta">
                <span class="status-badge {$status_class}">{$status_label}</span>
                <span class="text-sm text-gray-600">{$date}</span>
            </div>
        </div>
        <div class="ticket-actions">
            <a href="/twig/public/tickets/{$ticket['id']}" class="button">Edit</a>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="action" value="delete_ticket">
                <input type="hidden" name="ticket_id" value="{$ticket['id']}">
                <button type="submit" class="button danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
TICKET;
    }
}

$content = str_replace('{{ form_section }}', $form_section, $content);
$content = str_replace('{{ tickets_list }}', $tickets_list, $content);

include 'layout.html';