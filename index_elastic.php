<?PHP

require 'd:/composer/vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

//$params = [
//   'index' => 'onfire_test',
//   'body' => ['Q' => 'How Many Clients Opened Last Week']
//];

//$result = $client->index($params);

//print_r($result);

$params = [
    'index' => 'onfire',
    'body'  => [
        'query' => [
            'match' => [
                 'question' => [
                     'query' => 'all managing partners',
                     'fuzziness' => 2,
                     'prefix_length' => 1
                ]
            ]
        ]
    ]
];

$results = $client->search($params);
//print_r($results);

$Question = $results['hits']['hits'][0]['_source']['question'];
//$Question2 = $results['hits']['hits'][1]['_source']['question'];
print_r($Question);
echo "<br>";
//print_r($Question2);
$Answer = $results['hits']['hits'][0]['_source']['singleanswer'];
print_r($Answer);
echo "<br>";

?>
