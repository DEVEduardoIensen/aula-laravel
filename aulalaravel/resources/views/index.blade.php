@extends('layouts.app')

@section('title', 'Produtos & Estoque | NexusStock Pro')

@section('styles')
<style>
    /* Hero Header */
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }

    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    .page-title {
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        background: linear-gradient(135deg, #ffffff 30%, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    /* KPI Metrics Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2.25rem;
    }

    .metric-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 1.35rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        backdrop-filter: blur(12px);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--card-accent, var(--primary)), transparent);
        opacity: 0;
        transition: var(--transition);
    }

    .metric-card:hover {
        transform: translateY(-4px);
        border-color: var(--border-hover);
        box-shadow: var(--shadow-subtle);
    }

    .metric-card:hover::before {
        opacity: 1;
    }

    .metric-icon-box {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .metric-info {
        display: flex;
        flex-direction: column;
    }

    .metric-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        font-weight: 600;
    }

    .metric-value {
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.02em;
        margin-top: 0.2rem;
    }

    /* Toolbar / Search & Filter */
    .table-toolbar {
        background: var(--bg-surface);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    @media (min-width: 992px) {
        .table-toolbar {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    .toolbar-left {
        display: flex;
        gap: 1rem;
        flex: 1;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
        flex: 1;
        min-width: 250px;
        max-width: 420px;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-dim);
        font-size: 0.9rem;
    }

    .search-input {
        width: 100%;
        background: rgba(9, 13, 22, 0.6);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-md);
        padding: 0.7rem 1rem 0.7rem 2.6rem;
        color: var(--text-main);
        font-size: 0.9rem;
        outline: none;
        transition: var(--transition);
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .search-input::placeholder {
        color: var(--text-dim);
    }

    .select-sort {
        background: rgba(9, 13, 22, 0.7);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-md);
        padding: 0.68rem 1rem;
        color: var(--text-main);
        font-size: 0.88rem;
        cursor: pointer;
        outline: none;
        transition: var(--transition);
    }

    .select-sort:focus {
        border-color: var(--primary);
    }

    .results-count {
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 500;
        white-space: nowrap;
    }

    /* Table Container */
    .table-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-top: none;
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        overflow: hidden;
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: rgba(17, 23, 38, 0.9);
        color: var(--text-dim);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-subtle);
    }

    .custom-table td {
        padding: 1.15rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        font-size: 0.92rem;
        vertical-align: middle;
        transition: var(--transition);
    }

    .custom-table tr:hover td {
        background: rgba(99, 102, 241, 0.04);
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    /* Product Avatar */
    .product-meta {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .product-avatar {
        width: 42px;
        height: 42px;
        border-radius: var(--radius-sm);
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.2));
        border: 1px solid rgba(99, 102, 241, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #818cf8;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .product-name {
        font-weight: 700;
        color: var(--text-main);
        display: block;
    }

    .product-sku {
        font-size: 0.75rem;
        color: var(--text-dim);
    }

    /* Category Pill */
    .badge-category {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.78rem;
        font-weight: 600;
        background: rgba(139, 92, 246, 0.15);
        color: #c084fc;
        border: 1px solid rgba(139, 92, 246, 0.3);
    }

    /* Stock Badge */
    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.3rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.8rem;
        font-weight: 600;
    }

    .stock-in {
        background: rgba(16, 185, 129, 0.12);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.25);
    }

    .stock-low {
        background: rgba(245, 158, 11, 0.12);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }

    .stock-out {
        background: rgba(244, 63, 94, 0.12);
        color: #fb7185;
        border: 1px solid rgba(244, 63, 94, 0.25);
    }

    .price-tag {
        font-weight: 700;
        color: #f8fafc;
        font-family: monospace;
        font-size: 0.98rem;
    }

    .total-col {
        color: #10b981;
        font-weight: 700;
        font-family: monospace;
    }

    /* Delete Button */
    .btn-delete {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        background: rgba(244, 63, 94, 0.1);
        border: 1px solid rgba(244, 63, 94, 0.25);
        color: #fb7185;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.88rem;
    }

    .btn-delete:hover {
        background: #f43f5e;
        color: #ffffff;
        border-color: #f43f5e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(244, 63, 94, 0.35);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4.5rem 1.5rem;
    }

    .empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.2);
        color: #818cf8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.85rem;
        margin-bottom: 1.25rem;
    }

    .empty-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: var(--text-muted);
        font-size: 0.9rem;
        max-width: 400px;
        margin: 0 auto 1.5rem auto;
    }
</style>
@endsection

@section('content')

    <!-- Dashboard Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Catálogo & Controle de Estoque</h1>
            <p class="page-subtitle">Acompanhe preços, categorias e níveis de produtos em tempo real.</p>
        </div>
        <div>
            <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Novo Produto
            </a>
        </div>
    </div>

    <!-- KPIs Metrics Grid -->
    @php
        $totalProdutos = $produtos->count();
        $totalItens = $produtos->sum('quantidade');
        $valorEstoque = $produtos->sum(function($p) { return $p->preco * $p->quantidade; });
        $totalCategorias = $produtos->pluck('categoria_id')->unique()->count();
    @endphp

    <div class="metrics-grid">
        <!-- Total Produtos -->
        <div class="metric-card" style="--card-accent: #6366f1;">
            <div class="metric-icon-box" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div class="metric-info">
                <span class="metric-label">Produtos Cadastrados</span>
                <span class="metric-value">{{ $totalProdutos }}</span>
            </div>
        </div>

        <!-- Valor Total Estoque -->
        <div class="metric-card" style="--card-accent: #10b981;">
            <div class="metric-icon-box" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <div class="metric-info">
                <span class="metric-label">Valor Total Estoque</span>
                <span class="metric-value">R$ {{ number_format($valorEstoque, 2, ',', '.') }}</span>
            </div>
        </div>

        <!-- Unidades em Estoque -->
        <div class="metric-card" style="--card-accent: #8b5cf6;">
            <div class="metric-icon-box" style="background: rgba(139, 92, 246, 0.15); color: #c084fc;">
                <i class="fa-solid fa-cubes"></i>
            </div>
            <div class="metric-info">
                <span class="metric-label">Total de Unidades</span>
                <span class="metric-value">{{ $totalItens }} un.</span>
            </div>
        </div>

        <!-- Categorias Ativas -->
        <div class="metric-card" style="--card-accent: #ec4899;">
            <div class="metric-icon-box" style="background: rgba(236, 72, 153, 0.15); color: #f472b6;">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div class="metric-info">
                <span class="metric-label">Categorias Ativas</span>
                <span class="metric-value">{{ $totalCategorias }}</span>
            </div>
        </div>
    </div>

    <!-- Table Toolbar with Live Search & Sorting -->
    <div class="table-toolbar">
        <div class="toolbar-left">
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" id="liveSearch" class="search-input" placeholder="Buscar por produto ou categoria...">
            </div>

            <!-- Seletor de Ordenação -->
            <form method="GET" action="{{ route('produtos.index') }}" style="display: flex; align-items: center; gap: 0.5rem;">
                <label for="ordemSelect" style="font-size: 0.82rem; color: var(--text-muted); font-weight: 600; white-space: nowrap;">
                    <i class="fa-solid fa-arrow-down-short-wide"></i> Ordem:
                </label>
                <select name="ordem" id="ordemSelect" class="select-sort" onchange="this.form.submit()">
                    <option value="mais_antigos" {{ request('ordem') == 'mais_antigos' || !request('ordem') ? 'selected' : '' }}>
                        Mais Antigos primeiro (Novos por último)
                    </option>
                    <option value="mais_novos" {{ request('ordem') == 'mais_novos' ? 'selected' : '' }}>
                        Mais Novos primeiro (Topo)
                    </option>
                    <option value="nome_asc" {{ request('ordem') == 'nome_asc' ? 'selected' : '' }}>
                        Nome (A - Z)
                    </option>
                    <option value="menor_preco" {{ request('ordem') == 'menor_preco' ? 'selected' : '' }}>
                        Menor Preço
                    </option>
                    <option value="maior_preco" {{ request('ordem') == 'maior_preco' ? 'selected' : '' }}>
                        Maior Preço
                    </option>
                    <option value="maior_estoque" {{ request('ordem') == 'maior_estoque' ? 'selected' : '' }}>
                        Maior Estoque
                    </option>
                </select>
            </form>
        </div>

        <div class="results-count">
            Mostrando <span id="visibleCount">{{ $totalProdutos }}</span> de {{ $totalProdutos }} produtos
        </div>
    </div>

    <!-- Table of Products -->
    <div class="table-card">
        @if($produtos->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="empty-title">Nenhum produto cadastrado</h3>
                <p class="empty-text">Seu catálogo está vazio no momento. Comece cadastrando o primeiro item para gerenciar seu estoque.</p>
                <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Cadastrar Primeiro Produto
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="custom-table" id="produtosTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Preço Unitário</th>
                            <th>Qtd. Estoque</th>
                            <th>Status</th>
                            <th>Subtotal</th>
                            <th style="text-align: center; width: 80px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produtos as $produto)
                            @php
                                $statusClass = 'stock-in';
                                $statusText = 'Em Estoque';
                                $statusIcon = 'fa-check';

                                if ($produto->quantidade <= 0) {
                                    $statusClass = 'stock-out';
                                    $statusText = 'Esgotado';
                                    $statusIcon = 'fa-xmark';
                                } elseif ($produto->quantidade <= 2) {
                                    $statusClass = 'stock-low';
                                    $statusText = 'Estoque Baixo';
                                    $statusIcon = 'fa-triangle-exclamation';
                                }
                            @endphp
                            <tr class="product-row" data-name="{{ strtolower($produto->nome) }}" data-category="{{ strtolower($produto->categoria->nome ?? '') }}">
                                <td style="color: var(--text-dim); font-family: monospace; font-size: 0.85rem; font-weight: 700;">#{{ $loop->iteration }}</td>
                                <td>
                                    <div class="product-meta">
                                        <div class="product-avatar">
                                            {{ strtoupper(substr($produto->nome, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="product-name">{{ $produto->nome }}</span>
                                            <span class="product-sku">Cadastrado em {{ $produto->created_at ? $produto->created_at->format('d/m/Y H:i') : 'Recente' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-category">
                                        <i class="fa-solid fa-tag" style="font-size: 0.7rem;"></i>
                                        {{ $produto->categoria->nome ?? 'Sem Categoria' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="price-tag">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                                </td>
                                <td>
                                    <strong style="color: var(--text-main); font-size: 1rem;">{{ $produto->quantidade }}</strong> <span style="color: var(--text-dim); font-size: 0.8rem;">un.</span>
                                </td>
                                <td>
                                    <span class="stock-badge {{ $statusClass }}">
                                        <i class="fa-solid {{ $statusIcon }}" style="font-size: 0.7rem;"></i>
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>
                                    <span class="total-col">
                                        R$ {{ number_format($produto->preco * $produto->quantidade, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir o produto &quot;{{ $produto->nome }}&quot;? Esta ação não pode ser desfeita.');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Excluir {{ $produto->nome }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div id="noResults" class="empty-state" style="display: none; padding: 3rem 1.5rem;">
                <div class="empty-icon" style="width: 56px; height: 56px; font-size: 1.3rem;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.35rem;">Nenhum produto encontrado</h4>
                <p style="color: var(--text-muted); font-size: 0.88rem;">Tente ajustar sua busca por outro termo ou nome de categoria.</p>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
<script>
    // Live Search Filter
    const searchInput = document.getElementById('liveSearch');
    const rows = document.querySelectorAll('.product-row');
    const visibleCountSpan = document.getElementById('visibleCount');
    const noResultsDiv = document.getElementById('noResults');
    const tableElement = document.getElementById('produtosTable');

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const category = row.getAttribute('data-category') || '';

                if (name.includes(query) || category.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (visibleCountSpan) {
                visibleCountSpan.textContent = visibleCount;
            }

            if (noResultsDiv) {
                if (visibleCount === 0 && rows.length > 0) {
                    noResultsDiv.style.display = 'block';
                    if (tableElement) tableElement.style.display = 'none';
                } else {
                    noResultsDiv.style.display = 'none';
                    if (tableElement) tableElement.style.display = 'table';
                }
            }
        });
    }
</script>
@endsection