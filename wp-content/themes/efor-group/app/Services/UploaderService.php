<?php

declare(strict_types=1);

namespace App\Services;

class UploaderService
{
    private const DEFAULT_IMAGE_MIME_TYPES = [
        'image/png',
        'image/jpeg',
        'image/jpg'
    ];

    /**
     * Loop files to upload and return complete list of uploadIds
     */
    public function uploadLoop(
        array $files,
        ?string $uploadDirName = null,
        array $authorizedMimeTypes = self::DEFAULT_IMAGE_MIME_TYPES
    ): array {
        $uploadIds = [];

        if (empty($files)) {
            return $uploadIds;
        }

        $uploadDirPath = $this->getWordpressUploadDir($uploadDirName);

        foreach ($files as $file) {
            if ($upload_id = $this->createMedia($file, $authorizedMimeTypes, $uploadDirPath)) {
                array_push($uploadIds, $upload_id);
            }
        }

        return $uploadIds;
    }

    /**
     * Insert new image in wordpress media library
     * @return int|false
     */
    private function createMedia(array $file, array $authorizedMimeTypes, string $uploadDirPath)
    {
        // Hookable before create media
        do_action('cv_before_uploaderService_createMedia', $file);

        /**
         * If user is trying to insert something else than authorized mime types
         */
        if (!in_array($file['type'], $authorizedMimeTypes)) {
            return false;
        }

        $uploadId = $this->uploadMedia($file, $uploadDirPath);

        // Hookable after create media
        do_action('cv_after_uploaderService_createMedia', $file, $uploadId);

        return $uploadId;
    }

    /**
     * @return int|false
     */
    private function uploadMedia(array $file, string $uploadDirPath)
    {
        if (!file_exists($uploadDirPath)) {
            mkdir($uploadDirPath);
        }

        $newFilePath = $uploadDirPath . $file['name'];

        $i = 1; // number of tries when another file with same name already exists

        // If file already exist prepend an int on file name
        while (file_exists($newFilePath)) {
            $i++;
            $newFilePath = sprintf(
                '%s%s_%d',
                $uploadDirPath,
                $file['name'],
                $i,
            );
        }

        // If we do not succeed to rename our uploaded file
        if (!move_uploaded_file($file['tmp_name'], $newFilePath)) {
            return false;
        }

        $uploadId = wp_insert_attachment(
            [
                'guid' => $newFilePath,
                'post_mime_type' => mime_content_type($newFilePath),
                'post_title' => preg_replace('/\.[^.]+$/', '', $file['name']),
                'post_content' => '',
                'post_status' => 'inherit'
            ],
            $newFilePath
        );

        // If the upload has failed
        if (is_wp_error($uploadId)) {
            return false;
        }

        // wp_generate_attachment_metadata() won't work if we do not include this file
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Generate and save the attachment metas into the database
        wp_update_attachment_metadata(
            $uploadId,
            wp_generate_attachment_metadata($uploadId, $newFilePath)
        );

        return $uploadId;
    }

    public function getWordpressUploadDir(?string $customDirectory = null): string
    {
        if (null === $customDirectory) {
            // Get base media path
            $uploadDir = wp_upload_dir()['path'];
        } else {
            // Get custom directory path
            $uploadDir = wp_upload_dir()['basedir'] . '/' . $customDirectory;
        }

        // Make sure we have a / at the end of our path
        if (substr($uploadDir, -1) !== '/') {
            $uploadDir .= '/';
        }

        return $uploadDir;
    }
}
