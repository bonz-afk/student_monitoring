const openModalBtns = document.querySelectorAll('.openModalBtn');
const modals = document.querySelectorAll('.modal');

// Function to open a modal based on its ID
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

// Function to close a specific modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        // Clear input fields within the modal
        const inputFields = modal.querySelectorAll('input[type="text"]');
        inputFields.forEach((input) => {
            input.value = '';
        });
    }
}

// Add click event listeners to all 'openModalBtn' buttons
openModalBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        const modalId = btn.getAttribute('data-modal');
        if (modalId) {
            openModal(modalId);
        }
    });
});

// Close the modals if the user clicks outside of them
window.addEventListener('click', (event) => {
    modals.forEach((modal) => {
        if (event.target === modal) {
            const modalId = modal.id;
            closeModal(modalId);
        }
    });
});

// Add click event listeners to the close buttons within modals
modals.forEach((modal) => {
    const closeBtn = modal.querySelector('.closeModalBtn');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            const modalId = modal.id;
            closeModal(modalId);
        });
    }
});
