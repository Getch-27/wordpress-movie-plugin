<?php
class top_100_movies_api{

    public function get_movies() {
    
        $url = 'https://imdb-top-100-movies.p.rapidapi.com/';
        $api_key = '1e921b4e08msh785ab0ccb702593p1ba83bjsn50afc96278a5';
    

        $args = array(
            'headers' => array(
                'X-RapidAPI-Key' => $api_key,
                'X-RapidAPI-Host' => 'imdb-top-100-movies.p.rapidapi.com'
            )
        );
    
        // Send the request to api
        $response = wp_remote_get($url, $args);
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            return "Something went wrong: $error_message";
        }
    
         // return the response data
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        return $data;
    }
    
    public function display_movies() {
        $movies = $this->get_movies();
    
        
        echo '<h1 class ="title ">Top 100 Movies on IMDB </h1>';
        if (is_array($movies) && !empty($movies)) {
            echo '<div class="movie-grid">';
            foreach ($movies as $movie) {
                echo '<div class="movie-card">';
                echo '<div class="movie-poster">';
                echo '<img src="' . esc_url($movie['image']) . '" alt="' . esc_attr($movie['title']) . '">';
                echo '</div>';
                echo '<h2>' . esc_html($movie['title']) . ' (' . esc_html($movie['year']) . ')</h2>';
                echo '<p class="news-description"><strong>Rating:</strong> ' . esc_html($movie['rating']) . '/10</p>';
                echo '<p><strong>Genre:</strong> ' . esc_html(implode(', ', $movie['genre'])) . '</p>';
                echo '<p>' . esc_html($movie['description']) . '</p>';
                echo '<p><a href="' . esc_url($movie['imdb_link']) . '" target="_blank">View on IMDb</a></p>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No movies found or an error occurred.</p>';
        }
    }

}
