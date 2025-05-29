<?php

namespace SEOPressPro\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use SEOPressPro\Services\Options\Schemas\LocalBusinessOptions;
use SEOPressPro\Services\Options\Schemas\PublisherOptions;

class OptionPro {
    use LocalBusinessOptions;
    use PublisherOptions;

    /**
     * @since 4.5.0
     *
     * @return array
     */
    public function getOption() {
        if (is_network_admin() && is_multisite()) {
            return get_option('seopress_pro_mu_option_name');
        } else {
            return get_option('seopress_pro_option_name');
        }
    }

    /**
     * @since 4.5.0
     *
     * @return string|null
     *
     * @param string $key
     */
    protected function searchOptionByKey($key) {
        $data = $this->getOption();

        if (empty($data)) {
            return null;
        }

        if ( ! isset($data[$key])) {
            return null;
        }

        return $data[$key];
    }

    /**
     * @since 4.6.0
     *
     * @return string
     */
    public function getRichSnippetEnable() {
        return $this->searchOptionByKey('seopress_rich_snippets_enable');
    }

    /**
     * @since 4.6.0
     *
     * @return string
     */
    public function getArticlesPublisher() {
        return $this->searchOptionByKey('seopress_social_knowledge_name');
    }

    /**
     * @since 4.6.0
     *
     * @return string
     */
    public function getRichSnippetsSiteNavigation() {
        return $this->searchOptionByKey('seopress_rich_snippets_site_nav');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsSeparator() {
        return $this->searchOptionByKey('seopress_breadcrumbs_separator');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nHere() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_here');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nHome() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_home');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nAuthor() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_author');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18n404() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_404');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nSearch() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_search');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nNoResults() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_no_results');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nAttachments() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_attachments');
    }

    /**
     * @since 6.0.0
     *
     * @return string
     */
    public function getBreadcrumbsI18nPaged() {
        return $this->searchOptionByKey('seopress_breadcrumbs_i18n_paged');
    }

    /**
     * @since 6.0.0
     *
     * @return boolean
     */
    public function getBreadcrumbsRemoveBlogPage() {
        return $this->searchOptionByKey('seopress_breadcrumbs_remove_blog_page');
    }

    /**
     * @since 6.0.0
     *
     * @return boolean
     */
    public function getBreadcrumbsRemoveShopPage() {
        return $this->searchOptionByKey('seopress_breadcrumbs_remove_shop_page');
    }

    /**
     * @since 6.0.0
     *
     * @return boolean
     */
    public function getBreadcrumbsDisableSeparator() {
        return $this->searchOptionByKey('seopress_breadcrumbs_separator_disable');
    }

    /**
     * @since 6.0.0
     *
     * @return boolean
     */
    public function getBreadcrumbsStorefront() {
        return $this->searchOptionByKey('seopress_breadcrumbs_storefront');
    }

    /**
     * @since 6.3.0
     *
     * @return boolean
     */
    public function get404Enable() {
        return $this->searchOptionByKey('seopress_404_enable');
    }

    /**
     * @since 6.3.0
     *
     * @return string
     */
    public function get404RedirectHome() {
        return $this->searchOptionByKey('seopress_404_redirect_home');
    }

    /**
     * @since 6.3.0
     *
     * @return string
     */
    public function get404RedirectUrl() {
        return $this->searchOptionByKey('seopress_404_redirect_custom_url');
    }

    /**
     * @since 6.3.0
     *
     * @return string
     */
    public function get404RedirectStatusCode() {
        return $this->searchOptionByKey('seopress_404_redirect_status_code');
    }

    /**
     * @since 6.3.0
     *
     * @return string
     */
    public function get404RedirectEnableMails() {
        return $this->searchOptionByKey('seopress_404_enable_mails');
    }

    /**
     * @since 6.3.0
     *
     * @return string
     */
    public function get404RedirectEnableMailsFrom() {
        return $this->searchOptionByKey('seopress_404_enable_mails_from');
    }

    /**
     * @since 6.3.0
     *
     * @return string
     */
    public function get404RedirectIpLogging() {
        return $this->searchOptionByKey('seopress_404_ip_logging');
    }

    /**
     * @since 6.3.0
     *
     * @return boolean
     */
    public function get404DisableGuessAutomaticRedirects() {
        return $this->searchOptionByKey('seopress_404_disable_guess_automatic_redirects_404');
    }

    /**
     * @since 6.5.0
     *
     * @return boolean
     */
    public function getRSSDisableCommentsFeed() {
        return $this->searchOptionByKey('seopress_rss_disable_comments_feed');
    }

    /**
     * @since 6.5.0
     *
     * @return boolean
     */
    public function getRSSDisablePostsFeed() {
        return $this->searchOptionByKey('seopress_rss_disable_posts_feed');
    }

    /**
     * @since 6.5.0
     *
     * @return boolean
     */
    public function getRSSDisableExtraFeed() {
        return $this->searchOptionByKey('seopress_rss_disable_extra_feed');
    }

    /**
     * @since 6.5.0
     *
     * @return boolean
     */
    public function getRSSDisableAllFeeds() {
        return $this->searchOptionByKey('seopress_rss_disable_all_feeds');
    }

    /**
     * @since 6.5.0
     *
     * @return boolean
     */
    public function getRSSBeforeHTML() {
        return $this->searchOptionByKey('seopress_rss_before_html');
    }

    /**
     * @since 6.5.0
     *
     * @return boolean
     */
    public function getRSSAfterHTML() {
        return $this->searchOptionByKey('seopress_rss_after_html');
    }

    /**
     * @since 6.5.0
     *
     * @return boolean
     */
    public function getRSSPostThumbnail() {
        return $this->searchOptionByKey('seopress_rss_post_thumbnail');
    }
}
