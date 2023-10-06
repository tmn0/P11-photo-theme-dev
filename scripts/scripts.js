/*
setTimeout(function() {
  alert("alert after 2 seconds!");
}, 2000); // 2000 milliseconds = 2 seconds
*/

/*----FRONT PAGE BUTTONS----*/
/*----Dropdown behaviour----*/
document.addEventListener("DOMContentLoaded", function() {
    var button = document.querySelector(".home-button");
    var dropdown = document.querySelector(".home-dropdown");     

    button.addEventListener("click", function() {
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";            
        } else {
            dropdown.style.display = "block";           
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var rotateDiv = document.querySelector('.fa-caret-container');
    var rotateClick = document.querySelector('.home-button');
    let isRotated = false;

    rotateClick.addEventListener('click', () => {
        if (!isRotated) {
            rotateDiv.classList.add('rotated');
        } else {
            rotateDiv.classList.remove('rotated');
        }
        isRotated = !isRotated;
    });
    });


/*----Load more behaviour----*/
document.addEventListener('DOMContentLoaded', function () {

var loadmoreposts = {
    ajaxurl: '' /* TO DO */
};

    ( function( $ ) {
        jQuery(function ($) {
            var page = 2; // The initial page number
            var loading = false; // Track if posts are being loaded

            $('#home-load-more-button').on('click', function () {
                if (!loading) {
                    loading = true;

                    var data = {
                        action: 'load_more_posts',
                        page: page,
                    };

                    $.ajax({
                        type: 'POST',
                        dataType: 'html',
                        url: loadmoreposts.ajaxurl,
                        data: data,
                        success: function (response) {
                            $('.home-masonry-grid').append(response); // Append the new posts
                            page++; // Increment the page number
                            loading = false;
                        },
                    });
                }
            });
        });
    } )( jQuery );
});

/* document.addEventListener('DOMContentLoaded', function () {
    // Add click event handler to show content
    var buttons = document.querySelectorAll('.home-masonry-item-link');

    buttons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            var gridItem = this.closest('.home-masonry-item');
            var postID = gridItem.getAttribute('data-post-id');
            var contentElement = document.querySelector('#post-' + postID + ' .post'); // Replace '.post' with the actual content container class or ID

            // Display the content (you can customize how you want to display it)
            alert(contentElement.innerHTML); // You can replace 'alert(contentElement.innerHTML)' with any other code to display the content as desired
        });
    });
});
/*

/* Modal menu  */
// Get references to the modal and its trigger elements
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-container');
    const openModalBtn = document.getElementById('open-modal'); /*<< in navemenu*/
    const closeModalBtn = document.getElementById('close-modal');  
    
    // Function to open the modal
    function openModal() {
        modal.style.display = 'block';
        modal.classList.add('modal-open-state'); // Add the class when opening   
        /*modal.style.opacity = 1;*/     
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
        modal.classList.remove('modal-open-state'); // Remove the class when closing
        /*modal.style.opacity = 0;*/
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

