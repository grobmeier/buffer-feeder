<?php
namespace Grobmeier\Buffer\Feeder;

class TextFormatter
{
    public function format($service, $rssItem)
    {
        $text = $service->text;

        $text = str_replace('%title%', $rssItem->title, $text);
        $text = str_replace('%description%', $rssItem->description, $text);
        $text = str_replace('%author%', $rssItem->author, $text);

        if (isset($service->hashtags)) {
            $text = str_replace('%hashtags%', $service->hashtags, $text);
        }

        if (isset($service->limit)) {
            $text = substr($text, 0, $service->limit);
        }

        $text = str_replace('%url%', $rssItem->link, $text);

        return $text;
    }
}