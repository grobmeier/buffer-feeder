<?php
/**
 * Copyright 2015 Christian Grobmeier
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
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
