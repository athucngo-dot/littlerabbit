<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;

class ConfigureSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure Meilisearch indexes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client(
            config('scout.meilisearch.host'),
            config('scout.meilisearch.key')
        );

        $index = $client->index('products');

        $tasks = [];
        $task[] = $index->updateSearchableAttributes([
            'name',
            'category',
            'category_name',            
            'gender',
            'sizes',
            'sizes_category',
            'brand',
            'colors',            
            'material'
        ]);

        $task[] = $index->updateFilterableAttributes([
            'category',
            'gender',
            'sizes',
            'sizes_category',
            'brand',
            'colors',
            'material',
        ]);

        // Ranking rules
        $task[] = $index->updateRankingRules([
            'words',
            'typo',
            'proximity',
            'attribute',
            'exactness',
            'sort',
            //'asc(price)',
        ]);

        // Synonyms
        $task[] = $index->updateSynonyms([
            // Age groups
            'baby'          => ['babies', 'infant', 'infants', 'newborn', 'newborns'],
            'toddlers'      => ['toddler', 'toddlers', 'kids', 'children', 'child'],
            'kids'          => ['children', 'child', 'kid', 'toddlers', 'babies'],
            'children'      => ['kids', 'child', 'toddlers', 'babies'],

            // Tops
            'tshirt'        => ['t-shirt', 'tee', 'tees', 'top', 'tops', 'shirt', 'shirts'],
            'shirt'         => ['tshirt', 't-shirt', 'tee', 'top'],
            'sweater'       => ['jumper', 'pullover', 'cardigan', 'sweaters'],
            'hoodie'        => ['hoodies', 'sweatshirt', 'sweatshirts'],

            // Bottoms
            'pants'         => ['trousers', 'slacks', 'bottoms', 'pant', 'trouser', 'bottom'],
            'shorts'        => ['short', 'short pants', 'shorts pants'],
            'leggings'      => ['legging', 'tight', 'tights'],

            // Dresses & rompers
            'dress'         => ['gown', 'frock', 'skirt dress', 'dresses'],
            'romper'        => ['onesie', 'jumpsuit', 'overalls', 'rompers', 'onesies', 'jumpsuits'],

            // Outerwear
            'jacket'        => ['coat', 'hoodie', 'anorak', 'outerwear', 'jackets', 'coats'],
            'coat'          => ['jacket', 'overcoat', 'anorak', 'coats'],

            // Footwear
            'shoes'         => ['sneakers', 'boots', 'sandals', 'footwear', 'shoe', 'sneaker', 'boot', 'sandal'],

            // Underwear & sleepwear
            'underwear'     => ['briefs', 'panties', 'underpants', 'undershirt'],
            'pajamas'       => ['pjs', 'sleepwear', 'nightwear', 'pyjamas'],

            // Accessories
            'hat'           => ['cap', 'beanie', 'hats', 'caps', 'headwear'],
            'sock'          => ['socks', 'stockings', 'sock', 'stocking', 'footwear'],
            'scarf'         => ['scarves', 'neckwear'],

            // General children clothing terms
            'baby clothes'  => ['baby clothing', 'infant clothes', 'infant clothing', 'newborn clothes', 'newborn clothing'],
            'kids clothes'  => ['children clothes', 'children clothing', 'child clothes', 'child clothing', 'toddlers clothes'],
            'children clothes'=> ['kids clothes', 'children clothing', 'child clothes', 'child clothing'],
        ]);

        foreach ($tasks as $task) {
            // Wait for each task to complete
            $task->waitForCompletion($client);
        }

        $this->info('Meilisearch configured successfully.');
    }
}
