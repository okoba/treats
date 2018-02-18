<?php
/**
 * single Post template 13
 **/

if (have_posts()) {
    the_post();

    $td_mod_single = new td_module_single($post);

    ?>




        <div class="td-post-content">
            <?php
            // override the default featured image by the templates (single.php and home.php/index.php - blog loop)
            if (!empty(td_global::$load_featured_img_from_template)) {
                echo $td_mod_single->get_image(td_global::$load_featured_img_from_template);
            } else {
                echo $td_mod_single->get_image('td_696x0');
            }
            ?>

            <?php echo $td_mod_single->get_content();?>
        </div>

        <div class="food-network">
        <h2>Recipe of the Day</h2>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/yCRAgMRh_DM" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
        </div>
 
        <footer>
            <?php echo $td_mod_single->get_post_pagination();?>
            <?php echo $td_mod_single->get_review();?>

            <div class="td-post-source-tags">
                <?php echo $td_mod_single->get_source_and_via();?>
                <?php echo $td_mod_single->get_the_tags();?>
            </div>

            <?php echo $td_mod_single->get_social_sharing_bottom();?>
            <?php echo $td_mod_single->get_next_prev_posts();?>
            <?php echo $td_mod_single->get_author_box();?>
<!-- Composite Start -->
<div id="M311842ScriptRootC204566">
        <div id="M311842PreloadC204566">
        Loading...    </div>
        <script>
                (function(){
            var D=new Date(),d=document,b='body',ce='createElement',ac='appendChild',st='style',ds='display',n='none',gi='getElementById';
            var i=d[ce]('iframe');i[st][ds]=n;d[gi]("M311842ScriptRootC204566")[ac](i);try{var iw=i.contentWindow.document;iw.open();iw.writeln("<ht"+"ml><bo"+"dy></bo"+"dy></ht"+"ml>");iw.close();var c=iw[b];}
            catch(e){var iw=d;var c=d[gi]("M311842ScriptRootC204566");}var dv=iw[ce]('div');dv.id="MG_ID";dv[st][ds]=n;dv.innerHTML=204566;c[ac](dv);
            var s=iw[ce]('script');s.async='async';s.defer='defer';s.charset='utf-8';s.src="//jsc.mgid.com/t/r/treats.co.ke.204566.js?t="+D.getYear()+D.getMonth()+D.getDate()+D.getHours();c[ac](s);})();
    </script>
</div>
<!-- Composite End -->
	        <?php echo $td_mod_single->get_item_scope_meta();?>
        </footer>

    <?php echo $td_mod_single->related_posts();?>
                <div class="disqus-treats">
             <h2>Join The Conversation</h2>
             <div id="disqus_thread"></div>
<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = '<?php echo get_permalink(); ?>';
this.page.identifier ='<?php echo the_ID(); ?>';
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://treats-co-ke.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            </div>         

<?php
} else {
    //no posts
    echo td_page_generator::no_posts();
}
