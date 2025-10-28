<?php
$content = <<<'HTML'
<div style="min-height: 100vh; display: flex; flex-direction: column;">
    <header>
        <div class="header-content">
            <h1>HNG Ticket Manager</h1>
            <div class="header-buttons">
                <a href="/twig/public/auth/login" class="button">Login</a>
                <a href="/twig/public/auth/signup" class="button primary">Get Started</a>
            </div>
        </div>
    </header>

    <section class="wave-bg" style="flex: 1; position: relative;">
        <div class="circle-decoration circle-lg bg-white" style="top: 2.5rem; right: 5rem;"></div>
        <div class="circle-decoration circle-md bg-white" style="bottom: 5rem; left: 2.5rem;"></div>

        <div class="hero">
            <h2>Manage Your Tickets Efficiently</h2>
            <p>A simple, powerful ticket management system to track, organize, and resolve issues with ease.</p>
            <div class="hero-buttons">
                <a href="/twig/public/auth/signup" class="button primary">Start Free</a>
                <a href="/twig/public/auth/login" class="button secondary">Sign In</a>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h3>Features</h3>
            <div class="grid grid-3">
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h4>Create Tickets</h4>
                    <p>Easily create and organize tickets with titles, descriptions, and status tracking.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h4>Track Progress</h4>
                    <p>Monitor ticket status from open to in-progress to closed with real-time updates.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h4>View Statistics</h4>
                    <p>Get insights into your ticket workflow with comprehensive statistics and metrics.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 HNG Ticket Manager. All rights reserved.</p>
    </footer>
</div>
HTML;
include 'layout.html';
