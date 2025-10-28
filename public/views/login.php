<?php
$login_error = $login_error ?? '';
$content = <<<'HTML'
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f9fafb; padding: 1rem;">
    <div class="card large" style="width: 100%; max-width: 28rem;">
        <div class="mb-8">
            <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem;">Welcome Back</h1>
            <p class="text-gray-600">Sign in to your account to continue</p>
        </div>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <?php if ($login_error): ?>
                <div class="error-message"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>

            <button type="submit" class="primary" style="width: 100%; padding: 0.5rem;">Sign In</button>
        </form>

        <div class="demo-credentials">
            <strong>Demo credentials:</strong><br>
            Email: <code>demo@example.com</code><br>
            Password: <code>password123</code>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="/twig/public/auth/signup" style="color: #2563eb; text-decoration: none; font-weight: 500;">Sign up</a>
            </p>
        </div>
    </div>
</div>
HTML;
include 'layout.html';
?>