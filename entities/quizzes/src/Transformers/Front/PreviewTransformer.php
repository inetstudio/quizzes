<?php

namespace InetStudio\QuizzesPackage\Quizzes\Transformers\Front;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Transformers\Front\PreviewTransformerContract;

/**
 * Class PreviewTransformer.
 */
class PreviewTransformer extends BaseTransformer implements PreviewTransformerContract
{
    /**
     * Трансфорация данных.
     *
     * @param $item
     *
     * @return array
     */
    public function transform($item): array
    {
        $preview = $item->media->where('collection_name', 'preview')->first();
        $previewPath = ($preview) ? dirname($preview->getUrl()) : '';

        $albumPreview = ($preview)
            ? asset($previewPath.'/conversions/'.pathinfo($preview->file_name, PATHINFO_FILENAME).'-preview_album.jpg')
            : null;

        return [
            'id' => $preview->id ?? 0,
            'src' => [
                'album' => (isset($albumPreview)) ? $albumPreview : asset('assets/img/placeholder.png'),
            ],
            'alt' => ($preview) ? $preview->getCustomProperty('alt') : '',
            'description' => ($preview) ? $preview->getCustomProperty('description') : '',
            'copyright' => ($preview) ? $preview->getCustomProperty('copyright') : '',
        ];
    }
}
