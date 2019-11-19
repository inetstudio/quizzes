<?php

return [

    /*
     * Настройки изображений
     */

    'images' => [
        'quality' => 75,
        'conversions' => [
            'quiz' => [
                'preview' => [
                    'album' => [
                        [
                            'name' => 'preview_album',
                            'size' => [
                                'width' => 392,
                                'height' => 294,
                            ],
                        ],
                    ],
                ],
                'description' => [
                    'default' => [
                        [
                            'name' => 'description_admin',
                            'size' => [
                                'width' => 140,
                            ],
                        ],
                        [
                            'name' => 'description_front',
                            'quality' => 70,
                            'fit' => [
                                'width' => 768,
                                'height' => 512,
                            ],
                        ],
                    ],
                ],
            ],
            'question' => [
                'preview' => [
                    'album' => [
                        [
                            'name' => 'preview_album',
                            'size' => [
                                'width' => 448,
                                'height' => 336,
                            ],
                        ],
                    ],
                    'portrait' => [
                        [
                            'name' => 'preview_portrait',
                            'size' => [
                                'width' => 448,
                                'height' => 620,
                            ],
                        ],
                    ],
                    'square' => [
                        [
                            'name' => 'preview_square',
                            'size' => [
                                'width' => 448,
                                'height' => 448,
                            ],
                        ],
                    ],
                ],
            ],
            'answer' => [
                'preview' => [
                    'album' => [
                        [
                            'name' => 'preview_album',
                            'size' => [
                                'width' => 190,
                                'height' => 178,
                            ],
                        ],
                    ],
                ],
                'description' => [
                    'default' => [
                        [
                            'name' => 'description_admin',
                            'size' => [
                                'width' => 140,
                            ],
                        ],
                        [
                            'name' => 'description_front',
                            'quality' => 70,
                            'fit' => [
                                'width' => 768,
                                'height' => 512,
                            ],
                        ],
                    ],
                ],
            ],
            'result' => [
                'preview' => [
                    'album' => [
                        [
                            'name' => 'preview_album',
                            'size' => [
                                'width' => 448,
                                'height' => 336,
                            ],
                        ],
                    ],
                ],
                'short_description' => [
                    'default' => [
                        [
                            'name' => 'short_description_admin',
                            'size' => [
                                'width' => 140,
                            ],
                        ],
                        [
                            'name' => 'short_description_front',
                            'quality' => 70,
                            'fit' => [
                                'width' => 768,
                                'height' => 512,
                            ],
                        ],
                    ],
                ],
                'full_description' => [
                    'default' => [
                        [
                            'name' => 'full_description_admin',
                            'size' => [
                                'width' => 140,
                            ],
                        ],
                        [
                            'name' => 'full_description_front',
                            'quality' => 70,
                            'fit' => [
                                'width' => 768,
                                'height' => 512,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
