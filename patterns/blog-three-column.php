<?php
/**
 * Title: Blockify Blog Three Column
 * Slug: blockify/blog-three-column
 * Categories: blog
 * 
 */
?><!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"displayLayout":{"type":"flex","columns":3},"align":"wide","style":{"spacing":{"padding":{"bottom":"5em"},"blockGap":"2em"}},"layout":{"inherit":false}} -->
<div class="wp-block-query alignwide alignwide" style="padding-bottom:5em"><!-- wp:post-template -->
<!-- wp:post-featured-image {"style":{"spacing":{"margin":{"bottom":"1em"}}}} /-->

<!-- wp:post-date {"style":{"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}}} /-->

<!-- wp:post-title {"fontSize":"36"} /-->

<!-- wp:post-excerpt {"moreText":"Read more"} /-->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"align":"center","placeholder":"Add text or blocks that will display when the query returns no results."} -->
<p class="aligncenter has-text-align-center aligncenter"></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->