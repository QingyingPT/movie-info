<?php


class IMDB {
    private $raw;
    private $id;
    private $name = ['title', 'year', 'country', 'runtime', 'ratingCount', 'ratingValue', 'language', 'locations', 'genres', 'storyline', 'directors', 'writers', 'poster', 'boxOffice', 'releaseDate', 'rated', 'actors', 'awards', 'productions'];

    public function __construct($imdbId) {
        $rawData = file_get_contents("http://www.imdb.com/title/tt{$imdbId}");
        $this->raw = preg_replace(['/\n/', '/>\s+</'], ['', '><'], $rawData);
        if ($imdbId) {
            $this->id = $imdbId;
        } else {
            $this->id = $this->getId();
        }
    }

    public function getData() {
        $res = [];
        $t = null;
        foreach ($this->name as $key) {
            $newKey = $this->getFunctionName($key);
            $t = $this->$newKey();
            if ($t) {
                $res[$key] = $t;
            }
        }
        return $res;
    }

    private function getId() {
        preg_match('/<link rel="canonical" href=".*?tt(\d+)/', $this->raw, $match);
        return $match[1];
    }

    private function getFunctionName($name) {
        $name[0] = strtoupper($name[0]);
        return 'get' . $name;
    }
    private function getTitle() {
        preg_match('/<h1 itemprop="name" class="">(.*?)&nbsp;/', $this->raw, $match);
        return $match[1];
    }

    private function getYear() {
        preg_match('/\/year\/(\d{4})\/\?ref_=tt_ov_inf/', $this->raw, $match);
        return $match[1];
    }

    private function getCountry() {
        preg_match_all('/country_of_origin=.*?>(.*?)<\/a>/', $this->raw, $matches);
        return join(', ', $matches[1]);
    }

    private function getRuntime() {
        preg_match('/datetime="PT(\d+)M"/', $this->raw, $matches);
        if ($matches[1]) {
            return $matches[1] . 'min';
        }
    }

    private function getRatingCount() {
        preg_match('/ratingCount">(.*?)</', $this->raw, $matche);
        return $matche[1];
    }

    private function getRatingValue() {
        preg_match('/ratingValue">(\d\.\d)</', $this->raw, $matche);
        return $matche[1];
    }

    private function getLanguage() {
        preg_match_all('/primary_language.*?>(.*?)</', $this->raw, $matches);
        return join(', ', $matches[1]);
    }

    private function getLocations() {
        preg_match('/locations=(.*?)&/', $this->raw, $matche);
        return str_replace('%20', ' ', $matche[1]);
    }

    private function getGenres() {
        preg_match_all('/<a href="\/genre\/([\w\s-]+)\?ref_=tt_stry_gnr">/', $this->raw, $matches);
        return join(', ', $matches[1]);
    }

    private function getStoryline() {
        preg_match('/<div class="inline canwrap" itemprop="description">(.*?)<\/div>/', $this->raw, $match);
        if (!($storyline = trim($match[1]))) return;

        $storyline = trim(preg_replace('/<em class="nobr">.*?<\/em>/', '', $storyline));

        preg_match('/<p>(.*?)<\/p>/', $storyline, $match);

        return trim($match[1]);
    }

    private function getDirectors() {
        preg_match_all('/tt_ov_dr.*?><span.*?>(.*?)<\/span>/', $this->raw, $matches);
        return join(', ', $matches[1]);
    }

    private function getWriters() {
        preg_match_all('/tt_ov_wr"itemprop=\'url\'><span.*?>(.*?)<\/span>/', $this->raw, $matches);
        return join(', ', $matches[1]);
    }

    private function getPoster() {
        preg_match('/<div class="poster">.*?src="(.*?)".*?\/>/', $this->raw, $match);
        return $match[1];
    }

    private function getBoxOffice() {
        preg_match('/Gross:<\/h4>(.*?)</', $this->raw, $match);
        return trim($match[1]);
    }

    private function getReleaseDate() {
        preg_match('/Release Date:<\/h4>(.*?)</', $this->raw, $match);
        return trim($match[1]);
    }

    private function getRated() {
        preg_match('/<span itemprop="contentRating">Rated (\w)/', $this->raw, $match);
        return $match[1];
    }

    private function getActors() {
        preg_match_all('/tt_cl_i\d+"><img.*?alt="(.*?)"/', $this->raw, $matches);
        return join(', ', array_slice($matches[1], 0, 4));
    }

    private function getAwards() {
        preg_match('/<span itemprop="awards">(.*?)<\/span>/', $this->raw, $match);
        return str_replace('&amp;', ',', $match[1]);
    }

    private function getProductions() {
        preg_match_all('/ref_=tt_dt_co".*?><span class="itemprop" itemprop="name">(.*?)<\/span><\/a>/', $this->raw, $matches);
        return join(', ', $matches[1]);
    }
    
}
