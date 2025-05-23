<?php

namespace App\Controllers;

use Core\Request;
use Core\Database;
use App\Models\Movie;

class MovieController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function index()
    {
        require_once __DIR__ . '/../Views/movie_search.php';
    }

    public function search()
    {
        $searchTerm = trim($_POST['title'] ?? '');
        $results = [];
        $apiKey = $_ENV['OMDB_API_KEY'];

        if (empty($searchTerm)) {
            echo json_encode([]);
            return;
        }

        $movieModel = new Movie();
    
        // Search by title
        $titleResponse = @file_get_contents("https://www.omdbapi.com/?apikey={$apiKey}&s=" . urlencode($searchTerm));
        $titleData = json_decode($titleResponse, true);
    
        if (!empty($titleData['Search'])) {
            foreach ($titleData['Search'] as $item) {
                // Fetch full details for each movie from the search list
                $details = @file_get_contents("https://www.omdbapi.com/?apikey={$apiKey}&i={$item['imdbID']}");
                $detailsData = json_decode($details, true);
                if (!empty($detailsData) && $detailsData['Response'] !== 'False') {
                    $results[$detailsData['imdbID']] = $this->formatMovieData($detailsData);
                }
            }
        }
    
        // If the input looks like an IMDb ID (e.g., tt1234567), fetch by ID
        if (preg_match('/^tt\d{7,}$/', $searchTerm)) {
            $idResponse = @file_get_contents("https://www.omdbapi.com/?apikey={$apiKey}&i={$searchTerm}");
            $idData = json_decode($idResponse, true);
    
            if (!empty($idData) && $idData['Response'] !== 'False') {
                $results[$idData['imdbID']] = $this->formatMovieData($idData);
            }
        }
    
        // Check which are saved already
        $existingIds = $movieModel->getSavedImdbIds();
        foreach ($results as $id => &$movie) {
            $movie['saved'] = in_array($id, $existingIds);
        }
    
        // Sort results: by released date desc, then by title alphabetically
        usort($results, function ($a, $b) {
            $dateA = strtotime($a['released'] ?? '');
            $dateB = strtotime($b['released'] ?? '');
            if ($dateA && $dateB) return $dateB - $dateA;
            return strcmp($a['title'], $b['title']);
        });

        header('Content-Type: application/json');
        echo json_encode(array_values($results));
    }
    
    public function save()
    {
        $data = Request::input();

        // Parse release date
        if (!empty($data['release'])) {
            $timestamp = strtotime($data['release']);
            $data['release'] = $timestamp !== false ? date('Y-m-d', $timestamp) : null;
        }

        $movie = new Movie();
        $status = $movie->save($data);

        echo json_encode(['status' => $status]);
    }

    private function formatMovieData(array $data): array
    {
        return [
            'title' => $data['Title'] ?? '',
            'poster' => $data['Poster'] ?? '',
            'rating' => $data['imdbRating'] ?? '',
            'released' => $data['Released'] ?? '',
            'imdbID' => $data['imdbID'] ?? '',
            'plot' => $data['Plot'] ?? '',
        ];
    }

}
