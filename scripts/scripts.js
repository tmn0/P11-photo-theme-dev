/*
setTimeout(function() {
  alert("alert after 2 seconds!");
}, 2000); // 2000 milliseconds = 2 seconds
*/

/*----FRONT PAGE BUTTONS----*/
/*----Taxo Dropdown behaviour----*/
document.addEventListener("DOMContentLoaded", function() {
    var button1 = document.querySelector("#front-taxo-button1");
    var dropdown1 = document.querySelector("#front-dropdown1");  

    var button2 = document.querySelector("#front-taxo-button2");
    var dropdown2 = document.querySelector("#front-dropdown2");   

    var button3 = document.querySelector("#front-taxo-button3");
    var dropdown3 = document.querySelector("#front-dropdown3");


    button1.addEventListener("click", function() {
        toggleDropdown(dropdown1);
    });
    button2.addEventListener("click", function() {
        toggleDropdown(dropdown2);
    });
    button3.addEventListener("click", function() {
        toggleDropdown(dropdown3);
    });
        

    function toggleDropdown(dropdown) {
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            dropdown.style.display = "block";
        }
    }
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



/*----Front page Taxo button 1 categorie / Dropdown sorting----*/
document.addEventListener("DOMContentLoaded", function() {
    var dropdownOptions = document.querySelectorAll("#front-dropdown1 a"); // Select all dropdown options
    
    dropdownOptions.forEach(function(option) {
        option.addEventListener("click", function(event) {
            event.preventDefault();
            var selectedCategory = option.getAttribute("data-category");
            filterMasonryGrid(selectedCategory);

            // debugging
            console.log("Selected Category:", selectedCategory); 
            filterMasonryGrid(selectedCategory);

        });
    });

    function filterMasonryGrid(category) {
        // Get all masonry items
        var masonryItems = document.querySelectorAll(".home-masonry-item");

        masonryItems.forEach(function(item) {
            var categories = item.querySelectorAll(".category");
            var isCategoryFound = false;

            categories.forEach(function(cat) {
                if (cat.textContent.trim() === category) {
                    isCategoryFound = true;
                }
            });

            if (isCategoryFound) {
                item.style.display = "block"; // Show the item
            } else {
                item.style.display = "none"; // Hide the item                
            }
        });
    }
});



/* JQUERY IS BUGGY  */
/*
jQuery(document).ready(function($) {
    // Handle the click event on the category button
    $('#front-taxo-button1').on('click', function(e) {
        e.preventDefault();

        // Get the selected category from the button's text
        var category = $.trim($(this).find('.home-button-title').text());

        // Send an AJAX request to retrieve posts based on the selected category
        $.ajax({
            type: 'POST',
            url: custom_script_data.ajax_url,
            data: {
                action: 'filter_posts',
                category: category,
            },
            success: function(response) {
                // Update the masonry grid with the filtered posts
                $('#front-masonry').html(response);
            },
        });
    });
});
*/




/*----Front page Load more button----*/
jQuery(document).ready(function($) {
    var page = 2;

    $('#home-load-more-button').on('click', function() {
        var data = {
            action: 'load_more_posts',
            page: page
        };

        $.ajax({
            url: ajaxurl,
            data: data,
            type: 'photo',
            success: function(response) {
                // DEBUGGING Log the AJAX response to the console
                console.log('AJAX response:', response);

                // Append the new posts to the grid container
                $('.home-masonry-grid').append(response);

                page++;

                /*
                if (response === '') {
                    $('#home-load-more-button').hide();
                }
                */
            },
            // DEBUGGING
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX request failed:', errorThrown);
            }
        });
    });
});




/*----Load more behaviour test 2----*/
/*
document.addEventListener('DOMContentLoaded', function() {
    var page = 1; // Initialize the page number

    var loadMoreButton = document.getElementById('home-load-more-button');
    var masonryGrid = document.querySelector('#front-masonry .home-masonry-grid');

    loadMoreButton.addEventListener('click', function() {
        page++; // Increment the page number

        var xhr = new XMLHttpRequest();
        var data = new FormData();
        data.append('action', 'load_more_posts');
        data.append('page', page);

        xhr.open('POST', loadmoreposts.ajaxurl, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if (response) {
                    // Create a temporary container for the new posts
                    var tempDiv = document.createElement('div');
                    tempDiv.innerHTML = response;

                    // Append the new posts to the masonry grid
                    masonryGrid.appendChild(tempDiv);

                    // Remove the temporary container
                    tempDiv = null;
                } else {
                    loadMoreButton.style.display = 'none'; // Hide the button when no more posts are available
                }
            }
        };

        xhr.send(data);
    });
});
*/




/*----Load more behaviour TEST 3----
document.addEventListener('DOMContentLoaded', function () {
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
                        url: loadmoreposts.ajaxurl, // Use the ajaxurl from loadmoreposts
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
*/




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


/* Modal */
document.addEventListener('DOMContentLoaded', function () {
    let modal = document.getElementById('modal-container');
    let openModalBtn = document.getElementById('open-modal');
    let closeModalBtn = document.getElementById('close-modal');

    // Function to open the modal
    function openModal() {
        modal.style.display = 'block';
        modal.classList.add('modal-open-state'); // Add the class when opening
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
        // modal.classList.remove('modal-open-state'); // Remove the class when closing
    }

    // Event listener to open the modal when the "Open Modal" button is clicked
    openModalBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        openModal();
    });

    // Event listener to close the modal when the "Close" button is clicked
    closeModalBtn.addEventListener('click', closeModal);

    // Close the modal if the user clicks outside of it
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // MODAL AJAX TAXO DATA FETCH / SINGLE
    var singleButton = document.getElementById('single-contact-button');

    if (singleButton) {
        singleButton.addEventListener('click', function () {
            var postID = singleButton.getAttribute('data-post-id');

            var xhr = new XMLHttpRequest();

            xhr.open('POST', '/wp-admin/admin-ajax.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    // Populate the form field in modal
                    var modalReferenceField = document.getElementById('modal-reference-field');
                    if (modalReferenceField) {
                        modalReferenceField.value = response.reference;
                    }

                    // Open the modal
                    openModal();
                }
            };

            var data = 'action=get_reference_term_data&post_id=' + postID;
            xhr.send(data);
        });
    }
});


/* SINGLE MORE IMAGES BEHAVIOUR*/
/*
// Select all elements with the "dynamic-image" class
var dynamicImages = document.getElementsByClassName('dynamic-image');

// Loop through the elements and access their IDs and content
for (var i = 0; i < dynamicImages.length; i++) {
    var image = dynamicImages[i];
    var imageId = image.id; // Get the ID of the element
    var imageContent = image.innerHTML; // Get the content of the element

    // Now you can work with each dynamic image element as needed
    console.log('ID: ' + imageId);
    console.log('Content: ' + imageContent);

    // You can change content or perform other actions as required
    // image.innerHTML = 'New content for image with ID ' + imageId;
}
*/

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



// EXPAND ICON LIGHTBOX BEHAVIOUR 
/*
document.addEventListener('DOMContentLoaded', function () {

// Open / close lightox
    let lightbox = document.getElementById('lightbox');
    let openLightboxBtns = document.getElementsByClassName('single-expand-icon-container');
    let closelightboxBtn = document.getElementById('close-lightbox');

    // Function to open the modal
    function openLightbox() {
        lightbox.style.display = 'block';       
    }

    // Function to close the modal
    function closeLightbox() {
        lightbox.style.display = 'none';
        // modal.classList.remove('modal-open-state'); // Remove the class when closing
    }

    // Event listener to open the modal when the "Open Modal" buttons are clicked
    for (let i = 0; i < openLightboxBtns.length; i++) {
        openLightboxBtns[i].addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default link behavior
            openLightbox();
        });
    }

    // Event listener to close the modal when the "Close" button is clicked
    closelightboxBtn.addEventListener('click', closeLightbox);

    // Close the modal if the user clicks outside of it
    window.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });


// Lightbox function here



});
*/


// Lightbox OK
jQuery(document).ready(function($) {
    $(".single-expand-icon-container").on("click", function() {
        var postId = $(this).data("post-id");
        // Send an AJAX request to fetch the "photo" post content
        $.ajax({
            type: "POST",
            url: ajaxurl, // WordPress AJAX URL
            data: {
                action: "get_photo_content",
                post_id: postId,
            },
            success: function(response) {
                // Update the modal content with the fetched "photo" post content
                $("#photo-content-container").html(response);
                // Open the modal                

                // Open / close lightox
                let lightbox = document.getElementById('lightbox');
                let openLightboxBtns = document.getElementsByClassName('single-expand-icon-container');
                let closelightboxBtn = document.getElementById('close-lightbox');

                // Function to open the modal
                function openLightbox() {
                    lightbox.style.display = 'block';       
                }

                // Function to close the modal
                function closeLightbox() {
                    lightbox.style.display = 'none';
                    // modal.classList.remove('modal-open-state'); // Remove the class when closing
                }

                // Event listener to open the modal when the "Open Modal" buttons are clicked
                for (let i = 0; i < openLightboxBtns.length; i++) {
                    openLightboxBtns[i].addEventListener('click', function (event) {
                        event.preventDefault(); // Prevent the default link behavior
                        openLightbox();
                    });
                }

                // Event listener to close the modal when the "Close" button is clicked
                closelightboxBtn.addEventListener('click', closeLightbox);

                // Close the modal if the user clicks outside of it
                window.addEventListener('click', function (event) {
                    if (event.target === lightbox) {
                        closeLightbox();
                    }
                });
            }
        });
    });
});


