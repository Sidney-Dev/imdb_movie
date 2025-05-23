<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>IMDB Movie Search</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="bg-light">
        <div id="loadingOverlay">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
        </div>

        <div class="container mt-5">
            <h2 class="mb-4">Search Movies (by title or IMDb ID)</h2>

            <form id="searchForm" class="mb-5">
                <div class="input-group">
                    <input type="text" class="form-control" name="title" placeholder="Search..." required>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            <ul id="results" class="list-group"></ul>
        </div>

        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>
