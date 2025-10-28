<?php
$tickets = json_decode(file_get_contents('tickets.json'), true) ?? [];
$ticket = null;

foreach ($tickets as $t) {
    if ($t['id'] == $ticket_id) {
        $ticket = $t;
        break;
    }
}

if (!$ticket) {
    header('Location: /twig/public/tickets');
    exit;
}

$content = <<<'HTML'
<div style="min-height: 100vh; background-color: #f9fafb;">
    <header>
        <div class="header-content">
            <h1>HNG Ticket Manager</h1>
            <a href="/twig/public/tickets" class="button">Back to Tickets</a>
        </div>
    </header>

    <main class="container container-sm">
        <div class="card large">
            <h2 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 1.5rem;">Edit Ticket</h2>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="action" value="update_ticket">
                <input type="hidden" name="ticket_id" value="{{ ticket.id }}">
                
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" placeholder="Ticket title" value="{{ ticket.title }}" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" placeholder="Ticket description" rows="6">{{ ticket.description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="open" {{ ticket.status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ ticket.status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ ticket.status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="primary" style="flex: 1; padding: 0.5rem;">Save Changes</button>
                    <a href="/twig/public/tickets" class="button" style="flex: 1; padding: 0.5rem; text-align: center;">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</div>
HTML;

// Replace template variables
$content = str_replace('{{ ticket.id }}', $ticket['id'], $content);
$content = str_replace('{{ ticket.title }}', htmlspecialchars($ticket['title']), $content);
$content = str_replace('{{ ticket.description }}', htmlspecialchars($ticket['description']), $content);
$content = str_replace('{{ ticket.status === \'open\' ? \'selected\' : \'\' }}', $ticket['status'] === 'open' ? 'selected' : '', $content);
$content = str_replace('{{ ticket.status === \'in_progress\' ? \'selected\' : \'\' }}', $ticket['status'] === 'in_progress' ? 'selected' : '', $content);
$content = str_replace('{{ ticket.status === \'closed\' ? \'selected\' : \'\' }}', $ticket['status'] === 'closed' ? 'selected' : '', $content);

include 'layout.html';
