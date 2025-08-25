// Basic form validation and UI enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
    
    // Date validation for transactions
    const borrowDate = document.getElementById('borrow_date');
    const dueDate = document.getElementById('due_date');
    
    if (borrowDate && dueDate) {
        borrowDate.addEventListener('change', function() {
            const borrowDateValue = new Date(this.value);
            const minDueDate = new Date(borrowDateValue);
            minDueDate.setDate(minDueDate.getDate() + 1);
            
            dueDate.min = minDueDate.toISOString().split('T')[0];
            
            if (new Date(dueDate.value) < minDueDate) {
                dueDate.value = minDueDate.toISOString().split('T')[0];
            }
        });
    }
});