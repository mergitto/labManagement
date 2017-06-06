<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Url2Link component
 */
class Url2LinkComponent extends Component
{
    /**
     * @param string $body 処理対象のテキスト
     * @param string|null $link_title リンクテキスト
     * @return string
     */
    public function addLink($body, $link_title = null)
    {
        $pattern = '/(?<!href=")https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/';
        $body = preg_replace_callback($pattern, function($matches) use ($link_title) {
            $link_title = $link_title ?: $matches[0];
            return "<a href=\"{$matches[0]}\">$link_title</a>";
        }, $body);
        return $body;
    }
}
