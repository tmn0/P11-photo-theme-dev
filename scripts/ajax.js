/* LOAD MORE BUTTON */
document.addEventListener('DOMContentLoaded', function() {
    var page = 2; // Initial page number, you can set it to 2 since you've already loaded the first page
    var loading = false;
    var loadMoreButton = document.getElementById('home-load-more-button');
    var gridContainer = document.querySelector('.home-masonry-grid');

    loadMoreButton.addEventListener('click', function() {
        if (!loading) {
            loading = true;
            loadMoreButton.textContent = 'Loading...';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', custom_ajax_params.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText) {
                        gridContainer.insertAdjacentHTML('beforeend', xhr.responseText);
                        page++;
                        loadMoreButton.textContent = 'Charger plus';
                        loading = false;
                    } else {
                        loadMoreButton.textContent = 'No more posts';
                        loadMoreButton.disabled = true;
                    }
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
            };

            xhr.send('action=load_more_posts&page=' + page);
        }
    });
});
