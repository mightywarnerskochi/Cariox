(() => {
    const TOOLBAR =
        'undo redo | blocks | bold italic underline | ' +
        'alignleft aligncenter alignright | bullist numlist | ' +
        'link image | code';

    function initAdminTinyMCE(root = document) {
        if (typeof window.tinymce === 'undefined') {
            return;
        }

        const scope = root && root.querySelectorAll ? root : document;
        const textareas = scope.querySelectorAll('textarea.tinymce');

        textareas.forEach((textarea) => {
            if (textarea.dataset.tinymceInitialized === '1') {
                return;
            }

            if (!textarea.id) {
                textarea.id = `tinymce_${Math.random().toString(36).slice(2, 11)}`;
            }

            textarea.dataset.tinymceInitialized = '1';

            window.tinymce.init({
                selector: `#${textarea.id}`,
                height: Number(textarea.dataset.height || 300),
                menubar: false,
                license_key: 'gpl', // Enable GPLv3 (free version for self-hosted/CDN)
                promotion: false,  // Hide the "Upgrade" button
                base_url: window.TINYMCE_BASE_URL || undefined,
                suffix: '.min',
                plugins: 'lists link image table code',
                toolbar: TOOLBAR,
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initAdminTinyMCE(document);

        document.querySelectorAll('form').forEach((form) => {
            form.addEventListener('submit', () => {
                if (typeof window.tinymce !== 'undefined') {
                    window.tinymce.triggerSave();
                }
            });
        });
    });

    window.initAdminTinyMCE = initAdminTinyMCE;
})();
