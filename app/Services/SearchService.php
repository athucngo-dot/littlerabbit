<?php

namespace App\Services;

class SearchService
{
    public static array $searchFilters = [
        'colors', 'sizes', 'sizes_category', 'gender', 'brand', 'category', 'material'
        ];

    protected array $colors = [
        'red','blue','yellow','green','pink','purple','orange','brown','white','black','grey','baby pink','baby blue','mint green','lavender','peach','sky blue','soft yellow','cream','lilac','turquoise','hot pink','lime green','bright orange','electric blue','sunshine yellow','coral','aqua','fuchsia','beige','olive','terracotta','mustard','taupe','charcoal','sage green','dusty rose','dusty blue','mauve','burnt sienna','clay','eucalyptus','blush','slate','mocha','pistachio','storm blue'
    ];

    protected array $sizes = [
        'NB','3M','6M','9M','12M','18M','24M','2T','3T','4T','5T','10','12','14','16','18','20','4','5','6','7','8'
    ];

    protected array $sizes_category = [
        'baby','babies','toddler','toddlers','kid','kids'
    ];

    protected array $brands = [
        "Carter's","OshKosh B'gosh","Baby Gap","Old Navy Kids","H&M Kids","Zara Kids","The Children's Place","Janie and Jack","Gymboree","Mini Boden","Nike Kids","Adidas Kids","Under Armour Kids","Cat & Jack","Tea Collection","Primary","Burt's Bees Baby","Kyte Baby","Little Me","Hanna Andersson","Monica + Andy","Baby Mori","Maisonette","Pehr","Loulou Lollipop","Touched by Nature","Little Planet by Carter's","PatPat","Bobo Choses","Rylee + Cru","Souris Mini"
    ];

    protected array $genders = [
        'boy','boys','girl','girls','unisex'
    ];

    // Basic list of product categories
    protected array $categories = [
        'tops','t-shirts','shirts','sweaters','hoodies','jackets','coats','dresses','skirts','pants','jeans','shorts','leggings','overalls','rompers','sleepwear','pyjamas','undergarments','socks','swimwear','rainwear','shoes','boots','sandals','sneakers','hats','caps','beanies','mittens','gloves','scarves','school uniforms','party wear','activewear','sportswear','costumes','bibs','onesies','bodysuits','thermals','outerwear','accessories'
    ];

    // Basic list of product materials
    protected array $materials = [
        'cotton','organic cotton','bamboo','linen','jersey cotton','fleece','french terry','terry cloth','muslin','denim','corduroy','velour','wool','merino wool','cashmere','polyester','recycled polyester','nylon','spandex','elastane','rayon','modal','tencel','viscose','acrylic','silk','leather (faux)','pu leather','canvas','chambray','seersucker','mesh','quilted cotton'
    ];

    /**
     * Parse free-form query into searchable keywords and structured filters
     */
    public function parse(string $query): array
    {
        $query = strtolower($query);

        $filters = [];
        $keywords = [];

        // Detect brand
        $query =self::parseQuery($query, $this->brands, 'brand', 'brand', $filters);

        // Detect colors
        $query =self::parseQuery($query, $this->colors, 'color','colors', $filters);
        
        // Detect gender
        $query =self::parseQuery($query, $this->genders, 'gender', 'gender', $filters);
        
        // Detect sizes (number-based)
        $query = self::parseQuery($query, $this->sizes, 'size', 'sizes', $filters);

        // Detect sizes (number-based)
        $query = self::parseQuery($query, $this->sizes_category, 'size', 'sizes_category', $filters);
        
        // Detect product category
        $query = self::parseQuery($query, $this->categories, 'category', 'category', $filters);

        // Detect material
        $query = self::parseQuery($query, $this->materials, 'material', 'material', $filters);

        // Remaining words are considered keywords / theme
        $keywords = array_filter(array_map('trim', preg_split('/\s+/', $query)));

        return [
            'searchQuery' => implode(' ', $keywords), // main keywords
            'filters' => $filters
        ];
    }

    /**
     * Rebuild query parameters from parsed data
     */
    public function rebuildParams(array $parsed): array
    {
        $params = [
            'q' => $parsed['searchQuery'],
        ];

        if (empty($parsed['filters'])) {
            return $params;
        }

        $filterList = self::$searchFilters;
        foreach ($parsed['filters'] as $filterKey => $values) {
            if (!in_array($filterKey, $filterList)) {
                continue;
            }

            foreach ($values as $value) {
                $params[$filterKey][] = $value;
            }
        }

        return $params;
    }

    /**
     * Build MeiliSearch filter string from filters array
     */
    public static function buildMeiliSearchFilter(array $filters): ?string
    {
        $expressions = [];

        foreach ($filters as $attribute => $values) {
            if (empty($values)) {
                continue;
            }

            $orParts = array_map(function ($value) use ($attribute) {
                $escaped = addslashes($value);
                return sprintf('%s = "%s"', $attribute, $escaped);
            }, $values);

            // Combine with OR
            // eg. (color = "PINK" OR color = "BABY PINK")
            $expressions[] = '(' . implode(' OR ', $orParts) . ')';
        }

        // Combine all with AND
        // eg. (color = "PINK" OR color = "BABY PINK") AND (size = "3M" OR size = "6M")
        return empty($expressions)
            ? null
            : implode(' AND ', $expressions);
    }

    /**
     * Helper function to parse query for specific terms
     */
    private static function parseQuery($query, $termArr, $prefix, $searchTerm, &$filters)
    {
        foreach ($termArr as $term) {
            // Use word boundaries to match whole words only, case-insensitive
            $pattern = '/\b' . preg_quote($term, '/') . '\b/i';

            if (preg_match($pattern, $query)) {
                $filters[$searchTerm][] = strtoupper($term);
                $query = str_ireplace($prefix . ' ' . $term, '', $query);
                //$query = preg_replace($pattern, '', $query);
            }
        }

        return $query;
    }
}
