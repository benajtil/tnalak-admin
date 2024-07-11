function validateForm() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('error-message');

    if (username === '' || password === '') {
        errorMessage.textContent = 'Both fields are required';
        errorMessage.style.display = 'block';
        return false;
    }
    errorMessage.style.display = 'none';
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    const errorMessage = document.getElementById('error-message');
    if (errorMessage.textContent !== '') {
        errorMessage.style.display = 'block';
    }
});
