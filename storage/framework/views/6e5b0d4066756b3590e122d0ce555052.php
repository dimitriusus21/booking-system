<?php $__env->startSection('title', 'Главная'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* ============================================
           DESIGN SYSTEM 2026 - VARIABLES
           ============================================ */
        :root {
            /* Primary Colors */
            --primary: #0066ff;
            --primary-dark: #0052cc;
            --primary-light: #3385ff;
            --primary-glow: rgba(0, 102, 255, 0.3);

            --secondary: #7b2cbf;
            --secondary-dark: #5a1f8a;
            --secondary-light: #9d4edd;
            --secondary-glow: rgba(123, 44, 191, 0.3);

            --accent-cyan: #00d2ff;
            --accent-purple: #7b2cbf;
            --accent-pink: #ff006e;
            --accent-orange: #ff6b00;

            /* Semantic Colors */
            --success: #06d6a0;
            --success-dark: #05b384;
            --success-surface: rgba(6, 214, 160, 0.08);

            --warning: #ffd166;
            --warning-dark: #e6b800;
            --warning-surface: rgba(255, 209, 102, 0.08);

            --info: #118ab2;
            --info-dark: #0e6f8f;
            --info-surface: rgba(17, 138, 178, 0.08);

            --danger: #ef476f;
            --danger-dark: #d63d62;
            --danger-surface: rgba(239, 71, 111, 0.08);

            /* Background & Surface */
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --bg-tertiary: #1a1a25;
            --bg-elevated: #1e1e2a;

            /* Glass Morphism */
            --glass-bg: rgba(20, 20, 30, 0.7);
            --glass-border: rgba(255, 255, 255, 0.06);
            --glass-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            --glass-blur: blur(20px) saturate(180%);

            /* Typography */
            --text-primary: #f0f0f8;
            --text-secondary: #a0a0b8;
            --text-tertiary: #6b6b80;
            --text-disabled: #4a4a5a;

            /* Spacing System */
            --space-xs: 0.25rem;
            --space-sm: 0.5rem;
            --space-md: 1rem;
            --space-lg: 1.5rem;
            --space-xl: 2rem;
            --space-2xl: 3rem;
            --space-3xl: 4rem;
            --space-4xl: 6rem;

            /* Border Radius */
            --radius-sm: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.25rem;
            --radius-2xl: 1.5rem;
            --radius-3xl: 2rem;
            --radius-full: 9999px;

            /* Animations */
            --ease-out-expo: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-out-back: cubic-bezier(0.34, 1.56, 0.64, 1);
            --ease-in-out-circ: cubic-bezier(0.85, 0, 0.15, 1);
            --duration-fast: 150ms;
            --duration-base: 250ms;
            --duration-slow: 400ms;
            --duration-slower: 600ms;

            /* Shadows */
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.3);
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            --shadow-glow-primary: 0 0 60px rgba(0, 102, 255, 0.15);
            --shadow-glow-secondary: 0 0 60px rgba(123, 44, 191, 0.15);
        }

        /* ============================================
           GLOBAL RESET & BASE
           ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* ============================================
           HOMEPAGE CONTAINER
           ============================================ */
        .homepage {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Animated Background Gradient */
        .bg-gradient-animated {
            position: fixed;
            inset: 0;
            z-index: -2;
            background: var(--bg-primary);
        }

        .bg-gradient-animated::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(0, 102, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(123, 44, 191, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(0, 210, 255, 0.05) 0%, transparent 40%);
            animation: gradientShift 20s ease-in-out infinite;
        }

        @keyframes gradientShift {
            0%, 100% {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
            33% {
                opacity: 0.8;
                transform: scale(1.1) rotate(1deg);
            }
            66% {
                opacity: 0.9;
                transform: scale(0.95) rotate(-1deg);
            }
        }

        /* Floating Particles */
        .particles {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--accent-cyan);
            border-radius: var(--radius-full);
            opacity: 0.3;
            animation: float 15s infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            25% {
                transform: translateY(-20px) translateX(10px);
            }
            50% {
                transform: translateY(-10px) translateX(-15px);
            }
            75% {
                transform: translateY(-30px) translateX(5px);
            }
        }

        /* ============================================
           HERO SECTION
           ============================================ */
        .hero-section {
            position: relative;
            padding: var(--space-4xl) var(--space-xl);
            margin: var(--space-2xl) var(--space-xl);
            border-radius: var(--radius-3xl);
            overflow: hidden;
            isolation: isolate;
            animation: heroEnter var(--duration-slower) var(--ease-out-expo);
        }

        @keyframes heroEnter {
            0% {
                opacity: 0;
                transform: scale(0.95) translateY(30px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .hero-backdrop {
            position: absolute;
            inset: 0;
            z-index: -1;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: inherit;
            box-shadow: var(--glass-shadow), var(--shadow-glow-primary);
        }

        .hero-glow {
            position: absolute;
            inset: 0;
            z-index: -2;
            background:
                radial-gradient(circle at 30% 40%, rgba(0, 102, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 70% 60%, rgba(123, 44, 191, 0.15) 0%, transparent 50%);
            border-radius: inherit;
            animation: glowPulse 8s ease-in-out infinite;
        }

        @keyframes glowPulse {
            0%, 100% {
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
        }

        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-sm);
            padding: 0.5rem 1.25rem;
            background: rgba(0, 102, 255, 0.1);
            border: 1px solid rgba(0, 102, 255, 0.2);
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--primary-light);
            margin-bottom: var(--space-xl);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            animation: badgePulse 3s ease-in-out infinite;
        }

        @keyframes badgePulse {
            0%, 100% {
                border-color: rgba(0, 102, 255, 0.2);
                box-shadow: 0 0 20px rgba(0, 102, 255, 0.1);
            }
            50% {
                border-color: rgba(0, 102, 255, 0.4);
                box-shadow: 0 0 30px rgba(0, 102, 255, 0.2);
            }
        }

        .hero-badge i {
            font-size: 1rem;
        }

        .hero-title {
            font-size: clamp(3rem, 8vw, 5.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: var(--space-lg);
            position: relative;
        }

        .title-gradient {
            background: linear-gradient(135deg,
            var(--text-primary) 0%,
            var(--accent-cyan) 25%,
            var(--primary-light) 50%,
            var(--accent-purple) 75%,
            var(--text-primary) 100%);
            background-size: 200% 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: titleShimmer 8s linear infinite;
        }

        @keyframes titleShimmer {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 200% 50%;
            }
        }

        .hero-subtitle {
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            font-weight: 400;
            color: var(--text-secondary);
            margin-bottom: var(--space-md);
            line-height: 1.4;
        }

        .hero-description {
            font-size: 1.125rem;
            color: var(--text-tertiary);
            margin-bottom: var(--space-2xl);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-lg);
            flex-wrap: wrap;
        }

        /* Hero Buttons */
        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-md);
            padding: 1rem 2.5rem;
            border-radius: var(--radius-full);
            font-size: 1.125rem;
            font-weight: 500;
            text-decoration: none;
            transition: all var(--duration-base) var(--ease-out-expo);
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .hero-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at var(--x, 50%) var(--y, 50%), rgba(255, 255, 255, 0.15) 0%, transparent 100%);
            opacity: 0;
            transition: opacity var(--duration-base) var(--ease-out-expo);
            z-index: -1;
        }

        .hero-btn:hover::before {
            opacity: 1;
        }

        .hero-btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 8px 24px rgba(0, 102, 255, 0.3);
        }

        .hero-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 102, 255, 0.4);
        }

        .hero-btn-primary:active {
            transform: translateY(-1px);
        }

        .hero-btn-secondary {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .hero-btn-secondary:hover {
            border-color: var(--primary);
            background: rgba(0, 102, 255, 0.05);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .hero-btn-secondary:active {
            transform: translateY(-1px);
        }

        .hero-btn i {
            font-size: 1.25rem;
            transition: transform var(--duration-base) var(--ease-out-back);
        }

        .hero-btn:hover i {
            transform: translateX(4px);
        }

        .hero-btn-secondary:hover i {
            transform: translateX(4px);
        }

        /* ============================================
           FEATURES SECTION
           ============================================ */
        .features-section {
            padding: var(--space-4xl) var(--space-xl);
            position: relative;
        }

        .features-header {
            text-align: center;
            margin-bottom: var(--space-4xl);
            animation: featuresHeaderEnter var(--duration-slower) var(--ease-out-expo) 0.2s both;
        }

        @keyframes featuresHeaderEnter {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .features-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: var(--space-md);
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .features-subtitle {
            font-size: 1.125rem;
            color: var(--text-tertiary);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-2xl);
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            position: relative;
            padding: var(--space-2xl);
            border-radius: var(--radius-2xl);
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            text-align: center;
            transition: all var(--duration-slow) var(--ease-out-expo);
            animation: cardEnter var(--duration-slower) var(--ease-out-expo) calc(var(--index, 0) * 0.1s) both;
            isolation: isolate;
            overflow: hidden;
        }

        .feature-card:nth-child(1) { --index: 1; }
        .feature-card:nth-child(2) { --index: 2; }
        .feature-card:nth-child(3) { --index: 3; }

        @keyframes cardEnter {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .feature-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 0%, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            opacity: 0;
            transition: opacity var(--duration-base) var(--ease-out-expo);
            z-index: -1;
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: var(--shadow-2xl), 0 0 40px rgba(0, 102, 255, 0.1);
        }

        .feature-icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto var(--space-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-xl);
            position: relative;
            transition: all var(--duration-base) var(--ease-out-expo);
        }

        .feature-card:hover .feature-icon-wrapper {
            transform: scale(1.05);
        }

        .feature-icon-bg {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            opacity: 0.1;
            transition: opacity var(--duration-base) var(--ease-out-expo);
        }

        .feature-card:hover .feature-icon-bg {
            opacity: 0.2;
        }

        .feature-icon {
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
            transition: all var(--duration-base) var(--ease-out-back);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Icon Colors */
        .feature-card:nth-child(1) .feature-icon { color: var(--primary); }
        .feature-card:nth-child(1) .feature-icon-bg { background: var(--primary); }
        .feature-card:nth-child(1):hover { box-shadow: 0 20px 40px rgba(0, 102, 255, 0.15); }

        .feature-card:nth-child(2) .feature-icon { color: var(--warning); }
        .feature-card:nth-child(2) .feature-icon-bg { background: var(--warning); }
        .feature-card:nth-child(2):hover { box-shadow: 0 20px 40px rgba(255, 209, 102, 0.15); }

        .feature-card:nth-child(3) .feature-icon { color: var(--success); }
        .feature-card:nth-child(3) .feature-icon-bg { background: var(--success); }
        .feature-card:nth-child(3):hover { box-shadow: 0 20px 40px rgba(6, 214, 160, 0.15); }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.01em;
            margin-bottom: var(--space-md);
            color: var(--text-primary);
        }

        .feature-description {
            font-size: 1rem;
            color: var(--text-tertiary);
            line-height: 1.6;
        }

        /* ============================================
           STATS SECTION
           ============================================ */
        .stats-section {
            padding: var(--space-4xl) var(--space-xl);
            margin: var(--space-2xl) var(--space-xl);
            border-radius: var(--radius-3xl);
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .stats-backdrop {
            position: absolute;
            inset: 0;
            z-index: -1;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: inherit;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-2xl);
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .stat-item {
            animation: statEnter var(--duration-slower) var(--ease-out-expo) calc(var(--stat-index, 0) * 0.1s + 0.5s) both;
        }

        .stat-item:nth-child(1) { --stat-index: 1; }
        .stat-item:nth-child(2) { --stat-index: 2; }
        .stat-item:nth-child(3) { --stat-index: 3; }

        @keyframes statEnter {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .stat-value {
            font-size: clamp(2.5rem, 6vw, 3.5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--accent-cyan) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: var(--space-sm);
            line-height: 1;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 500;
        }

        /* ============================================
           CTA SECTION
           ============================================ */
        .cta-section {
            padding: var(--space-4xl) var(--space-xl);
            text-align: center;
            animation: ctaEnter var(--duration-slower) var(--ease-out-expo) 0.8s both;
        }

        @keyframes ctaEnter {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cta-card {
            max-width: 800px;
            margin: 0 auto;
            padding: var(--space-3xl);
            border-radius: var(--radius-3xl);
            background: linear-gradient(135deg, rgba(0, 102, 255, 0.1) 0%, rgba(123, 44, 191, 0.1) 100%);
            border: 1px solid var(--glass-border);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 50%, rgba(0, 102, 255, 0.2) 0%, transparent 50%);
            z-index: -1;
        }

        .cta-title {
            font-size: clamp(2rem, 5vw, 2.5rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: var(--space-lg);
            color: var(--text-primary);
        }

        .cta-description {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: var(--space-xl);
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-md);
            padding: 1rem 3rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            text-decoration: none;
            border-radius: var(--radius-full);
            font-size: 1.125rem;
            font-weight: 500;
            transition: all var(--duration-base) var(--ease-out-expo);
            box-shadow: 0 8px 24px rgba(0, 102, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .cta-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.1) 100%);
            opacity: 0;
            transition: opacity var(--duration-base) var(--ease-out-expo);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 102, 255, 0.4);
        }

        .cta-btn:hover::before {
            opacity: 1;
        }

        .cta-btn:active {
            transform: translateY(-1px);
        }

        .cta-btn i {
            font-size: 1.25rem;
            transition: transform var(--duration-base) var(--ease-out-back);
        }

        .cta-btn:hover i {
            transform: translateX(4px);
        }

        /* ============================================
           RESPONSIVE DESIGN
           ============================================ */
        @media (max-width: 1024px) {
            .hero-section {
                padding: var(--space-3xl) var(--space-lg);
                margin: var(--space-lg);
            }

            .features-grid {
                gap: var(--space-xl);
            }

            .feature-card {
                padding: var(--space-xl);
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: var(--space-2xl) var(--space-lg);
                margin: var(--space-md);
            }

            .hero-title {
                font-size: clamp(2.5rem, 6vw, 3.5rem);
            }

            .hero-actions {
                flex-direction: column;
                gap: var(--space-md);
            }

            .hero-btn {
                width: 100%;
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin: 0 auto;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: var(--space-xl);
            }

            .stats-section {
                margin: var(--space-lg) var(--space-md);
                padding: var(--space-2xl) var(--space-lg);
            }

            .cta-card {
                padding: var(--space-2xl);
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                padding: var(--space-xl);
            }

            .hero-badge {
                font-size: 0.75rem;
                padding: 0.375rem 1rem;
            }

            .feature-icon-wrapper {
                width: 60px;
                height: 60px;
            }

            .feature-icon {
                font-size: 2rem;
            }

            .feature-title {
                font-size: 1.25rem;
            }
        }

        /* ============================================
           UTILITY CLASSES
           ============================================ */
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        /* ============================================
           SMOOTH SCROLLING
           ============================================ */
        html {
            scroll-behavior: smooth;
        }
    </style>

    <div class="homepage">
        
        <div class="bg-gradient-animated"></div>

        
        <div class="particles">
            <?php for($i = 0; $i < 20; $i++): ?>
                <div class="particle" style="
                left: <?php echo e(rand(0, 100)); ?>%;
                top: <?php echo e(rand(0, 100)); ?>%;
                animation-delay: -<?php echo e(rand(0, 15)); ?>s;
                animation-duration: <?php echo e(rand(10, 20)); ?>s;
                opacity: <?php echo e(rand(1, 3) / 10); ?>;
            "></div>
            <?php endfor; ?>
        </div>

        
        <section class="hero-section">
            <div class="hero-backdrop"></div>
            <div class="hero-glow"></div>

            <div class="hero-content">
                <div class="hero-badge">
                    <i class="bi bi-stars"></i>
                    <span>Добро пожаловать в будущее бронирования</span>
                </div>

                <h1 class="hero-title">
                    <span class="title-gradient">Booking System</span>
                </h1>

                <p class="hero-subtitle">
                    Удобная онлайн-запись на услуги
                </p>

                <p class="hero-description">
                    Найдите специалиста или забронируйте время в несколько кликов
                </p>

                <div class="hero-actions">
                    <a class="hero-btn hero-btn-primary" href="<?php echo e(route('services.index')); ?>">
                        <i class="bi bi-search"></i>
                        <span>Найти услугу</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    <?php if(auth()->guard()->guest()): ?>
                        <a class="hero-btn hero-btn-secondary" href="<?php echo e(route('register')); ?>">
                            <i class="bi bi-person-plus"></i>
                            <span>Стать исполнителем</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        
        <section class="features-section">
            <div class="features-header">
                <h2 class="features-title">Почему выбирают нас</h2>
                <p class="features-subtitle">Современные технологии для вашего удобства</p>
            </div>

            <div class="features-grid">
                
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-bg"></div>
                        <i class="bi bi-calendar-check feature-icon"></i>
                    </div>
                    <h3 class="feature-title">Запись онлайн</h3>
                    <p class="feature-description">
                        Выбирайте удобное время и записывайтесь без звонков
                    </p>
                </div>

                
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-bg"></div>
                        <i class="bi bi-star-fill feature-icon"></i>
                    </div>
                    <h3 class="feature-title">Отзывы клиентов</h3>
                    <p class="feature-description">
                        Честные отзывы помогут выбрать лучшего специалиста
                    </p>
                </div>

                
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-bg"></div>
                        <i class="bi bi-shield-check feature-icon"></i>
                    </div>
                    <h3 class="feature-title">Надёжно и безопасно</h3>
                    <p class="feature-description">
                        Ваши данные защищены, запись подтверждается моментально
                    </p>
                </div>
            </div>
        </section>

        
        <section class="stats-section">
            <div class="stats-backdrop"></div>

            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">10K+</div>
                    <div class="stat-label">Довольных клиентов</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">500+</div>
                    <div class="stat-label">Проверенных специалистов</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">50K+</div>
                    <div class="stat-label">Успешных записей</div>
                </div>
            </div>
        </section>

        
        <section class="cta-section">
            <div class="cta-card">
                <h2 class="cta-title">Готовы начать?</h2>
                <p class="cta-description">
                    Присоединяйтесь к тысячам пользователей, которые уже пользуются нашей платформой
                </p>
                <a class="cta-btn" href="<?php echo e(route('services.index')); ?>">
                    <span>Найти услугу сейчас</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </section>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            (function() {
                'use strict';

                // ============================================
                // RIPPLE EFFECT FOR BUTTONS
                // ============================================
                function initializeRippleEffect() {
                    const buttons = document.querySelectorAll('.hero-btn, .cta-btn');

                    buttons.forEach(button => {
                        button.addEventListener('mousemove', function(e) {
                            const rect = this.getBoundingClientRect();
                            const x = ((e.clientX - rect.left) / rect.width) * 100;
                            const y = ((e.clientY - rect.top) / rect.height) * 100;
                            this.style.setProperty('--x', `${x}%`);
                            this.style.setProperty('--y', `${y}%`);
                        });

                        button.addEventListener('mouseleave', function() {
                            this.style.setProperty('--x', '50%');
                            this.style.setProperty('--y', '50%');
                        });
                    });
                }

                // ============================================
                // PARALLAX EFFECT FOR HERO SECTION
                // ============================================
                function initializeParallax() {
                    const hero = document.querySelector('.hero-section');
                    const heroGlow = document.querySelector('.hero-glow');

                    if (hero && heroGlow) {
                        hero.addEventListener('mousemove', function(e) {
                            const rect = this.getBoundingClientRect();
                            const x = (e.clientX - rect.left) / rect.width;
                            const y = (e.clientY - rect.top) / rect.height;

                            const moveX = (x - 0.5) * 20;
                            const moveY = (y - 0.5) * 20;

                            heroGlow.style.transform = `translate(${moveX}px, ${moveY}px)`;
                        });

                        hero.addEventListener('mouseleave', function() {
                            heroGlow.style.transform = 'translate(0, 0)';
                        });
                    }
                }

                // ============================================
                // INTERSECTION OBSERVER FOR ANIMATIONS
                // ============================================
                function initializeIntersectionObserver() {
                    const observerOptions = {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    };

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.animationPlayState = 'running';

                                // Добавляем класс для дополнительных анимаций
                                if (entry.target.classList.contains('feature-card')) {
                                    entry.target.style.transform = 'translateY(-8px)';
                                    setTimeout(() => {
                                        entry.target.style.transform = '';
                                    }, 300);
                                }
                            }
                        });
                    }, observerOptions);

                    // Наблюдаем за карточками функций
                    document.querySelectorAll('.feature-card').forEach(card => {
                        observer.observe(card);
                    });

                    // Наблюдаем за статистикой
                    document.querySelectorAll('.stat-item').forEach(stat => {
                        observer.observe(stat);
                    });
                }

                // ============================================
                // SMOOTH SCROLL FOR ANCHOR LINKS
                // ============================================
                function initializeSmoothScroll() {
                    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                        anchor.addEventListener('click', function(e) {
                            const href = this.getAttribute('href');
                            if (href !== '#' && href !== '#0') {
                                const target = document.querySelector(href);
                                if (target) {
                                    e.preventDefault();
                                    target.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                }
                            }
                        });
                    });
                }

                // ============================================
                // DYNAMIC PARTICLES GENERATION
                // ============================================
                function generateParticles() {
                    const particlesContainer = document.querySelector('.particles');
                    if (!particlesContainer) return;

                    const particleCount = window.innerWidth < 768 ? 10 : 20;
                    particlesContainer.innerHTML = '';

                    for (let i = 0; i < particleCount; i++) {
                        const particle = document.createElement('div');
                        particle.className = 'particle';
                        particle.style.left = `${Math.random() * 100}%`;
                        particle.style.top = `${Math.random() * 100}%`;
                        particle.style.animationDelay = `-${Math.random() * 15}s`;
                        particle.style.animationDuration = `${10 + Math.random() * 10}s`;
                        particle.style.opacity = `${0.1 + Math.random() * 0.3}`;
                        particlesContainer.appendChild(particle);
                    }
                }

                // ============================================
                // COUNTER ANIMATION FOR STATS
                // ============================================
                function animateStats() {
                    const stats = document.querySelectorAll('.stat-value');

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const target = entry.target;
                                const value = target.textContent;
                                const isK = value.includes('K');
                                const isPlus = value.includes('+');
                                const number = parseInt(value.replace(/[^0-9]/g, ''));

                                if (!isNaN(number)) {
                                    let current = 0;
                                    const increment = number / 50;
                                    const duration = 2000;
                                    const stepTime = duration / 50;

                                    const counter = setInterval(() => {
                                        current += increment;
                                        if (current >= number) {
                                            target.textContent = value;
                                            clearInterval(counter);
                                        } else {
                                            let displayValue = Math.floor(current);
                                            let suffix = '';
                                            if (isK) suffix += 'K';
                                            if (isPlus) suffix += '+';
                                            target.textContent = displayValue + suffix;
                                        }
                                    }, stepTime);
                                }

                                observer.unobserve(target);
                            }
                        });
                    }, { threshold: 0.5 });

                    stats.forEach(stat => observer.observe(stat));
                }

                // ============================================
                // INITIALIZATION
                // ============================================
                document.addEventListener('DOMContentLoaded', function() {
                    initializeRippleEffect();
                    initializeParallax();
                    initializeIntersectionObserver();
                    initializeSmoothScroll();
                    generateParticles();
                    animateStats();
                });

                // ============================================
                // RESIZE HANDLER
                // ============================================
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        generateParticles();
                    }, 250);
                });

                // ============================================
                // EXPORT FOR GLOBAL ACCESS
                // ============================================
                window.HomepageUI = {
                    initializeRippleEffect,
                    initializeParallax,
                    animateStats
                };

            })();
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\OSPanel\home\booking-system.local\resources\views/client/index.blade.php ENDPATH**/ ?>