/*
setTimeout(function() {
  alert("alert after 2 seconds!");
}, 2000); // 2000 milliseconds = 2 seconds
*/

/* Modal menu  */
// Get references to the modal and its trigger elements
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('contactModal');
    const openModalBtn = document.getElementById('openModal');
    const closeModalBtn = document.getElementById('closeModal');
    const modalContent = document.getElementById('modalContent');

    // Function to open the modal
    function openModal() {
        modal.style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
    }

    // Event listener to open the modal when the "Contact" link is clicked
    openModalBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        openModal();
    });

    // Event listener to close the modal when the close button is clicked
    closeModalBtn.addEventListener('click', closeModal);

    // Close the modal if the user clicks outside of it
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});






/*
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('contact-modal-id');
    const openModalLink = document.querySelector('.contact-open-modal');
    const closeModalButton = document.getElementById('contact-close-modal');
    
    function openModal() {
        modal.style.display = 'block';
    }
    
    function closeModal() {
        modal.style.display = 'none';
    }
    
    openModalLink.addEventListener('click', openModal);    
    closeModalButton.addEventListener('click', closeModal);

    // Event listener to close the modal 
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});
*/
