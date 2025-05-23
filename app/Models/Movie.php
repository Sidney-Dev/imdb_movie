<?php

namespace App\Models;

use Core\Model;

class Movie extends Model
{
    public function save(array $data): string
    {
        if ($this->exists('movies', 'imdb_id', $data['imdbID'])) {
            return 'exists';
        }

        $code = substr(hash('sha256', strrev(implode('', array_map(fn($w) => strtolower($w[0]), explode(' ', $data['title']))))), 0, 5);

        $this->insert('movies', [
            'title' => $data['title'],
            'plot' => $data['plot'],
            'poster' => $data['poster'],
            'rating' => $data['rating'],
            'released' => $data['release'],
            'imdb_id' => $data['imdbID'],
            'movie_code' => $code,
        ]);

        return 'saved';
    }

    public function getSavedImdbIds(): array
    {
        $stmt = $this->pdo->query("SELECT imdb_id FROM movies");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
