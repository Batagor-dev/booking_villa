// Price helper functions and auto-formatter for inputs

export function formatRupiah(value, prefix = 'Rp ') {
    if (value === null || value === undefined || value === '') return prefix + '0';
    
    // Convert to number if it's a string
    let number = value;
    if (typeof value === 'string') {
        const clean = value.replace(/[^\d.-]/g, '');
        number = parseFloat(clean);
    }
    
    if (isNaN(number)) return prefix + '0';
    
    // Format using id-ID locale for Rupiah style
    const formatted = new Intl.NumberFormat('id-ID').format(Math.round(number));
    return prefix + formatted;
}

export function unformatRupiah(value) {
    if (!value) return 0;
    // Extract only digits
    const clean = value.toString().replace(/\D/g, '');
    return clean ? parseInt(clean, 10) : 0;
}

// Auto-formatting for input elements with data-price-input="true"
export function initPriceInputs() {
    document.querySelectorAll('[data-price-input="true"]').forEach((input) => {
        if (input._priceInitialized) return;
        input._priceInitialized = true;

        const formatInput = (el) => {
            const cursorPosition = el.selectionStart;
            const originalLength = el.value.length;
            const originalValue = el.value;

            // Strip everything except digits
            let cleanVal = originalValue.replace(/\D/g, '');
            if (!cleanVal) {
                el.value = '';
                return;
            }

            // Format with dots
            const formatted = new Intl.NumberFormat('id-ID').format(cleanVal);
            el.value = formatted;

            // Adjust cursor position so it doesn't jump to the end
            const newLength = el.value.length;
            const lengthDiff = newLength - originalLength;
            let newCursorPosition = cursorPosition + lengthDiff;
            
            // Ensure cursor position is valid
            if (newCursorPosition < 0) newCursorPosition = 0;
            if (newCursorPosition > newLength) newCursorPosition = newLength;

            el.setSelectionRange(newCursorPosition, newCursorPosition);
        };

        // Format initial value
        if (input.value) {
            formatInput(input);
        }

        input.addEventListener('input', (e) => {
            formatInput(e.target);
        });
    });
}

// Expose to window object for global availability (including scripts inside Blade)
window.formatRupiah = formatRupiah;
window.unformatRupiah = unformatRupiah;
window.initPriceInputs = initPriceInputs;

// Auto-run on DOM load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPriceInputs);
} else {
    initPriceInputs();
}
