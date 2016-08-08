<?php

global $wp_query;

?>

<?php
/*
$num_pag = $wp_query->max_num_pages;
//var_dump(($num_pag));


*/?><!--

<?php /*if (isset($wp_query) && $wp_query->max_num_pages > 1 )  : */?>

    <div class="ct-u-marginBoth20 ct-pagination">
        <ul class="pagination pagination-lg">

            <?php /*if ($paged != 0): */?>
                <li class="right">
                    <a href="<?php /*echo get_previous_posts_page_link(); */?>">
                        <i class="fa fa-chevron-left"></i></a>
                </li>
            <?php /*else: */?>
                <li class="left disabled">
                    <a >
                        <i class="fa fa-chevron-left"></i>
                    </a>
                </li>
            <?php /*endif; */?>


            <?php
/*            if ($wp_query->max_num_pages>3):
            $wp_query->max_num_pages=3;
            $a = $wp_query->max_num_pages;
            endif;
            */?>

            <?php /*for ($i = 1; $i <= $wp_query->max_num_pages; $i++) { */?>
                <?php /*if ($paged == $i): */?>
                    <li class="active"><a><?php /*echo (int)$i; */?></a></li>
                <?php /*else: */?>
                    <li><a href=" <?php /*echo esc_url(get_pagenum_link($i)); */?>"><?php /*echo (int)$i; */?></a></li>
                <?php /*endif */?>
            <?php /*} */?>


            <?php /*if ($paged != $wp_query->max_num_pages): */?>
                <li class="right">
                    <a href=" <?php /*echo get_next_posts_page_link() */?>">
                        <i class="fa fa-chevron-right"></i></a>
                </li>

            <?php /*else: */?>
                <li class="left disabled">
                    <a >
                        <i class="fa fa-chevron-right"></i></a></li>
            <?php /*endif; */?>

        </ul>
           </div>
    <!-- / pagination -->

    <?php /*if (false): */?><?php /*posts_nav_link(); */?><?php /*endif; */?>
<?php /*endif; */?>



<?php


if( is_singular() )
return;

global $wp_query;

/** Stop execution if there's only 1 page */
if( $wp_query->max_num_pages <= 1 )
return;

$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$max   = intval( $wp_query->max_num_pages );

/**	Add current page to the array */
if ( $paged >= 1 )
$links[] = $paged;

/**	Add the pages around the current page to the array */
//se quisermos ter + do que 1 previous page
if ( $paged >= 3 ) {
$links[] = $paged - 1;
//$links[] = $paged - 2;
}
//se quisermos ter + do que 1 next page
if ( ( $paged + 2 ) <= $max ) {
//$links[] = $paged + 2;
$links[] = $paged + 1;
}

echo '<div class="ct-u-marginBoth20 ct-pagination"><ul class="pagination pagination-lg">' . "\n";

/**	Previous Post Link */


printf( '<li class="right">%s</li>' . "\n", get_previous_posts_link('<i class="fa fa-chevron-left"></i>') );

/**	Link to first page, plus ellipses if necessary */
if ( ! in_array( 1, $links ) ) {
$class = 1 == $paged ? ' class="active"' : '';
//se quiseremos mostrar a primeira pagina
if($paged==2){
printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
}

if ( ! in_array( 2, $links ) )
echo '<li></li>';
}

/**	Link to current page, plus 2 pages in either direction if necessary */
sort( $links );
foreach ( (array) $links as $link ) {
$class = $paged == $link ? ' class="active"' : '';
printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
}

/**	Link to last page, plus ellipses if necessary */
if ( ! in_array( $max, $links ) ) {
if ( ! in_array( $max - 1, $links ) )
echo '<li></li>' . "\n";

$class = $paged == $max ? ' class="active"' : '';
//se quisermos mostrar a ultima pagina
//printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
}

if($paged==$max-1){
printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
}

/**	Next Post Link */
if ( get_next_posts_link() )
printf( '<li class="right">%s</li>' . "\n", get_next_posts_link('<i class="fa fa-chevron-right"></i>') );

echo '</ul></div>' . "\n";




?>

