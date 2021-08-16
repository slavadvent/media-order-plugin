<?php
/*
Template Name: analizposts
*/

//        $start = microtime(true);

$allposts = get_posts( [
    'numberposts' => -1,
    'category'    => 0,
    'orderby'     => 'date',
    'order'       => 'ASC',
    'include'     => array(),
    'exclude'     => array(),
    'meta_key'    => '',
    'meta_value'  =>'',
    'post_type'   => ['post', 'page'],
    'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
] );

$allattachment  = get_posts( [
    'numberposts' => -1,
    'category'    => 0,
    'orderby'     => 'date',
    'order'       => 'ASC',
    'include'     => array(),
    'exclude'     => array(),
    'meta_key'    => '',
    'meta_value'  =>'',
    'post_type'   => 'attachment',
    'post_mime_type'=>'image',
    'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
] );

$categories = get_categories( [
    'taxonomy'     => 'category',
    'type'         => 'post',
    'child_of'     => 0,
    'parent'       => '',
    'orderby'      => 'name',
    'order'        => 'ASC',
    'hide_empty'   => 1,
    'hierarchical' => 'true',
    'pad_counts'   => false,
] );
$count_array_bad_image = 0;


//foreach( $categories as $cat ){
//    $count_array_bad_image++;
//    // Данные в объекте $cat
//
//    // $cat->term_id
//    // $cat->name (Рубрика 1)
//    // $cat->slug (rubrika-1)
//    // $cat->term_group (0)
//    // $cat->term_taxonomy_id (4)
//    // $cat->taxonomy (category)
//    // $cat->description (Текст описания)
//    // $cat->parent (0)
//    // $cat->count (14)
//    // $cat->object_id (2743)
//    // $cat->cat_ID (4)
//    // $cat->category_count (14)
//    // $cat->category_description (Текст описания)
//    // $cat->cat_name (Рубрика 1)
//    // $cat->category_nicename (rubrika-1)
//    // $cat->category_parent (0)
//
//    echo $count_array_bad_image . '. ' . $cat->name . '; ' . $cat->count;
//    echo '</br>';
//    echo $cat->description;
//    echo '</br>';
//    echo '</br>';
//}


foreach ($allposts as $initpost){

//                preg_match_all('/<img[^>]+>/i', $initpost->post_content, $result );
    if (preg_match_all('/src=("[^"]*")/i', $initpost->post_content, $result)){
        //var_dump($result);
        foreach ($result[1] as $res) {
            echo $res;
            echo '</br>';
        }


        break;
//        foreach ($result[2] as $item) {
//            $scr_clear = str_replace('"', '', $item);
//            $scr_clear = preg_replace('/(-[0-9]{3,3}+x[0-9]{3,3})/', '', $scr_clear);
//            if (preg_match('#wp-content/uploads+[^\s\.]+\.[a-z]+#', $scr_clear,$url_clear_post)){
//                $url_clear = $url_clear_post[0];
//                if ($url_attachment_clear === $url_clear){
//                    $marker_different = 1;
//                    break;
//                }
//
//            }
//
//        }
//        if ($marker_different) break;
    }

}

exit;


foreach ($allattachment as $initattachment){
    //$url_attachment_clear = preg_replace('#(\bhttps?://korfiati-local/)|(\bkorfiati-local/)#', '', $initattachment->guid);
    preg_match('#wp-content/uploads+[^\s\.]+\.[a-z]+#', $initattachment->guid,$url_clear_attachment);
    $url_attachment_clear = $url_clear_attachment[0];

    $marker_different = 0;

    foreach ($categories as $category){

        if (preg_match('/(src)=("[^"]*")/i', $category->description, $img_cat)) {
            $cat_clear = str_replace('"', '', $img_cat[2]);
            $cat_clear = preg_replace('/(-[0-9]{3,3}+x[0-9]{3,3})/', '', $cat_clear);
            if (preg_match('#wp-content/uploads+[^\s\.]+\.[a-z]+#', $cat_clear,$url_clear_cat)){
                if ($url_attachment_clear === $url_clear_cat[0]){
                    $marker_different = 1;
                    break;
                }

            }
        }

    }

    if (!$marker_different) {
        foreach ($allposts as $initpost){

//                preg_match_all('/<img[^>]+>/i', $initpost->post_content, $result );
            if (preg_match_all('/(src)=("[^"]*")/i', $initpost->post_content, $result)){
                foreach ($result[2] as $item) {
                    $scr_clear = str_replace('"', '', $item);
                    $scr_clear = preg_replace('/(-[0-9]{3,3}+x[0-9]{3,3})/', '', $scr_clear);
                    if (preg_match('#wp-content/uploads+[^\s\.]+\.[a-z]+#', $scr_clear,$url_clear_post)){
                        $url_clear = $url_clear_post[0];
                        if ($url_attachment_clear === $url_clear){
                            $marker_different = 1;
                            break;
                        }

                    }

                }
                if ($marker_different) break;
            }

        }

    }

    if (!$marker_different) {
        $array_bad_image = $initattachment;
        //var_dump(get_post($array_bad_image[$count_array_bad_image]->post_parent));
        echo '<img src="' . $array_bad_image->guid . '" width = "150">';
        echo 'Title = ' . $array_bad_image->post_title . ';';
        if (!$array_bad_image->post_parent){
            $post_title = get_post($array_bad_image->post_parent);
            echo $post_title->post_title;
            echo '<br>';
        }
        else {
            echo 'No parrent;';
            echo '<br>';
        }
        $count_array_bad_image++;
    }
    //set_time_limit(0);
}

$finish = microtime(true);

//var_dump($finish-$start);




//        if( false === wp_delete_attachment($array_bad_image[0]->id) ){
//            echo "Не удалось удалить медиа файл";
//        } else {
//            echo "Медиа файл удален";
//        }
?>


