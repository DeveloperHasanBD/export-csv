<?php

/**
 * Template name: CSV
 */


csv_generator();
function csv_generator()
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    global $wpdb;
    $main_user_table_name   = $wpdb->prefix . 'users';
    $posts_table            = $wpdb->prefix . 'posts';
    $postmeta_table         = $wpdb->prefix . 'postmeta';
    $terms_table            = $wpdb->prefix . 'terms';
    $term_taxonomy_table    = $wpdb->prefix . 'term_taxonomy';
    $user_id                = '';
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
    }

    // $db_name    = $wpdb->dbname;
    // $servername = "localhost";
    // $username   = "root";
    // $password   = "";
    // $db         = $db_name;


    $servername = "localhost";
    $username   = "newbarbi_C7GHd8r6P";
    $password   = "P8EH4kRM6g5T";
    $db         = "newbarbi_V8Hd7tC8T";



    $products_query     = "SELECT * from {$posts_table} WHERE post_type='product' AND post_status='publish'";
    $con                = mysqli_connect($servername, $username, $password, $db);
    $products_result    = mysqli_query($con, $products_query);

    $i = 0;
    $output = fopen("php://output", "w");

    fputcsv($output, array('ID', 'title', 'Thumbnail', 'Gallery',  'Category', 'Brand',  'Pdf URL', 'Description', 'Product type', 'Codice', 'Standard', 'Specifica'));

    while ($row = mysqli_fetch_assoc($products_result)) {
        $data           =  array();
        $data['id']     = $row['ID'];
        $data['title']  = $row['post_title'];
        $product_bnames = $wpdb->get_results("SELECT * FROM {$postmeta_table} WHERE post_id='{$row['ID']}' AND meta_key  LIKE 'dvchld_choose_brand_name%'");

        $product_img_fetails = wp_get_attachment_image_src(get_post_thumbnail_id($row['ID']), 'single-post-thumbnail');

        if ($product_img_fetails) {
            $data['product_thumbnail'] = $product_img_fetails[0];
        } else {
            $data['product_thumbnail'] = '';
        }

        global $product;
        $data['product_gallery'] = '';
        $product = new WC_product($row['ID']);


        $attachment_ids = $product->get_gallery_image_ids();
        foreach ($attachment_ids as $attachment_id) {
            $data['product_gallery'] .= wp_get_attachment_url($attachment_id) . "\n\n";
        }

        $data['product_cat']    = '';

        $parent_cat = get_the_terms($row['ID'], 'product_cat');


        foreach ($parent_cat as $term) {
            $data['product_cat'] .= $term->name . "\n\n";
        }

        foreach ($product_bnames as $brand) {
            $data['product_brand'] = $brand->meta_value;
        }

        // start product pdf 
        $products_pdf = $wpdb->get_results("SELECT * FROM {$postmeta_table} WHERE post_id='{$row['ID']}' AND meta_key  LIKE 'pinx_spcial_product_pdf%'");

        if ($products_pdf) {
            foreach ($products_pdf as $pdf) {
                $data['product_pdf'] = wp_get_attachment_url($pdf->meta_value);
            }
        } else {
            $data['product_pdf'] = '';
        }


        // start product desc 
        $products_desc = $wpdb->get_results("SELECT * FROM {$postmeta_table} WHERE post_id='{$row['ID']}' AND meta_key  LIKE 'dvchld_p_description%'");

        if ($products_desc) {
            foreach ($products_desc as $desc) {
                $data['product_desc'] = $desc->meta_value;
            }
        } else {
            $data['product_desc'] = '';
        }


        // start scp_choose_product_type 
        $products_types = $wpdb->get_results("SELECT * FROM {$postmeta_table} WHERE post_id='{$row['ID']}' AND meta_key  LIKE 'scp_choose_product_type%'");

        if ($products_types) {
            foreach ($products_types as $type) {
                $data['product_type'] = $type->meta_value;
            }
        } else {
            $data['product_type'] = '';
        }


        // insert rows 


        // // start pintex tada table processing 
        if ('PINTEX' == $data['product_brand']) {

            // pntx start row #1
            $pntx_row_one_col_1 = get_post_meta($row['ID'], 'pntx_row_one_col_1', true);
            $pntx_row_one_col_2 = get_post_meta($row['ID'], 'pntx_row_one_col_2', true);
            $pntx_row_one_col_3 = get_post_meta($row['ID'], 'pntx_row_one_col_3', true);

            // pntx start row #2
            $pntx_row_two_col_1 = get_post_meta($row['ID'], 'pntx_row_two_col_1', true);
            $pntx_row_two_col_2 = get_post_meta($row['ID'], 'pntx_row_two_col_2', true);
            $pntx_row_two_col_3 = get_post_meta($row['ID'], 'pntx_row_two_col_3', true);

            // pntx start row #3 
            $pntx_row_three_col_1 = get_post_meta($row['ID'], 'pntx_row_three_col_1', true);
            $pntx_row_three_col_2 = get_post_meta($row['ID'], 'pntx_row_three_col_2', true);
            $pntx_row_three_col_3 = get_post_meta($row['ID'], 'pntx_row_three_col_3', true);

            // pntx start row #4 
            $pntx_row_four_col_1 = get_post_meta($row['ID'], 'pntx_row_four_col_1', true);
            $pntx_row_four_col_2 = get_post_meta($row['ID'], 'pntx_row_four_col_2', true);
            $pntx_row_four_col_3 = get_post_meta($row['ID'], 'pntx_row_four_col_3', true);

            // pntx start row #5 
            $pntx_row_five_col_1 = get_post_meta($row['ID'], 'pntx_row_five_col_1', true);
            $pntx_row_five_col_2 = get_post_meta($row['ID'], 'pntx_row_five_col_2', true);
            $pntx_row_five_col_3 = get_post_meta($row['ID'], 'pntx_row_five_col_3', true);

            // pntx start row #6
            $pntx_row_six_col_1 = get_post_meta($row['ID'], 'pntx_row_six_col_1', true);
            $pntx_row_six_col_2 = get_post_meta($row['ID'], 'pntx_row_six_col_2', true);
            $pntx_row_six_col_3 = get_post_meta($row['ID'], 'pntx_row_six_col_3', true);

            // pntx start row #7
            $pntx_row_seven_col_1 = get_post_meta($row['ID'], 'pntx_row_seven_col_1', true);
            $pntx_row_seven_col_2 = get_post_meta($row['ID'], 'pntx_row_seven_col_2', true);
            $pntx_row_seven_col_3 = get_post_meta($row['ID'], 'pntx_row_seven_col_3', true);

            // pntx start row #8
            $pntx_row_eight_col_1 = get_post_meta($row['ID'], 'pntx_row_eight_col_1', true);
            $pntx_row_eight_col_2 = get_post_meta($row['ID'], 'pntx_row_eight_col_2', true);
            $pntx_row_eight_col_3 = get_post_meta($row['ID'], 'pntx_row_eight_col_3', true);

            // pntx start row #9
            $pntx_row_nine_col_1 = get_post_meta($row['ID'], 'pntx_row_nine_col_1', true);
            $pntx_row_nine_col_2 = get_post_meta($row['ID'], 'pntx_row_nine_col_2', true);
            $pntx_row_nine_col_3 = get_post_meta($row['ID'], 'pntx_row_nine_col_3', true);

            // pntx start row #10
            $pntx_row_ten_col_1 = get_post_meta($row['ID'], 'pntx_row_ten_col_1', true);
            $pntx_row_ten_col_2 = get_post_meta($row['ID'], 'pntx_row_ten_col_2', true);
            $pntx_row_ten_col_3 = get_post_meta($row['ID'], 'pntx_row_ten_col_3', true);

            // pntx start row #11
            $pntx_row_eleven_col_1 = get_post_meta($row['ID'], 'pntx_row_eleven_col_1', true);
            $pntx_row_eleven_col_2 = get_post_meta($row['ID'], 'pntx_row_eleven_col_2', true);
            $pntx_row_eleven_col_3 = get_post_meta($row['ID'], 'pntx_row_eleven_col_3', true);

            // pntx start row #11
            $pntx_row_twelve_col_1 = get_post_meta($row['ID'], 'pntx_row_twelve_col_1', true);
            $pntx_row_twelve_col_2 = get_post_meta($row['ID'], 'pntx_row_twelve_col_2', true);
            $pntx_row_twelve_col_3 = get_post_meta($row['ID'], 'pntx_row_twelve_col_3', true);

            $data['first_col_data'] =
                $pntx_row_one_col_1 . "\n\n\n" .
                $pntx_row_two_col_1 . "\n\n\n" .
                $pntx_row_three_col_1 . "\n\n\n" .
                $pntx_row_four_col_1 . "\n\n\n" .
                $pntx_row_five_col_1 . "\n\n\n" .
                $pntx_row_six_col_1 . "\n\n\n" .
                $pntx_row_seven_col_1 . "\n\n\n" .
                $pntx_row_eight_col_1 . "\n\n\n" .
                $pntx_row_nine_col_1 . "\n\n\n" .
                $pntx_row_ten_col_1 . "\n\n\n" .
                $pntx_row_eleven_col_1 . "\n\n\n" .
                $pntx_row_twelve_col_1 . "\n\n\n";
            // end first 
            $data['snd_col_data'] =
                $pntx_row_one_col_2 . "\n\n\n" .
                $pntx_row_two_col_2 . "\n\n\n" .
                $pntx_row_three_col_2 . "\n\n\n" .
                $pntx_row_four_col_2 . "\n\n\n" .
                $pntx_row_five_col_2 . "\n\n\n" .
                $pntx_row_six_col_2 . "\n\n\n" .
                $pntx_row_seven_col_2 . "\n\n\n" .
                $pntx_row_eight_col_2 . "\n\n\n" .
                $pntx_row_nine_col_2 . "\n\n\n" .
                $pntx_row_ten_col_2 . "\n\n\n" .
                $pntx_row_eleven_col_2 . "\n\n\n" .
                $pntx_row_twelve_col_2 . "\n\n\n";
            // end second 
            $data['trd_col_data'] =
                $pntx_row_one_col_3 . "\n\n\n" .
                $pntx_row_two_col_3 . "\n\n\n" .
                $pntx_row_three_col_3 . "\n\n\n" .
                $pntx_row_four_col_3 . "\n\n\n" .
                $pntx_row_five_col_3 . "\n\n\n" .
                $pntx_row_six_col_3 . "\n\n\n" .
                $pntx_row_seven_col_3 . "\n\n\n" .
                $pntx_row_eight_col_3 . "\n\n\n" .
                $pntx_row_nine_col_3 . "\n\n\n" .
                $pntx_row_ten_col_3 . "\n\n\n" .
                $pntx_row_eleven_col_3 . "\n\n\n" .
                $pntx_row_twelve_col_3 . "\n\n\n";
            // end third 
        }
        // end pintex tada table processing 

        // start BARBIFLEX tada table processing 
        if ('BARBIFLEX' == $data['product_brand']) {
            // bb start row #1 
            $bflex_row_one_col_1 = get_post_meta($row['ID'], 'bflex_row_one_col_1', true);
            $bflex_row_one_col_2 = get_post_meta($row['ID'], 'bflex_row_one_col_2', true);
            $bflex_row_one_col_3 = get_post_meta($row['ID'], 'bflex_row_one_col_3', true);


            // bb start row #2 
            $bflex_row_two_col_1 = get_post_meta($row['ID'], 'bflex_row_two_col_1', true);
            $bflex_row_two_col_2 = get_post_meta($row['ID'], 'bflex_row_two_col_2', true);
            $bflex_row_two_col_3 = get_post_meta($row['ID'], 'bflex_row_two_col_3', true);


            // bb start row #3 
            $bflex_row_three_col_1 = get_post_meta($row['ID'], 'bflex_row_three_col_1', true);
            $bflex_row_three_col_2 = get_post_meta($row['ID'], 'bflex_row_three_col_2', true);
            $bflex_row_three_col_3 = get_post_meta($row['ID'], 'bflex_row_three_col_3', true);

            // bb start row #4 
            $bflex_row_four_col_1 = get_post_meta($row['ID'], 'bflex_row_four_col_1', true);
            $bflex_row_four_col_2 = get_post_meta($row['ID'], 'bflex_row_four_col_2', true);
            $bflex_row_four_col_3 = get_post_meta($row['ID'], 'bflex_row_four_col_3', true);

            // bb start row #5 
            $bflex_row_five_col_1 = get_post_meta($row['ID'], 'bflex_row_five_col_1', true);
            $bflex_row_five_col_2 = get_post_meta($row['ID'], 'bflex_row_five_col_2', true);
            $bflex_row_five_col_3 = get_post_meta($row['ID'], 'bflex_row_five_col_3', true);

            // bb start row #6
            $bflex_row_six_col_1 = get_post_meta($row['ID'], 'bflex_row_six_col_1', true);
            $bflex_row_six_col_2 = get_post_meta($row['ID'], 'bflex_row_six_col_2', true);
            $bflex_row_six_col_3 = get_post_meta($row['ID'], 'bflex_row_six_col_3', true);

            // bb start row #7
            $bflex_row_seven_col_1 = get_post_meta($row['ID'], 'bflex_row_seven_col_1', true);
            $bflex_row_seven_col_2 = get_post_meta($row['ID'], 'bflex_row_seven_col_2', true);
            $bflex_row_seven_col_3 = get_post_meta($row['ID'], 'bflex_row_seven_col_3', true);

            // bb start row #8
            $bflex_row_eight_col_1 = get_post_meta($row['ID'], 'bflex_row_eight_col_1', true);
            $bflex_row_eight_col_2 = get_post_meta($row['ID'], 'bflex_row_eight_col_2', true);
            $bflex_row_eight_col_3 = get_post_meta($row['ID'], 'bflex_row_eight_col_3', true);


            // bb start row #9
            $bflex_row_nine_col_1 = get_post_meta($row['ID'], 'bflex_row_nine_col_1', true);
            $bflex_row_nine_col_2 = get_post_meta($row['ID'], 'bflex_row_nine_col_2', true);
            $bflex_row_nine_col_3 = get_post_meta($row['ID'], 'bflex_row_nine_col_3', true);

            // bb start row #10
            $bflex_row_ten_col_1 = get_post_meta($row['ID'], 'bflex_row_ten_col_1', true);
            $bflex_row_ten_col_2 = get_post_meta($row['ID'], 'bflex_row_ten_col_2', true);
            $bflex_row_ten_col_3 = get_post_meta($row['ID'], 'bflex_row_ten_col_3', true);



            // bb start row #11
            $bflex_row_eleven_col_1 = get_post_meta($row['ID'], 'bflex_row_eleven_col_1', true);
            $bflex_row_eleven_col_2 = get_post_meta($row['ID'], 'bflex_row_eleven_col_2', true);
            $bflex_row_eleven_col_3 = get_post_meta($row['ID'], 'bflex_row_eleven_col_3', true);



            // bb start row #12
            $bflex_row_twelve_col_1 = get_post_meta($row['ID'], 'bflex_row_twelve_col_1', true);
            $bflex_row_twelve_col_2 = get_post_meta($row['ID'], 'bflex_row_twelve_col_2', true);
            $bflex_row_twelve_col_3 = get_post_meta($row['ID'], 'bflex_row_twelve_col_3', true);

            // bb start row #13
            $bflex_row_thirteen_col_1 = get_post_meta($row['ID'], 'bflex_row_thirteen_col_1', true);
            $bflex_row_thirteen_col_2 = get_post_meta($row['ID'], 'bflex_row_thirteen_col_2', true);
            $bflex_row_thirteen_col_3 = get_post_meta($row['ID'], 'bflex_row_thirteen_col_3', true);

            // bb start row #14
            $bflex_row_fourteen_col_1 = get_post_meta($row['ID'], 'bflex_row_fourteen_col_1', true);
            $bflex_row_fourteen_col_2 = get_post_meta($row['ID'], 'bflex_row_fourteen_col_2', true);
            $bflex_row_fourteen_col_3 = get_post_meta($row['ID'], 'bflex_row_fourteen_col_3', true);



            // bb start row #15
            $bflex_row_fifteen_col_1 = get_post_meta($row['ID'], 'bflex_row_fifteen_col_1', true);
            $bflex_row_fifteen_col_2 = get_post_meta($row['ID'], 'bflex_row_fifteen_col_2', true);
            $bflex_row_fifteen_col_3 = get_post_meta($row['ID'], 'bflex_row_fifteen_col_3', true);


            // bb start row #16
            $bflex_row_sisteen_col_1 = get_post_meta($row['ID'], 'bflex_row_sisteen_col_1', true);
            $bflex_row_sisteen_col_2 = get_post_meta($row['ID'], 'bflex_row_sisteen_col_2', true);
            $bflex_row_sisteen_col_3 = get_post_meta($row['ID'], 'bflex_row_sisteen_col_3', true);

            // bb start row #17
            $bflex_row_seventeen_col_1 = get_post_meta($row['ID'], 'bflex_row_seventeen_col_1', true);
            $bflex_row_seventeen_col_2 = get_post_meta($row['ID'], 'bflex_row_seventeen_col_2', true);
            $bflex_row_seventeen_col_3 = get_post_meta($row['ID'], 'bflex_row_seventeen_col_3', true);


            // bb start row #18
            $bflex_row_eightteen_col_1 = get_post_meta($row['ID'], 'bflex_row_eightteen_col_1', true);
            $bflex_row_eightteen_col_2 = get_post_meta($row['ID'], 'bflex_row_eightteen_col_2', true);
            $bflex_row_eightteen_col_3 = get_post_meta($row['ID'], 'bflex_row_eightteen_col_3', true);


            // bb start row #19
            $bflex_row_nineteen_col_1 = get_post_meta($row['ID'], 'bflex_row_nineteen_col_1', true);
            $bflex_row_nineteen_col_2 = get_post_meta($row['ID'], 'bflex_row_nineteen_col_2', true);
            $bflex_row_nineteen_col_3 = get_post_meta($row['ID'], 'bflex_row_nineteen_col_3', true);


            // bb start row #20
            $bflex_row_twenteeone_col_1 = get_post_meta($row['ID'], 'bflex_row_twenteeone_col_1', true);
            $bflex_row_twenteetwo_col_2 = get_post_meta($row['ID'], 'bflex_row_twenteetwo_col_2', true);
            $bflex_row_twenteethree_col_3 = get_post_meta($row['ID'], 'bflex_row_twenteethree_col_3', true);


            // bb start row #21
            $bflex_row_twentee_on_one_col_1 = get_post_meta($row['ID'], 'bflex_row_twentee_on_one_col_1', true);
            $bflex_row_twentee_on_one_col_2 = get_post_meta($row['ID'], 'bflex_row_twentee_on_one_col_2', true);
            $bflex_row_twentee_on_one_col_3 = get_post_meta($row['ID'], 'bflex_row_twentee_on_one_col_3', true);



            $data['first_col_data'] =
                $bflex_row_one_col_1 . "\n\n\n" .
                $bflex_row_two_col_1 . "\n\n\n" .
                $bflex_row_three_col_1 . "\n\n\n" .
                $bflex_row_four_col_1 . "\n\n\n" .
                $bflex_row_five_col_1 . "\n\n\n" .
                $bflex_row_six_col_1 . "\n\n\n" .
                $bflex_row_seven_col_1 . "\n\n\n" .
                $bflex_row_eight_col_1 . "\n\n\n" .
                $bflex_row_nine_col_1 . "\n\n\n" .
                $bflex_row_ten_col_1 . "\n\n\n" .
                $bflex_row_eleven_col_1 . "\n\n\n" .
                $bflex_row_twelve_col_1 . "\n\n\n" .
                $bflex_row_thirteen_col_1 . "\n\n\n" .
                $bflex_row_fourteen_col_1 . "\n\n\n" .
                $bflex_row_fifteen_col_1 . "\n\n\n" .
                $bflex_row_sisteen_col_1 . "\n\n\n" .
                $bflex_row_seventeen_col_1 . "\n\n\n" .
                $bflex_row_eightteen_col_1 . "\n\n\n" .
                $bflex_row_nineteen_col_1 . "\n\n\n" .
                $bflex_row_twenteeone_col_1 . "\n\n\n" .
                $bflex_row_twentee_on_one_col_1 . "\n\n\n";
            // end first 
            $data['snd_col_data'] =
                $bflex_row_one_col_2 . "\n\n\n" .
                $bflex_row_two_col_2 . "\n\n\n" .
                $bflex_row_three_col_2 . "\n\n\n" .
                $bflex_row_four_col_2 . "\n\n\n" .
                $bflex_row_five_col_2 . "\n\n\n" .
                $bflex_row_six_col_2 . "\n\n\n" .
                $bflex_row_seven_col_2 . "\n\n\n" .
                $bflex_row_eight_col_2 . "\n\n\n" .
                $bflex_row_nine_col_2 . "\n\n\n" .
                $bflex_row_ten_col_2 . "\n\n\n" .
                $bflex_row_eleven_col_2 . "\n\n\n" .
                $bflex_row_twelve_col_2 . "\n\n\n" .
                $bflex_row_thirteen_col_2 . "\n\n\n" .
                $bflex_row_fourteen_col_2 . "\n\n\n" .
                $bflex_row_fifteen_col_2 . "\n\n\n" .
                $bflex_row_sisteen_col_2 . "\n\n\n" .
                $bflex_row_seventeen_col_2 . "\n\n\n" .
                $bflex_row_eightteen_col_2 . "\n\n\n" .
                $bflex_row_nineteen_col_2 . "\n\n\n" .
                $bflex_row_twenteetwo_col_2 . "\n\n\n" .
                $bflex_row_twentee_on_one_col_2 . "\n\n\n";
            // end second 
            $data['trd_col_data'] =
                $bflex_row_one_col_3 . "\n\n\n" .
                $bflex_row_two_col_3 . "\n\n\n" .
                $bflex_row_three_col_3 . "\n\n\n" .
                $bflex_row_four_col_3 . "\n\n\n" .
                $bflex_row_five_col_3 . "\n\n\n" .
                $bflex_row_six_col_3 . "\n\n\n" .
                $bflex_row_seven_col_3 . "\n\n\n" .
                $bflex_row_eight_col_3 . "\n\n\n" .
                $bflex_row_nine_col_3 . "\n\n\n" .
                $bflex_row_ten_col_3 . "\n\n\n" .
                $bflex_row_eleven_col_3 . "\n\n\n" .
                $bflex_row_twelve_col_3 . "\n\n\n" .
                $bflex_row_thirteen_col_3 . "\n\n\n" .
                $bflex_row_fourteen_col_3 . "\n\n\n" .
                $bflex_row_fifteen_col_3 . "\n\n\n" .
                $bflex_row_sisteen_col_3 . "\n\n\n" .
                $bflex_row_seventeen_col_3 . "\n\n\n" .
                $bflex_row_eightteen_col_3 . "\n\n\n" .
                $bflex_row_nineteen_col_3 . "\n\n\n" .
                $bflex_row_twenteethree_col_3 . "\n\n\n" .
                $bflex_row_twentee_on_one_col_3 . "\n\n\n";
            // end third 
        }
        // end BARBIFLEX tada table processing 





        fputcsv($output, $data);
        // echo "<pre>";
        // print_r($data);
    }
    fclose($output);
    exit();
}
