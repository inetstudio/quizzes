<?php

namespace InetStudio\QuizzesPackage\Questions\Transformers\Front;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\QuizzesPackage\Questions\Contracts\Transformers\Front\PreviewTransformerContract;

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

        $portraitPreview = ($preview)
            ? asset($previewPath.'/conversions/'.pathinfo($preview->file_name, PATHINFO_FILENAME).'-preview_portrait.jpg')
            : null;

        $squarePreview = ($preview)
            ? asset($previewPath.'/conversions/'.pathinfo($preview->file_name, PATHINFO_FILENAME).'-preview_square.jpg')
            : null;

        return [
            'id' => $preview->id ?? 0,
            'src' => [
                'album' => (isset($albumPreview)) ? $albumPreview : asset('assets/img/placeholder.png'),
                'portrait' => (isset($portraitPreview)) ? $portraitPreview : asset('assets/img/placeholder.png'),
                'square' => (isset($squarePreview)) ? $squarePreview : asset('assets/img/placeholder.png'),
            ],
            'alt' => ($preview) ? $preview->getCustomProperty('alt') : '',
            'description' => ($preview) ? $preview->getCustomProperty('description') : '',
            'copyright' => ($preview) ? $preview->getCustomProperty('copyright') : '',
        ];
    }
}
