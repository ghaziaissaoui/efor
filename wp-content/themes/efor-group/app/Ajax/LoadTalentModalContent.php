<?php

declare(strict_types=1);

namespace App\Ajax;

use App\Core\AjaxRequest;
use App\Services\TalentFormatterService;

class LoadTalentModalContent extends AjaxRequest
{
    protected string $action = 'load-talent-modal-content';

    protected string $scope = self::SCOPE_NOPRIV;
    private TalentFormatterService $talentFormatterService;

    public function __construct(TalentFormatterService $talentFormatterService)
    {
        $this->talentFormatterService = $talentFormatterService;
    }
    /**
     * Cette fonction execute la logique back de votre requête AJAX
     */
    protected function execute(): void
    {
        if (isset($_POST['postId'])) {
            $post = get_post($_POST['postId']);

            if (empty($post)) {
                wp_send_json_error(__('Post doesn\'t exist', 'cosavostra'));
            }

            $modalContent = $this->talentFormatterService->formatTalentModal($post);

            wp_send_json_success($modalContent);
        }

        wp_send_json_error(__('Missing post id', 'cosavostra'));
    }
}
