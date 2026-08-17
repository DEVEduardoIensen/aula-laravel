<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestão de Estoque Pro')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-body: #090d16;
            --bg-surface: #111726;
            --bg-surface-elevated: #1a2236;
            --bg-card: rgba(23, 31, 51, 0.7);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(99, 102, 241, 0.4);
            
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-glow: rgba(99, 102, 241, 0.35);
            --accent-purple: #8b5cf6;
            --accent-pink: #ec4899;
            --accent-emerald: #10b981;
            --accent-amber: #f59e0b;
            --accent-rose: #f43f5e;
            
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-dim: #64748b;
            
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            
            --shadow-subtle: 0 4px 20px rgba(0, 0, 0, 0.25);
            --shadow-glow: 0 8px 30px rgba(99, 102, 241, 0.25);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(139, 92, 246, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(16, 185, 129, 0.08) 0px, transparent 50%);
            background-attachment: fixed;
        }

        /* Top Navigation */
        .navbar {
            background: rgba(17, 23, 38, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 1rem 0;
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--primary), var(--accent-purple));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .brand-badge {
            font-size: 0.65rem;
            font-weight: 700;
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            padding: 2px 8px;
            border-radius: 9999px;
            border: 1px solid rgba(99, 102, 241, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-left: 4px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.7rem 1.35rem;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff;
            box-shadow: 0 4px 18px var(--primary-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.45);
            background: linear-gradient(135deg, #4f46e5, #4338ca);
        }

        .btn-secondary {
            background: var(--bg-surface-elevated);
            color: var(--text-main);
            border: 1px solid var(--border-subtle);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Flash Message Alert */
        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            backdrop-filter: blur(10px);
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Main Content wrapper */
        .main-wrapper {
            flex: 1;
            padding: 2.5rem 0;
        }

        /* Footer */
        .footer {
            border-top: 1px solid var(--border-subtle);
            padding: 2rem 0;
            text-align: center;
            color: var(--text-dim);
            font-size: 0.85rem;
            margin-top: auto;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }
        ::-webkit-scrollbar-thumb {
            background: #252f48;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #374465;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sticky Navigation -->
    <header class="navbar">
        <div class="container nav-content">
            <a href="{{ route('produtos.index') }}" class="brand-logo">
                <div class="brand-icon">
                    <i class="fa-solid fa-cube"></i>
                </div>
                <span>Nexus<span style="background: linear-gradient(135deg, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Stock</span></span>
                <span class="brand-badge">Enterprise</span>
            </a>

            <div class="nav-actions">
                <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-list-check"></i> Produtos
                </a>
                <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Novo Produto
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="main-wrapper">
        <div class="container">
            @if(session('success'))
                <div class="alert-success">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #6ee7b7; cursor: pointer; font-size: 1rem;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>© {{ date('Y') }} NexusStock Pro • Sistema de Alta Performance em Laravel</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
