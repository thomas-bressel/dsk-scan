// ===== ONGLETS =====
function showTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}

// ===== DISK VISUAL — clic secteur → onglet Data =====
function diskSectorClick(index) {
    // Activer l'onglet Data
    const dataBtn = document.querySelector('.tab-btn[onclick*="data"]');
    showTab('data', dataBtn);

    // Sélectionner le bon secteur
    const sel = document.getElementById('sdata-select');
    if (sel) {
        sel.selectedIndex = index;
        sdataShow(index);
    }

    // Scroll vers le haut
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ===== SECTOR DATA VIEWER =====
function sdataShow(index) {
    document.querySelectorAll('.sdata-panel').forEach(p => p.classList.remove('active'));
    const panel = document.getElementById('sdata-panel-' + index);
    if (panel) panel.classList.add('active');
}

function sdataNav(dir) {
    const sel = document.getElementById('sdata-select');
    if (!sel) return;
    const next = Math.max(0, Math.min(sel.options.length - 1, sel.selectedIndex + dir));
    sel.selectedIndex = next;
    sdataShow(next);
}

// ===== DRAG & DROP UPLOAD =====
document.addEventListener('DOMContentLoaded', function () {
    const dz = document.getElementById('drop-zone');
    const fi = document.getElementById('dsk_file');
    const fn = document.getElementById('dz-file-name');

    if (!dz || !fi) return;

    fi.addEventListener('change', () => {
        fn.textContent = fi.files[0] ? '📄 ' + fi.files[0].name : '';
    });

    dz.addEventListener('dragover', e => {
        e.preventDefault();
        dz.classList.add('drag-over');
    });

    dz.addEventListener('dragleave', () => {
        dz.classList.remove('drag-over');
    });

    dz.addEventListener('drop', e => {
        e.preventDefault();
        dz.classList.remove('drag-over');
        const dt = e.dataTransfer;
        if (dt.files.length) {
            fi.files = dt.files;
            fn.textContent = '📄 ' + dt.files[0].name;
        }
    });
});
