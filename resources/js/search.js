function loadToolsIndex() {
    const node = document.getElementById('tools-index');
    if (!node) return [];
    try {
        return JSON.parse(node.textContent);
    } catch {
        return [];
    }
}

function renderResults(container, results, query) {
    if (!query) {
        container.innerHTML = '';
        container.classList.add('hidden');
        return;
    }

    if (results.length === 0) {
        container.innerHTML = '<p class="px-4 py-3 text-sm text-slate-500">No tools found for "' + escapeHtml(query) + '"</p>';
        container.classList.remove('hidden');
        return;
    }

    container.innerHTML = results
        .slice(0, 6)
        .map(
            (tool) =>
                `<a href="${tool.url}" class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50">
                    <span class="min-w-0">
                        <span class="block text-sm font-medium text-slate-900">${escapeHtml(tool.name)}</span>
                        <span class="block truncate text-xs text-slate-500">${escapeHtml(tool.short_description)}</span>
                    </span>
                </a>`
        )
        .join('');
    container.classList.remove('hidden');
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value;
    return div.innerHTML;
}

function filterTools(tools, query) {
    const q = query.trim().toLowerCase();
    if (!q) return [];
    return tools.filter(
        (tool) =>
            tool.name.toLowerCase().includes(q) ||
            tool.short_description.toLowerCase().includes(q) ||
            tool.category.toLowerCase().includes(q)
    );
}

export function initToolSearch() {
    const tools = loadToolsIndex();
    if (tools.length === 0) return;

    document.querySelectorAll('[data-tool-search]').forEach((wrapper) => {
        const input = wrapper.querySelector('[data-tool-search-input]');
        const results = wrapper.querySelector('[data-tool-search-results]');
        if (!input || !results) return;

        input.addEventListener('input', () => {
            renderResults(results, filterTools(tools, input.value), input.value);
        });

        input.addEventListener('focus', () => {
            if (input.value) renderResults(results, filterTools(tools, input.value), input.value);
        });

        document.addEventListener('click', (event) => {
            if (!wrapper.contains(event.target)) {
                results.classList.add('hidden');
            }
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                results.classList.add('hidden');
                input.blur();
            }
        });
    });
}
