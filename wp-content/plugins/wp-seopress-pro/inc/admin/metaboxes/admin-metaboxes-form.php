<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

/* Add Generate meta with AI button to Titles settings tab */
add_filter('seopress_titles_title_tab_before', 'seopress_pro_titles_title_tab_before',  10);
function seopress_pro_titles_title_tab_before($pagenow) {
    if ('1' == seopress_get_toggle_option('ai')) {

        if ('post-new.php' == $pagenow || 'post.php' == $pagenow) { ?>
        <div>
            <button id="seopress_ai_generate_seo_meta" class="<?php echo seopress_btn_secondary_classes(); ?>" type="button"><?php _e('Generate meta with AI','wp-seopress-pro'); ?></button>
            <div class="spinner"></div>
        </div>
        <div id="seopress_ai_generate_seo_meta_log" style="display:none"></div>
    <?php }
    }
}

/* Add Google News / Video Sitemap tabs to our SEO metabox */
add_filter('seopress_metabox_seo_tabs', 'seopress_pro_metabox_seo_tabs', 10, 3);
function seopress_pro_metabox_seo_tabs($seo_tabs, $typenow ='', $pagenow ='') {
    if (function_exists('seopress_get_toggle_option') && '1' == seopress_get_toggle_option('news')) {
        if ('post-new.php' == $pagenow || 'post.php' == $pagenow) {
            if ('seopress_404' != $typenow) {
                $seo_tabs['news-tab'] = '<li><a href="#tabs-5">' . __('Google News', 'wp-seopress-pro') . '</a></li>';
            }
        }
    }
    if (function_exists('seopress_get_toggle_option') && '1' == seopress_get_toggle_option('xml-sitemap') && function_exists('seopress_xml_sitemap_video_enable_option') && '1' == seopress_xml_sitemap_video_enable_option()) {
        if ('post-new.php' == $pagenow || 'post.php' == $pagenow) {
            if ('seopress_404' != $typenow) {
                $seo_tabs['video-tab'] = '<li><a href="#tabs-6">' . __('Video Sitemap', 'wp-seopress-pro') . '</a></li>';
            }
        }
    }
    return $seo_tabs;
}

/* Add Google News / Video Sitemap content tabs to our SEO metabox */
add_action('seopress_seo_metabox_after_content', 'seopress_pro_seo_metabox_after_content', 10, 4);
function seopress_pro_seo_metabox_after_content($typenow, $pagenow, $data_attr, $seo_tabs) {
    $seopress_news_disabled                 = get_post_meta($data_attr['current_id'], '_seopress_news_disabled', true);
    $seopress_video_disabled                = get_post_meta($data_attr['current_id'], '_seopress_video_disabled', true);
    $seopress_video                         = get_post_meta($data_attr['current_id'], '_seopress_video');

    if (function_exists('seopress_get_toggle_option') && '1' == seopress_get_toggle_option('news')) {
        if ('post-new.php' == $pagenow || 'post.php' == $pagenow) {
            if ('seopress_404' != $typenow) {
                if (array_key_exists('news-tab', $seo_tabs)) { ?>
            <div id="tabs-5">
                <p>
                    <label for="seopress_news_disabled_meta" id="seopress_news_disabled">
                        <input type="checkbox" name="seopress_news_disabled" id="seopress_news_disabled_meta"
                            value="yes" <?php echo checked($seopress_news_disabled, 'yes', false); ?>
                        />
                        <?php _e('Exclude this post from Google News Sitemap?', 'wp-seopress-pro'); ?>
                    </label>
                </p>
            </div>
            <?php }
            }
        }
    }
    if (function_exists('seopress_get_toggle_option') && '1' == seopress_get_toggle_option('xml-sitemap') && function_exists('seopress_xml_sitemap_video_enable_option') && '1' == seopress_xml_sitemap_video_enable_option()) {
        if ('post-new.php' == $pagenow || 'post.php' == $pagenow) {
            if ('seopress_404' != $typenow) {
                //Init $seopress_video array if empty
                if (empty($seopress_video)) {
                    $seopress_video = ['0' => ['']];
                }

                $count = $seopress_video[0];

                $total = '';
                if (is_array($count)) {
                    end($count);
                    $total = key($count);
                }

                if (array_key_exists('video-tab', $seo_tabs)) { ?>
            <div id="tabs-6">
                <p>
                    <?php _e('YouTube videos are automatically added when you create / save a post, page or post type.','wp-seopress-pro'); ?>
                </p>
                <p>
                    <label for="seopress_video_disabled_meta" id="seopress_video_disabled">
                        <input type="checkbox" name="seopress_video_disabled" id="seopress_video_disabled_meta"
                            value="yes" <?php echo checked($seopress_video_disabled, 'yes', false); ?>
                        />
                        <?php _e('Exclude this post from Video Sitemap?', 'wp-seopress-pro'); ?>
                    </label>
                    <span class="description"><?php _e('If your post is set to noindex, it will be automatically excluded from the sitemap.', 'wp-seopress-pro'); ?></span>
                </p>
                <div id="wrap-videos"
                    data-count="<?php echo $total; ?>">
                    <?php foreach ($seopress_video[0] as $key => $value) {
                    $check_url             = isset($seopress_video[0][$key]['url']) ? esc_attr($seopress_video[0][$key]['url']) : null;
                    $check_internal_video  = isset($seopress_video[0][$key]['internal_video']) ? esc_attr($seopress_video[0][$key]['internal_video']) : null;
                    $check_title           = isset($seopress_video[0][$key]['title']) ? esc_attr($seopress_video[0][$key]['title']) : null;
                    $check_desc            = isset($seopress_video[0][$key]['desc']) ? esc_attr($seopress_video[0][$key]['desc']) : null;
                    $check_thumbnail       = isset($seopress_video[0][$key]['thumbnail']) ? esc_attr($seopress_video[0][$key]['thumbnail']) : null;
                    $check_duration        = isset($seopress_video[0][$key]['duration']) ? esc_attr($seopress_video[0][$key]['duration']) : null;
                    $check_rating          = isset($seopress_video[0][$key]['rating']) ? esc_attr($seopress_video[0][$key]['rating']) : null;
                    $check_view_count      = isset($seopress_video[0][$key]['view_count']) ? esc_attr($seopress_video[0][$key]['view_count']) : null;
                    $check_view_count      = isset($seopress_video[0][$key]['view_count']) ? esc_attr($seopress_video[0][$key]['view_count']) : null;
                    $check_tag             = isset($seopress_video[0][$key]['tag']) ? esc_attr($seopress_video[0][$key]['tag']) : null;
                    $check_family_friendly = isset($seopress_video[0][$key]['family_friendly']) ? esc_attr($seopress_video[0][$key]['family_friendly']) : null; ?>

                    <div class="video">
                        <h3 class="accordion-section-title" tabindex="0"><?php _e('Video ', 'wp-seopress-pro'); ?><?php echo $check_title; ?>
                        </h3>
                        <div class="accordion-section-content">
                            <p>
                                <label
                                    for="seopress_video[<?php echo $key; ?>][url_meta]"><?php _e('Video URL (required)', 'wp-seopress-pro'); ?></label>
                                <input
                                    id="seopress_video[<?php echo $key; ?>][url_meta]"
                                    type="text" class="components-text-control__input"
                                    name="seopress_video[<?php echo $key; ?>][url]"
                                    placeholder="<?php esc_html_e('Enter your video URL', 'wp-seopress-pro'); ?>"
                                    aria-label="<?php _e('Video URL', 'wp-seopress-pro'); ?>"
                                    value="<?php echo $check_url; ?>" />
                            </p>
                            <p class="internal_video">
                                <label
                                    for="seopress_video[<?php echo $key; ?>][internal_video_meta]"
                                    id="seopress_video[<?php echo $key; ?>][internal_video]">
                                    <input type="checkbox"
                                        name="seopress_video[<?php echo $key; ?>][internal_video]"
                                        id="seopress_video[<?php echo $key; ?>][internal_video_meta]"
                                        value="yes" <?php echo checked($check_internal_video, 'yes', false); ?>
                                    />
                                    <?php _e('NOT an external video (eg: video hosting on YouTube, Vimeo, Wistia...)? Check this if your video is hosting on this server.', 'wp-seopress-pro'); ?>
                                </label>
                            </p>
                            <p>
                                <label
                                    for="seopress_video[<?php echo $key; ?>][title_meta]"><?php _e('Video Title (required)', 'wp-seopress-pro'); ?></label>
                                <input
                                    id="seopress_video[<?php echo $key; ?>][title_meta]"
                                    type="text" class="components-text-control__input"
                                    name="seopress_video[<?php echo $key; ?>][title]"
                                    placeholder="<?php esc_html_e('Enter your video title', 'wp-seopress-pro'); ?>"
                                    aria-label="<?php _e('Video title', 'wp-seopress-pro'); ?>"
                                    value="<?php echo $check_title; ?>" />
                                <span class="description"><?php _e('Default: title tag, if not available, post title.', 'wp-seopress-pro'); ?></span>
                            </p>
                            <p>
                                <label
                                    for="seopress_video[<?php echo $key; ?>][desc_meta]"><?php _e('Video Description (required)', 'wp-seopress-pro'); ?></label>
                                <textarea
                                    id="seopress_video[<?php echo $key; ?>][desc_meta]"
                                    name="seopress_video[<?php echo $key; ?>][desc]"
                                    class="components-text-control__input"
                                    placeholder="<?php esc_html_e('Enter your video description', 'wp-seopress-pro'); ?>"
                                    aria-label="<?php _e('Video description', 'wp-seopress-pro'); ?>"><?php echo $check_desc; ?></textarea>
                                <span class="description"><?php _e('2048 characters max.; default: meta description. If not available, use the beginning of the post content.', 'wp-seopress-pro'); ?></span>
                            </p>
                            <p>
                                <label
                                    for="seopress_video[<?php echo $key; ?>][thumbnail_meta]"><?php _e('Video Thumbnail (required)', 'wp-seopress-pro'); ?></label>

                                <input
                                    id="seopress_video[<?php echo $key; ?>][thumbnail_meta]"
                                    class="seopress_video_thumbnail_meta components-text-control__input"
                                    type="text"
                                    name="seopress_video[<?php echo $key; ?>][thumbnail]"
                                    placeholder="<?php esc_html_e('Select your video thumbnail', 'wp-seopress-pro'); ?>"
                                    value="<?php echo $check_thumbnail; ?>" />


                                <input
                                    class="<?php echo seopress_btn_secondary_classes(); ?> seopress_video_thumbnail_upload seopress_media_upload"
                                    type="button"
                                    aria-label="<?php _e('Video Thumbnail', 'wp-seopress-pro'); ?>"
                                    value="<?php _e('Upload an Image', 'wp-seopress-pro'); ?>" />
                                <span class="description">
                                    <?php _e('Minimum size: 160x90px (1920x1080 max), JPG, PNG or GIF formats. Default: your post featured image.', 'wp-seopress-pro'); ?>
                                </span>
                            </p>
                            <p>
                                <label
                                    for="seopress_video[<?php echo $key; ?>][duration_meta]"><?php _e('Video Duration (recommended)', 'wp-seopress-pro'); ?></label>
                                <input
                                    id="seopress_video[<?php echo $key; ?>][duration_meta]"
                                    type="number" step="1" min="0" max="28800"
                                    name="seopress_video[<?php echo $key; ?>][duration]"
                                    placeholder="<?php esc_html_e('Duration in seconds', 'wp-seopress-pro'); ?>"
                                    aria-label="<?php _e('Video duration', 'wp-seopress-pro'); ?>"
                                    value="<?php echo $check_duration; ?>" />
                                <span class="description"><?php _e('The duration of the video in seconds. Value must be between 0 and 28800 (8 hours).', 'wp-seopress-pro'); ?></span>
                            </p>
                            <p>
                                <label
                                    for="seopress_video[<?php echo $key; ?>][rating_meta]"><?php _e('Video Rating', 'wp-seopress-pro'); ?></label>
                                <input
                                    id="seopress_video[<?php echo $key; ?>][rating_meta]"
                                    type="number" step="0.1" min="0" max="5"
                                    name="seopress_video[<?php echo $key; ?>][rating]"
                                    placeholder="<?php esc_html_e('Video rating', 'wp-seopress-pro'); ?>"
                                    aria-label="<?php _e('Video rating', 'wp-seopress-pro'); ?>"
                                    value="<?php echo $check_rating; ?>" />
                                <span class="description"><?php _e('Allowed values are float numbers in the range 0.0 to 5.0.', 'wp-seopress-pro'); ?></span>
                            </p>
                            <p>
                                <label
                                    for="seopress_video[<?php echo $key; ?>][view_count_meta]"><?php _e('View count', 'wp-seopress-pro'); ?></label>
                                <input
                                    id="seopress_video[<?php echo $key; ?>][view_count_meta]"
                                    type="number"
                                    name="seopress_video[<?php echo $key; ?>][view_count]"
                                    placeholder="<?php esc_html_e('Number of views', 'wp-seopress-pro'); ?>"
                                    aria-label="<?php _e('View count', 'wp-seopress-pro'); ?>"
                                    value="<?php echo $check_view_count; ?>" />
                            </p>
                            <p>
                                <label
                                    for="seopress_video[<?php echo $key; ?>][tag_meta]"><?php _e('Video tags', 'wp-seopress-pro'); ?></label>
                                <input
                                    id="seopress_video[<?php echo $key; ?>][tag_meta]"
                                    type="text" class="components-text-control__input"
                                    name="seopress_video[<?php echo $key; ?>][tag]"
                                    placeholder="<?php esc_html_e('Enter your video tags', 'wp-seopress-pro'); ?>"
                                    aria-label="<?php _e('Video tags', 'wp-seopress-pro'); ?>"
                                    value="<?php echo $check_tag; ?>" />
                                <span class="description"><?php _e('32 tags max., separate tags with commas. Default: target keywords + post tags if available.', 'wp-seopress-pro'); ?></span>
                            </p>
                            <p class="family-friendly">
                                <label
                                    for="seopress_video[<?php echo $key; ?>][family_friendly_meta]"
                                    id="seopress_video[<?php echo $key; ?>][family_friendly]">
                                    <input type="checkbox"
                                        name="seopress_video[<?php echo $key; ?>][family_friendly]"
                                        id="seopress_video[<?php echo $key; ?>][family_friendly_meta]"
                                        value="yes" <?php echo checked($check_family_friendly, 'yes', false); ?>
                                    />
                                    <?php _e('NOT family friendly?', 'wp-seopress-pro'); ?>
                                </label>
                                <span class="description"><?php _e('The video will be available only to users with SafeSearch turned off.', 'wp-seopress-pro'); ?></span>
                            </p>
                            <p><a href="#"
                                    class="remove-video components-button editor-post-trash is-tertiary is-destructive"><?php _e('Remove video', 'wp-seopress-pro'); ?></a>
                            </p>
                        </div>
                    </div>
                    <?php
                } ?>
                </div>
                <p>
                    <a href="#" id="add-video"
                        class="add-video <?php echo seopress_btn_secondary_classes(); ?>">
                        <?php _e('Add video', 'wp-seopress-pro'); ?>
                    </a>
                </p>
            </div>
            <?php }
            }
        }
    }
}

/* Save our Custom Breadcrumbs / Google News / Video sitemap meta */
add_action('seopress_seo_metabox_save', 'seopress_pro_seo_metabox_save', 10, 2);
function seopress_pro_seo_metabox_save($post_id, $seo_tabs) {
    if (!empty($_POST['seopress_robots_breadcrumbs'])) {
        update_post_meta($post_id, '_seopress_robots_breadcrumbs', esc_html($_POST['seopress_robots_breadcrumbs']));
    } else {
        delete_post_meta($post_id, '_seopress_robots_breadcrumbs');
    }

    if (did_action('elementor/loaded')) {
        $elementor = get_post_meta($post_id, '_elementor_page_settings', true);

        if (! empty($elementor)) {
            if (isset($_POST['seopress_robots_breadcrumbs'])) {
                $elementor['_seopress_robots_breadcrumbs'] = esc_html($_POST['seopress_robots_breadcrumbs']);
            }
        }
    }

    if (in_array('news-tab', $seo_tabs)) {
        if (isset($_POST['seopress_news_disabled'])) {
            update_post_meta($post_id, '_seopress_news_disabled', 'yes');
        } else {
            delete_post_meta($post_id, '_seopress_news_disabled', '');
        }
    }
    if (in_array('video-tab', $seo_tabs)) {
        if (isset($_POST['seopress_video_disabled'])) {
            update_post_meta($post_id, '_seopress_video_disabled', 'yes');
        } else {
            delete_post_meta($post_id, '_seopress_video_disabled', '');
        }
        if (!empty($_POST['seopress_video'])) {
            update_post_meta($post_id, '_seopress_video', $_POST['seopress_video']);
        } else {
            delete_post_meta($post_id, '_seopress_video');
        }
    }
}

/* Save our Custom Breadcrumbs term meta */
add_action('seopress_seo_metabox_term_save', 'seopress_pro_seo_metabox_term_save', 10, 2);
function seopress_pro_seo_metabox_term_save($term_id, $term) {
    if (!empty($term['seopress_robots_breadcrumbs'])) {
        update_term_meta($term_id, '_seopress_robots_breadcrumbs', esc_html($term['seopress_robots_breadcrumbs']));
    } else {
        delete_term_meta($term_id, '_seopress_robots_breadcrumbs');
    }
}

/* Add Custom Breadcrumbs to Robots tab, SEO metabox */
add_action('seopress_titles_title_tab_after', 'seopress_pro_titles_title_tab_after', 10, 2);
function seopress_pro_titles_title_tab_after($pagenow, $data_attr) {
        if ('term.php' == $pagenow || 'edit-tags.php' == $pagenow) {
            $seopress_robots_breadcrumbs   = get_term_meta($data_attr['termId'], '_seopress_robots_breadcrumbs', true);
        } else {
            $seopress_robots_breadcrumbs   = get_post_meta($data_attr['current_id'], '_seopress_robots_breadcrumbs', true);
        }
    ?>
    <p>
        <label for="seopress_robots_breadcrumbs_meta"><?php _e('Custom breadcrumbs', 'wp-seopress-pro'); ?></label>
        <span class="description"><?php _e('Enter a custom value, useful if your title is too long', 'wp-seopress-pro'); ?></span>
    </p>
    <p>
        <input id="seopress_robots_breadcrumbs_meta" type="text" name="seopress_robots_breadcrumbs"
            class="components-text-control__input"
            placeholder="<?php esc_html_e(sprintf(__('Current breadcrumbs: %s', 'wp-seopress-pro'), $data_attr['title'])); ?>"
            aria-label="<?php _e('Custom breadcrumbs', 'wp-seopress-pro'); ?>"
            value="<?php echo $seopress_robots_breadcrumbs; ?>" />
    </p>
    <?php
}
