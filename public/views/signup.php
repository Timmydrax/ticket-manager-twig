<?php
$content = <<<'HTML'
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f9fafb; padding: 1rem;">
    <div class="card large" style="width: 100%; max-width: 28rem;">
        <div class="mb-8">
            <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem;">Create Account</h1>
            <p class="text-gray-600">Sign up to get started with ticket management</p>
        </div>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="action" value="signup">
            
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="primary" style="width: 100%; padding: 0.5rem;">Create Account</button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="/twig/public/auth/login" style="color: #2563eb; text-decoration: none; font-weight: 500;">Sign in</a>
            </p>
        </div>
    </div>
</div>
HTML;
include 'layout.html';
