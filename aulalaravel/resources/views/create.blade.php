@extends('layouts.app')

@section('title', 'Novo Produto | NexusStock Pro')

@section('styles')
<style>
    .form-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        align-items: start;
    }

    @media (min-width: 992px) {
        .form-layout {
            grid-template-columns: 1.25fr 0.95fr;
        }
    }

    .card-panel {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-xl);
        padding: 2rem 2.25rem;
        backdrop-filter: blur(16px);
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.3);
    }

    .form-header {
        margin-bottom: 2rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--border-subtle);
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--text-main);
    }

    .form-desc {
        color: var(--text-muted);
        font-size: 0.88rem;
        margin-top: 0.25rem;
    }

    /* Form Fields */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #cbd5e1;
        margin-bottom: 0.5rem;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1.15rem;
        color: var(--text-dim);
        font-size: 0.95rem;
        pointer-events: none;
        transition: var(--transition);
    }

    .form-control {
        width: 100%;
        background: rgba(9, 13, 22, 0.7);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-md);
        padding: 0.85rem 1.15rem 0.85rem 2.9rem;
        color: var(--text-main);
        font-size: 0.95rem;
        outline: none;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary);
        background: rgba(9, 13, 22, 0.95);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
    }

    .form-control:focus + .input-icon,
    .input-wrapper:focus-within .input-icon {
        color: var(--primary);
    }

    select.form-control {
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    .select-arrow {
        position: absolute;
        right: 1.15rem;
        color: var(--text-dim);
        pointer-events: none;
        font-size: 0.8rem;
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .error-feedback {
        color: var(--accent-rose);
        font-size: 0.8rem;
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-subtle);
    }

    /* Live Preview Card */
    .preview-sticky {
        position: sticky;
        top: 6rem;
    }

    .preview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .preview-badge {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
        padding: 0.25rem 0.65rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .pulse-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #34d399;
        box-shadow: 0 0 8px #34d399;
        animation: pulseDot 1.8s infinite;
    }

    @keyframes pulseDot {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.4); }
        100% { opacity: 1; transform: scale(1); }
    }

    .product-preview-card {
        background: linear-gradient(145deg, #141b2d, #0f1424);
        border: 1px solid rgba(99, 102, 241, 0.25);
        border-radius: var(--radius-lg);
        padding: 1.75rem;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
    }

    .preview-avatar-banner {
        height: 100px;
        border-radius: var(--radius-md);
        background: linear-gradient(135deg, #4338ca, #6366f1, #a855f7);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 2.5rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }

    .preview-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.35rem;
    }

    .preview-cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        background: rgba(139, 92, 246, 0.2);
        color: #c084fc;
        margin-bottom: 1.25rem;
    }

    .preview-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-subtle);
    }

    .preview-stat-label {
        font-size: 0.75rem;
        color: var(--text-dim);
        text-transform: uppercase;
        font-weight: 600;
    }

    .preview-stat-value {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-main);
        margin-top: 0.15rem;
    }
</style>
@endsection

@section('content')

    <!-- Breadcrumb / Back -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('produtos.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: var(--transition);" onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='#94a3b8'">
            <i class="fa-solid fa-arrow-left"></i> Voltar para o catálogo de produtos
        </a>
    </div>

    @if ($errors->any())
        <div style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.3); border-radius: var(--radius-md); padding: 1rem 1.25rem; color: #fca5a5; margin-bottom: 1.75rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-circle-exclamation"></i> Ops! Corrija os seguintes campos:
            </div>
            <ul style="margin-left: 1.5rem; font-size: 0.88rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-layout">
        
        <!-- Left: Product Form Panel -->
        <div class="card-panel">
            <div class="form-header">
                <h1 class="form-title">Cadastrar Novo Produto</h1>
                <p class="form-desc">Preencha as especificações técnicas, estoque e categoria correspondente.</p>
            </div>

            <form action="{{ route('produtos.store') }}" method="POST" id="createProductForm">
                @csrf

                <!-- Nome do Produto -->
                <div class="form-group">
                    <label for="nome" class="form-label">Nome do Produto</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-box input-icon"></i>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Notebook Dell XPS 15" value="{{ old('nome') }}" required autocomplete="off">
                    </div>
                </div>

                <!-- Preço & Quantidade em 2 Colunas -->
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="preco" class="form-label">Preço Unitário (R$)</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-brazilian-real-sign input-icon"></i>
                            <input type="number" step="0.01" min="0" id="preco" name="preco" class="form-control" placeholder="0,00" value="{{ old('preco') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantidade" class="form-label">Quantidade em Estoque</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-layer-group input-icon"></i>
                            <input type="number" min="0" id="quantidade" name="quantidade" class="form-control" placeholder="0" value="{{ old('quantidade') }}" required>
                        </div>
                    </div>
                </div>

                <!-- Categoria -->
                <div class="form-group">
                    <label for="categoria_id" class="form-label">Categoria do Produto</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-tags input-icon"></i>
                        @if(isset($categorias) && $categorias->count() > 0)
                            <select name="categoria_id" id="categoria_id" class="form-control" required>
                                <option value="" disabled selected>Selecione uma categoria...</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" data-name="{{ $categoria->nome }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nome }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down select-arrow"></i>
                        @else
                            <input type="number" name="categoria_id" id="categoria_id" class="form-control" placeholder="ID da Categoria (Ex: 1)" value="{{ old('categoria_id') }}" required>
                        @endif
                    </div>
                </div>

                <!-- Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" style="padding: 0.85rem 2rem; font-size: 0.95rem;">
                        <i class="fa-solid fa-floppy-disk"></i> Salvar Produto
                    </button>
                    <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Right: Live Preview Panel -->
        <div class="preview-sticky">
            <div class="preview-header">
                <span style="font-size: 0.88rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Visualização em Tempo Real</span>
                <span class="preview-badge">
                    <span class="pulse-dot"></span> Live Preview
                </span>
            </div>

            <div class="product-preview-card">
                <div class="preview-avatar-banner">
                    <i class="fa-solid fa-cube" id="previewIcon"></i>
                </div>

                <div class="preview-name" id="previewName">Novo Produto</div>
                
                <div class="preview-cat-badge">
                    <i class="fa-solid fa-tag" style="font-size: 0.65rem;"></i>
                    <span id="previewCategory">Categoria Não Selecionada</span>
                </div>

                <div class="preview-details-grid">
                    <div>
                        <div class="preview-stat-label">Preço Unitário</div>
                        <div class="preview-stat-value" style="color: #818cf8;" id="previewPrice">R$ 0,00</div>
                    </div>
                    <div>
                        <div class="preview-stat-label">Qtd. Estoque</div>
                        <div class="preview-stat-value" id="previewQuantity">0 un.</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
<script>
    // Live Preview Synchronization
    const nomeInput = document.getElementById('nome');
    const precoInput = document.getElementById('preco');
    const qtdInput = document.getElementById('quantidade');
    const catSelect = document.getElementById('categoria_id');

    const previewName = document.getElementById('previewName');
    const previewPrice = document.getElementById('previewPrice');
    const previewQuantity = document.getElementById('previewQuantity');
    const previewCategory = document.getElementById('previewCategory');

    function updatePreview() {
        // Name
        if (nomeInput && nomeInput.value.trim() !== '') {
            previewName.textContent = nomeInput.value;
        } else {
            previewName.textContent = 'Novo Produto';
        }

        // Price
        if (precoInput && precoInput.value !== '') {
            const val = parseFloat(precoInput.value) || 0;
            previewPrice.textContent = 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        } else {
            previewPrice.textContent = 'R$ 0,00';
        }

        // Quantity
        if (qtdInput && qtdInput.value !== '') {
            previewQuantity.textContent = qtdInput.value + ' un.';
        } else {
            previewQuantity.textContent = '0 un.';
        }

        // Category
        if (catSelect) {
            if (catSelect.tagName === 'SELECT') {
                const selectedOption = catSelect.options[catSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    previewCategory.textContent = selectedOption.getAttribute('data-name') || selectedOption.text;
                } else {
                    previewCategory.textContent = 'Categoria Não Selecionada';
                }
            } else {
                previewCategory.textContent = catSelect.value ? 'Categoria #' + catSelect.value : 'Categoria Não Selecionada';
            }
        }
    }

    if (nomeInput) nomeInput.addEventListener('input', updatePreview);
    if (precoInput) precoInput.addEventListener('input', updatePreview);
    if (qtdInput) qtdInput.addEventListener('input', updatePreview);
    if (catSelect) catSelect.addEventListener('change', updatePreview);
    if (catSelect && catSelect.tagName === 'INPUT') catSelect.addEventListener('input', updatePreview);

    // Initial update if fields have old values
    updatePreview();
</script>
@endsection