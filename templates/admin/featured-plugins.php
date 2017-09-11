<?php
/**
 * Template for featured plugins page
 */

?>
<div class="wrap gdfrm_featured_plugins_container">
    <div class="gdfrm_header">
        <i class="gdicon gdicon-logo"></i>
        <span><?php _e('GrandWP Plugins',GDFRM_TEXT_DOMAIN);?></span>

        <ul>
            <li>
                <a href="http://grandwp.com/wordpress-contact-form-builder" target="_blank"><?php _e('Go Pro',GDFRM_TEXT_DOMAIN);?></a>
            </li>
            <li>
                <a href="http://grandwp.com/grandwp-forms-user-manual" target="_blank"><?php _e('Help',GDFRM_TEXT_DOMAIN);?></a>
            </li>
        </ul>
    </div>

    <div class="gdfrm_content">


        <div class="single-plugin">
            <div class="plugin-thumb">
                <img src="<?php echo GDFRM_IMAGES_URL.'/gwpcalendar.png';?>">
            </div>
            <div class="plugin-info">
                <div class="plugin-name">GrandWP Calendar</div>
                <div class="plugin-desc">
                    Calendar  - Advanced and user-friendly Calendar for WordPress gives a variety of
                    options and powerful event management tools for WordPress users. It’s intuitive
                    user interface makes it super easy to use. You can easily add events, sort them into
                    categories / tags and choose from calendar displays. You can also display your event
                    venues using Google Maps right along the event details. The powerful configuration
                    options give you full control on the display of your calendar and events. Add colorful
                    widgets and more.
                </div>
                <div class="plugin-buttons">
                    <a href="http://grandwp.com/wordpress-event-calendar" target="_blank">
                        <?php _e('Try Free',GDFRM_TEXT_DOMAIN);?>
                    </a>
                    <a href="http://demo.grandwp.com/wordpress-event-calendar-demo/" target="_blank">
                        <?php _e('Demo',GDFRM_TEXT_DOMAIN);?>
                    </a>
                </div>
            </div>
        </div>

        <div class="single-plugin">
            <div class="plugin-thumb">
                <img src="<?php echo GDFRM_IMAGES_URL.'/gwplightbox.png';?>" alt="Plugin Icon" />
            </div>
            <div class="plugin-info">
                <div class="plugin-name">GrandWP Lightbox</div>
                <div class="plugin-desc">
                    Lightbox - Grand LIghtbox is offering a quick and simple lightbox for your pages
                    and posts. It comes with friendly appearance and wide range of settings as the
                    aforementioned plugins, but if you’re looking for a minimalist way of opening
                    your images in a lightbox style, you’ll love this one. GrandLightbox allows you
                    to add beautiful features. You can display an image separately or in a slideshow,
                    and youcan also set the transitions, animations, slideshows’ speed, overlay opacity, etc.
                </div>
                <div class="plugin-buttons">
                    <a href="http://grandwp.com/wordpress-responsive-lightbox" target="_blank">
                        <?php _e('Try Free',GDFRM_TEXT_DOMAIN);?>
                    </a>
                    <a href="http://demo.grandwp.com/wordpress-responsive-lightbox-demo/" target="_blank">
                        <?php _e('Demo',GDFRM_TEXT_DOMAIN);?>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
