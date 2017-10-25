<?
require('wp-load.php');
class check
{
    function get()
    {
        $categories = get_terms('category', array(
            'orderby' => 'term_id',
            'order' => 'ASC',
            'hide_empty' => '0',
            'exclude' => '102,103'
        ));
        $category_ids = array();
        foreach ($categories as $category)
        {
            $category_ids[] = $category->term_id;
        }
        $posts = get_posts(array(
            'category' => implode(',', $category_ids),
            'numberposts' => -1,
            'orderby' => 'ID',
            'order' => 'ASC',
            'post_status' => 'publish'
        ));
        global $wpdb;
        foreach ($posts as $post) {
            $records = get_post_meta($post->ID,'available',true);
            if($records==='')
            {
                $a[0] = "yes";
                $b = "'".serialize($a)."'";
                $newest = $wpdb->query("update wp_999postmeta set `meta_value` = {$b} where post_id=$post->ID and meta_key='available'");
            }
        }
    }
}
$new = new check();
$new->get();




