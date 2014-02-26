<?php

/**
 * Script for importing members from MySQL to ElasticSearch
 *
 * Here goes a brief description of the purpose of the batch script
 *
 * @package    pr
 * @subpackage batch
 * @version    $Id$
 * 
 */
require_once(realpath(dirname(__FILE__).'/config.php'));

$memberMapping = array(
    '_source' => array(
        'enabled' => true
    ),
    'properties' => array(
        'username' => array(
          'type' => 'string',
        ),
        'essay_headline' => array(
          'type' => 'string',
        ),
        'essay_intro' => array(
          'type' => 'string',
        ),
        'orientation' => array(
          'omit_norms' => true,
          'type' => 'string',
          'index' => 'not_analyzed',
        ),
        'purpose' => array(
          'omit_norms' => true,
          'type' => 'string',
          'index' => 'not_analyzed',
        ),
        'location' => array(
          'type' => 'geo_point',
        ),
        'main_photo' => array(
          'type' => 'boolean',
        ),
        'country' => array(
          'type' => 'string',
          'index' => 'not_analyzed',
        ),
        'catalog_id' => array(
          'type' => 'long',
        ),
        'status_id' => array(
          'type' => 'long',
        ),
        'subscription_id' => array(
          'type' => 'long',
        ),
        'open_privacy' => array(
          'type' => 'long',
        ),
        'adm1_id' => array(
          'type' => 'long',
        ),
        'last_login' => array(
          'type' => 'long',
        ),
        'created' => array(
          'type' => 'long',
        ),
        'self_description' => array(
          'properties' => 
          array(
            'q15' => 
            array(
              'type' => 'long',
            ),
            'q10' => 
            array(
              'type' => 'long',
            ),
            'q2' => 
            array(
              'type' => 'long',
            ),
            'q7' => 
            array(
              'type' => 'long',
            ),
            'q18' => 
            array(
              'type' => 'long',
            ),
            'q13' => 
            array(
              'type' => 'long',
            ),
            'q3' => 
            array(
              'type' => 'long',
            ),
            'q8' => 
            array(
              'type' => 'long',
            ),
            'q16' => 
            array(
              'omit_norms' => true,
              'type' => 'string',
              'index' => 'not_analyzed',
            ),
            'q11' => 
            array(
              'type' => 'long',
            ),
            'q4' => 
            array(
              'type' => 'long',
            ),
            'q9' => 
            array(
              'type' => 'long',
            ),
            'q14' => 
            array(
              'type' => 'long',
            ),
            'q5' => 
            array(
              'type' => 'long',
            ),
            'q17' => 
            array(
              'type' => 'boolean',
            ),
            'q1' => 
            array(
              'format' => 'dateOptionalTime',
              'type' => 'date',
            ),
            'q12' => 
            array(
              'type' => 'long',
            ),
            'q6' => 
            array(
              'type' => 'long',
            ),
          ),
        ),
        'search_criteria' => array(
          'properties' => 
          array(
            'q15' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q10' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q2' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q7' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q18' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q13' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answer2' => 
                array(
                  'type' => 'long',
                ),
                'answer1' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q3' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q8' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q16' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'index_options' => 'docs',
                  'omit_norms' => true,
                  'type' => 'string',
                  'index' => 'not_analyzed',
                ),
              ),
            ),
            'q11' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q4' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q9' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q14' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q5' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q17' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'boolean',
                ),
              ),
            ),
            'q1' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answer2' => 
                array(
                  'type' => 'long',
                ),
                'answer1' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q12' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answer2' => 
                array(
                  'type' => 'long',
                ),
                'answer1' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
            'q6' => 
            array(
              'properties' => 
              array(
                'weight' => 
                array(
                  'type' => 'long',
                ),
                'answers' => 
                array(
                  'type' => 'long',
                ),
              ),
            ),
          ),
        ),
    ),
);

$client = new Elasticsearch\Client();
$indexParams['index']  = 'polishdate';

$ret = $client->indices()->delete($indexParams);

if (isset($ret['error'])) {
    echo $ret['error'] . "\n";
    exit(1);
} else {
    echo "Index deleted\n";
}

$indexParams['body']['mappings']['member'] = $memberMapping;
$ret = $client->indices()->create($indexParams);

if (isset($ret['error'])) {
    echo $ret['error'] . "\n";
    exit(1);
} else {
    echo "Index created\n";
}
