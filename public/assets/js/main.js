$(document).ready(function () {
    $(document).ajaxStart(function () {
        $('#loadingOverlay').fadeIn();
    }).ajaxStop(function () {
        $('#loadingOverlay').fadeOut();
    });

    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post('/movie/search', formData, function (data) {
            $('#results').empty();
            if (data.length === 0) {
                $('#results').append('<li class="list-group-item">No results found.</li>');
                return;
            }

            data.forEach((movie) => {
                const isSaved = movie.saved ? 'disabled btn-secondary' : 'btn-success';
                const saveText = movie.saved ? 'Saved' : 'Save';

                const poster = (!movie.poster || movie.poster == 'N/A') ? 'https://placehold.co/600x400/png' : movie.poster;

                const item = `
                <li class="list-group-item">
                    <div class="row g-3">
                        <div class="col-md-3 text-center">
                            <img src="${poster}" 
                                onerror="this.onerror=null;this.src='https://placehold.co/100x150/png?text=No+Image';" 
                                class="movie-poster w-100 h-100" 
                                alt="${movie.title}" 
                                width="100" height="150">
                        </div>
                        <div class="col-md-7">
                            <h5 class="movie-title">${movie.title}</h5>
                            <p class="mb-1"><strong>Rating:</strong> <span class="movie-rating">${movie.rating || 'N/A'}</span></p>
                            <p class="mb-1"><strong>Released:</strong> <span class="movie-release">${movie.released || 'N/A'}</span></p>
                            <p class="mb-1"><strong>Plot:</strong> <span class="movie-plot">${movie.plot || 'No plot available.'}</span></p>
                        </div>
                        <div class="col-md-2 text-md-end text-center">
                            <button class="btn ${isSaved} save-btn" data-id="${movie.imdbID}" ${movie.saved ? 'disabled' : ''}>${saveText}</button>
                        </div>
                    </div>
                </li>`;

                $('#results').append(item);
            });
        }, 'json');
    });

    $(document).on('click', '.save-btn', function () {
        const button = $(this);
        const parent = button.closest('li');

        const imdbID = button.data('id');
        const title = parent.find('.movie-title').text();
        const rating = parent.find('.movie-rating').text();
        const released = parent.find('.movie-release').text();
        const plot = parent.find('.movie-plot').text();
        const poster = parent.find('.movie-poster').attr('src');

        $.post('/movie/save', {
            imdbID, title, rating, released, plot, poster
        }, function (res) {
            if (res.status === 'saved') {
                button.text('Saved')
                    .removeClass('btn-success')
                    .addClass('btn-secondary')
                    .prop('disabled', true);
            }
        }, 'json');
    });
});