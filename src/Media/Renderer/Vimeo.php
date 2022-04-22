<?php
namespace Transcript\Media\Renderer;

use Transcript\Media\Renderer\Generic;
use Laminas\View\Renderer\PhpRenderer;
use Omeka\Api\Representation\MediaRepresentation;

class Vimeo extends Generic
{
    public function render(PhpRenderer $view, MediaRepresentation $media, array $options = [])
    {
        $data = $media->mediaData();
        $data['texttracks'] = $this->prepareTextTracks($data['texttracks']);
        
        if (empty($data['links']))
        {
            // File needs to be reimported by admin
            return false;
        }
        
        return $view->partial('common/video-embed', [
            'links' => $data['links'],
            'poster' => $media->thumbnailUrl('large'),
            'texttracks' => $data['texttracks'],
            'default' => $this->getDefaultLanguage($data['texttracks']),
            'color' => $this->settings->get('vimeo_color'),
        ]);
    }
}
?>