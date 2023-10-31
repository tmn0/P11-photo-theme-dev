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
            filterMasonryGridCategory(selectedCategory);

            // debugging
            console.log("Selected Category:", selectedCategory); 
            filterMasonryGridCategory(selectedCategory);

        });
    });

    function filterMasonryGridCategory(category) {
        // Get all masonry items
        var masonryItems = document.querySelectorAll(".home-masonry-item");

        masonryItems.forEach(function(item) {
            var categories = item.querySelectorAll(".category");
            var isCategoryFound = false;

            categories.forEach(function(cat) {
                if (cat.textContent.trim() === category) {
                    isCategoryFound = true;
                }
                console.log("categories", category); 
                console.log("categories", isCategoryFound); 
            });

            if (isCategoryFound) {
                item.style.display = "block"; // Show the item
            } else {
                item.style.display = "none"; // Hide the item                
            }
        });
    }
});

/*----Front page Taxo button 2 categorie / Dropdown sorting----*/
document.addEventListener("DOMContentLoaded", function() {
    var dropdownOptionsFormat = document.querySelectorAll("#front-dropdown2 a"); // Select all dropdown options

    dropdownOptionsFormat.forEach(function(option) {
        option.addEventListener("click", function(event) {
            event.preventDefault();
            var selectedFormat = option.getAttribute("data-format");
            filterMasonryGridFormat(selectedFormat);

            // debugging
            console.log("Selected Format", selectedFormat);
            console.log("filterMasonryGridFormat", selectedFormat);

        });
    });

    function filterMasonryGridFormat(format) {
        // Get all masonry items
        var masonryItemsFormat = document.querySelectorAll(".home-masonry-item");

        masonryItemsFormat.forEach(function(item) {
            var formats = item.getAttribute("data-format"); // Change .querySelectorAll to .getAttribute
            var isFormatFound = false;

            if (formats && formats.trim() === format) { // Check if format matches
                isFormatFound = true;
            }
            //debug
            console.log("Is format found?", isFormatFound);
            console.log("Selected Format:", format);

            if (isFormatFound) {
                item.style.display = "block"; // Show the item
            } else {
                item.style.display = "none"; // Hide the item
            }
        });
    }
});




/* Front page Taxo button 3 sorting by date */
document.addEventListener("DOMContentLoaded", function() {
    var dropdownOptions = document.querySelectorAll("#front-dropdown3 a"); // Select all dropdown options

    dropdownOptions.forEach(function(option) {
        option.addEventListener("click", function(event) {
            event.preventDefault();
            var sortOrder = option.textContent.trim();
            filterMasonryGridByDate(sortOrder);

            // debugging
            console.log("Sort Order:", sortOrder);
            filterMasonryGridByDate(sortOrder);
        });
    });

    function filterMasonryGridByDate(sortOrder) {
        // Get all masonry items
        var masonryItems = document.querySelectorAll(".home-masonry-item");

        var sortedItems = Array.from(masonryItems);

        sortedItems.sort(function(a, b) {
            var dateA = new Date(a.getAttribute("data-post-date"));
            var dateB = new Date(b.getAttribute("data-post-date"));

            if (sortOrder === "Les plus récentes") {
                return dateB - dateA; // Sort by descending order
            } else if (sortOrder === "Les plus anciennes") {
                return dateA - dateB; // Sort by ascending order
            }
        });

        // Reorder the masonry grid based on the sorted items
        var gridContainer = document.querySelector(".home-masonry-grid");
        gridContainer.innerHTML = ""; // Clear the grid

        sortedItems.forEach(function(item) {
            gridContainer.appendChild(item);
        });
    }
});



// ---- Front page Load more button ----
jQuery(document).ready(function($) {
    var page = 1;
    var loading = false;
    var $loadMoreButton = $('#home-load-more-button');
    var $masonryGrid = $('#front-masonry .home-masonry-grid');

    $loadMoreButton.on('click', function() {
        if (!loading) {
            loading = true;
            page++;
            /*
            $loadMoreButton.text('Chargement en cours...');
            */

            // Define the ajaxurl variable correctly
            var ajaxurl = photo_ajax.ajax_url;

            $.ajax({
                type: 'POST',
                url: ajaxurl, // Use the AJAX URL defined by wp_localize_script
                data: {
                    action: 'load_more_photos',
                    page: page,
                },
                success: function(response) {
                    if (response) {
                        $masonryGrid.append(response);
                        loading = false;
                        /*
                        $loadMoreButton.text('Charger plus');
                        */
                    } else {
                        /*
                        $loadMoreButton.text('Fin de chargement');
                        $loadMoreButton.attr('disabled', true);
                        */
                    }
                },
            });
        }
    });
});




// ---- Contact Modal ----
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



// ----- Single Scetion 2 mini image -----

document.addEventListener("DOMContentLoaded", function() {

    // Get references to the buttons and the mini-image container
    const arrowLeft = document.getElementById('arrow-left');
    const arrowRight = document.getElementById('arrow-right');
    const miniImageContainer = document.querySelector('.single-contact-shortcut-nav-img');

    // Define a function to update the mini-image content
    function updateMiniImage(postID) {
        // You may want to load the content from the server using AJAX
        // Here, I'm assuming you have already fetched the content and stored it in a variable
        const content = getMiniImageContent(postID);

        if (content) {
            miniImageContainer.innerHTML = content;
        } else {
            miniImageContainer.innerHTML = "";
        }
    }

    // Define a function to get the content for a post
    function getMiniImageContent(postID) {
        // You should implement the logic to get the content based on postID
        // You can fetch it from an array or an API call
        // For example, return the content from an array
        const postContent = miniImageContentArray[postID];
        return postContent || '';
    }

    // Initialize nextPostID and prevPostID with the appropriate values
    let nextPostID = ''; // Initialize with the ID of the next post
    let prevPostID = ''; // Initialize with the ID of the previous post

    // Assuming you have an array of mini-image content
    // You should populate this array when you fetch the content for each post
    const miniImageContentArray = {};

    // Attach a click event listener to the left arrow button
    arrowLeft.addEventListener('click', function() {
        // Update the mini-image content based on the previous post ID
        updateMiniImage(prevPostID);
    });

    // Attach a click event listener to the right arrow button
    arrowRight.addEventListener('click', function() {
        // Update the mini-image content based on the next post ID
        updateMiniImage(nextPostID);
    });

});




//---- Single Scetion 2  navigation arrows

jQuery(document).ready(function($) {
    var currentIndex = 0; // Initialize the current index

    // Function to load content based on the current index
    function loadContent() {
        var postId = postIds[currentIndex];
        var data = {
            action: 'load_post_content',
            post_id: postId,
        };

        // Send an AJAX request to fetch post content
        $.post(ajaxurl, data, function(response) {
            // Update the content of the div
            $('.single-contact-shortcut-nav-img').html(response);
        });
    }

    // Click handler for the left button
    $('#arrow-left').on('click', function() {
        currentIndex = (currentIndex - 1 + postIds.length) % postIds.length;
        loadContent();
    });

    // Click handler for the right button
    $('#arrow-right').on('click', function() {
        currentIndex = (currentIndex + 1) % postIds.length;
        loadContent();
    });
});




// ----- Lightbox Script -----
jQuery(document).ready(function($) {
    $(".expand-icon-container").on("click", function() {
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
                let openLightboxBtns = document.getElementsByClassName('expand-icon-container');
                let closelightboxBtn = document.getElementById('close-lightbox');

                // Function to open the modal
                function openLightbox() {
                    lightbox.style.display = 'block';       
                }

                // Function to close the modal
                function closeLightbox() {
                    lightbox.style.display = 'none';
                    
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

    /*
    // Function to clear the modal content
    function clearModalContent() {
        $("#photo-content-container").html(""); // Empty the content container
    }

    // Attach an event listener to the modal close button
    $("#close-lightbox").on("click", function() {
        // Clear the modal content when the close button is clicked
        clearModalContent();
        // Close the modal (you can add your modal close logic here)
    });
    */
    
});



//---- Single Load More Button----
jQuery(document).ready(function ($) {
    $('#load-more-photos').on('click', function () {
        var categorieSlug = getSection1CategorieSlug();

        if (categorieSlug) {
            $.ajax({
                type: 'POST',
                url: ajaxurl, // WordPress AJAX URL
                data: {
                    action: 'single_load_more_photos', // Updated AJAX action
                    categorie: categorieSlug,
                },
                success: function (response) {
                    $('#photo-container').html(response);
                },
            });
        }
    });

    function getSection1CategorieSlug() {
        // Implement this function to extract and return the "categorie" slug from Section 1 content
    }
});






