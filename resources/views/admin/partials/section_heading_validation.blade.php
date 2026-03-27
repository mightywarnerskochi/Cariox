<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sectionForms = document.querySelectorAll('.section-form');
        
        sectionForms.forEach(form => {
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
            
            inputs.forEach(input => {
                const errorSpan = document.getElementById('error-' + input.name);
                
                const validate = (options = {}) => {
                    const isEmpty = !input.value.trim();
                    const shouldShow = isEmpty && (options.force || input.dataset.failed === 'true');
                    
                    if (shouldShow) {
                        input.style.borderColor = '#ef4444';
                        if (errorSpan) errorSpan.classList.add('d-block');
                        if (options.force) input.dataset.failed = 'true';
                    } else if (!isEmpty) {
                        input.style.borderColor = '';
                        if (errorSpan) errorSpan.classList.remove('d-block');
                        input.dataset.failed = 'false';
                    } else if (isEmpty && !options.force && input.dataset.failed !== 'true') {
                        // Keep it hidden if user is just typing/clearing and hasn't failed a submit yet
                        if (errorSpan) errorSpan.classList.remove('d-block');
                        input.style.borderColor = '';
                    }
                    return !isEmpty;
                };

                input.addEventListener('input', () => {
                    validate();
                });
                
                input.addEventListener('blur', () => {
                    validate();
                });

                // Initial clear
                validate();
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                let firstInvalid = null;

                inputs.forEach(input => {
                    const errorSpan = document.getElementById('error-' + input.name);
                    const isEmpty = !input.value.trim();
                    
                    if (isEmpty) {
                        isValid = false;
                        input.style.borderColor = '#ef4444';
                        if (errorSpan) errorSpan.classList.add('d-block');
                        input.dataset.failed = 'true';
                        if (!firstInvalid) firstInvalid = input;
                    } else {
                        input.style.borderColor = '';
                        if (errorSpan) errorSpan.classList.remove('d-block');
                        input.dataset.failed = 'false';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    if (firstInvalid) {
                        firstInvalid.focus();
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    });
</script>
