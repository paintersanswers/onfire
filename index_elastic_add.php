<?PHP

require 'd:/composer/vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

$params = [
    'index' => 'onfire',
    'id' => '1',
    'body'  => [
        'question' => "Who is the current managing partner of the firm",
        'answertypeid' => '2',
        'singleanswer' => 'Gerald Ramsey',
        'sqlquery' => "",
        'columnnumber' => '0',
        'questionchild' => "Who is the current managing partner of the firm",
        'questionkey' => "Who is the current managing partner of the firm",      
    ]
];

$response = $client->index($params);
print_r($response);

?>
