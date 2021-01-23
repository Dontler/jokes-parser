<?php


namespace App\Jokes;


use DOMNode;


class JokesService {

    private const MK_URL_TEMPLATE = 'https://www.mk.ru/editions/daily/#YEAR#/#MONTH#/#DAY#/goryachaya-pyaterka-anekdotov-mk.html';

    /**
     * @param \DateTime $date
     * @return Joke[]
     * @throws \Exception
     */
    public function getJokes(\DateTime $date): array {
        $mkJokes = $this->getJokesFromMk($date->format('d'), $date->format('m'), $date->format('Y'));
        $mkJokes = mb_convert_encoding($mkJokes, 'HTML-ENTITIES', 'UTF-8');

        $document = new \DOMDocument();
        $document->loadHTML($mkJokes);

        $xPath = new \DOMXPath($document);
        $articleBody = $xPath->query('.//div[@class="article__body"]/p');
        if ($articleBody->count() < 1) {
            throw new \Exception('По заданной дате шуток не найдено');
        }

        $joke = '';
        $jokes = array();
        /** @var DOMNode $item */
        foreach ($articleBody as $item) {
            if ($item->nodeValue === "\u{00A0}") {
                $jokeRating = $this->getJokeRating($joke);
                $jokes[] = new Joke($joke, $jokeRating);
                $joke = '';
                continue;
            }

            $joke .= $item->nodeValue . PHP_EOL;
        }
        $jokeRating = $this->getJokeRating($joke);
        $jokes[] = new Joke($joke, $jokeRating);

        return $jokes;
    }

    private function getJokesFromMk(string $year, string $month, string $day): string {
        $url = str_replace(array('#YEAR#', '#MONTH#', '#DAY#'), array($day, $month, $year), self::MK_URL_TEMPLATE);

        $result = file_get_contents($url);
        if (!$result) {
            throw new \Exception('Не удалось получить данные из источника.');
        }

        return $result;
    }

    private function getJokeRating(string $jokeText): int {
        $url = 'https://www.anekdot.ru/search/?query=';
        $query = urlencode($jokeText);

        $uri = $url . $query;

        $result = file_get_contents($uri);

        $document = new \DOMDocument('', 'UTF-8');
        $document->loadHTML($result);

        $xPath = new \DOMXPath($document);
        $marks = $xPath->query('//div[@class="rates"]');

        $mark = $marks->item(0)->attributes->item(2)->nodeValue;

        $mark = (explode(';', $mark));

        $rating = ($mark[2] / $mark[1]);

        return (int) ($rating * 10);
    }


}