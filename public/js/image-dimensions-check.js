document.addEventListener("DOMContentLoaded", function () {
    const fileInputs = document.querySelectorAll('input[type="file"][data-max-width], input[type="file"][data-max-height]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const files = e.target.files;
            const maxWidth = parseInt(e.target.getAttribute('data-max-width')) || Infinity;
            const maxHeight = parseInt(e.target.getAttribute('data-max-height')) || Infinity;
            let hasError = false;

            // Remove existing warnings
            const existingWarning = e.target.parentNode.querySelector('.dimension-warning');
            if (existingWarning) existingWarning.remove();

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file && file.type.startsWith('image/')) {
                    const img = new Image();
                    img.src = URL.createObjectURL(file);
                    img.onload = function() {
                        if (this.width > maxWidth || this.height > maxHeight) {
                            if (!hasError) {
                                const warning = document.createElement('div');
                                warning.className = 'dimension-warning';
                                warning.style.color = '#dc2626';
                                warning.style.fontSize = '0.85rem';
                                warning.style.marginTop = '0.5rem';
                                warning.style.fontWeight = '500';
                                warning.innerHTML = `⚠️ Warning: Recommended dimensions are ${maxWidth != Infinity ? maxWidth : 'any'}x${maxHeight != Infinity ? maxHeight : 'any'}px or smaller. Current image: ${this.width}x${this.height}px.`;
                                e.target.parentNode.appendChild(warning);
                                hasError = true;
                            }
                        }
                        URL.revokeObjectURL(this.src);
                    };
                }
            }
        });
    });
});
