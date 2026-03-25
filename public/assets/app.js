// ===== ONGLETS =====
function showTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
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
