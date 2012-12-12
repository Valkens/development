<?php
class Default_Controller_IndexController extends Core_Controller
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'Home page';

        $uri = 'http://vnexpress.net';

        $client = new Zend_Http_Client($uri, array(
            'maxredirects' => 2,
            'timeout'      => 10,
        ));

        // Try to mimic the requesting user's UA
        $client->setHeaders(array(
            'User-Agent' => $_SERVER['HTTP_USER_AGENT'],
            'X-Powered-By' => 'Zend Framework'
        ));

        $response = $client->request();


        $this->_data['contentType'] =  $response->getBody();
        $this->_previewHtml($uri, $response);
    }

    protected function _previewHtml($uri, Zend_Http_Response $response)
    {
        $body = $response->getBody();
        $body = trim($body);
        if( preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getHeader('content-type'), $matches) ||
            preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getBody(), $matches) ) {
            $this->_data['charset'] = $charset = trim($matches[1]);
        } else {
            $this->_data['charset'] = $charset = 'UTF-8';
        }

        // Get DOM
        if( class_exists('DOMDocument') ) {
            $dom = new Zend_Dom_Query($body);
        } else {
            $dom = null; // Maybe add b/c later
        }

        $title = null;
        if( $dom ) {
            $titleList = $dom->query('title');
            if( count($titleList) > 0 ) {
                $title = trim($titleList->current()->textContent);
                $title = substr($title, 0, 255);
            }
        }
        $this->_data['title'] = $title;

        $description = null;
        if( $dom ) {
            $descriptionList = $dom->queryXpath("//meta[@name='description']");
            // Why are they using caps? -_-
            if( count($descriptionList) == 0 ) {
                $descriptionList = $dom->queryXpath("//meta[@name='Description']");
            }
            if( count($descriptionList) > 0 ) {
                $description = trim($descriptionList->current()->getAttribute('content'));
                $description = substr($description, 0, 255);
            }
        }
        $this->_data['description'] = $description;

        $thumb = null;
        if( $dom ) {
            $thumbList = $dom->queryXpath("//link[@rel='image_src']");
            if( count($thumbList) > 0 ) {
                $thumb = $thumbList->current()->getAttribute('href');
            }
        }
        $this->_data['thumb'] = $thumb;

        $medium = null;
        if( $dom ) {
            $mediumList = $dom->queryXpath("//meta[@name='medium']");
            if( count($mediumList) > 0 ) {
                $medium = $mediumList->current()->getAttribute('content');
            }
        }
        $this->_data['medium'] = $medium;

        // Get baseUrl and baseHref to parse . paths
        $baseUrlInfo = parse_url($uri);
        $baseUrl = null;
        $baseHostUrl = null;
        if( $dom ) {
            $baseUrlList = $dom->query('base');
            if( $baseUrlList && count($baseUrlList) > 0 && $baseUrlList->current()->getAttribute('href') ) {
                $baseUrl = $baseUrlList->current()->getAttribute('href');
                $baseUrlInfo = parse_url($baseUrl);
                $baseHostUrl = $baseUrlInfo['scheme'].'://'.$baseUrlInfo['host'].'/';
            }
        }
        if( !$baseUrl ) {
            $baseHostUrl = $baseUrlInfo['scheme'].'://'.$baseUrlInfo['host'].'/';
            if( empty($baseUrlInfo['path']) ) {
                $baseUrl = $baseHostUrl;
            } else {
                $baseUrl = explode('/', $baseUrlInfo['path']);
                array_pop($baseUrl);
                $baseUrl = join('/', $baseUrl);
                $baseUrl = trim($baseUrl, '/');
                $baseUrl = $baseUrlInfo['scheme'].'://'.$baseUrlInfo['host'].'/'.$baseUrl.'/';
            }
        }

        $images = array();
        if( $thumb ) {
            $images[] = $thumb;
        }
        if( $dom ) {
            $imageQuery = $dom->query('img');
            foreach( $imageQuery as $image )
            {
                $src = $image->getAttribute('src');
                // Ignore images that don't have a src
                if( !$src || false === ($srcInfo = @parse_url($src)) ) {
                    continue;
                }
                $ext = ltrim(strrchr($src, '.'), '.');
                // Detect absolute url
                if( strpos($src, '/') === 0 ) {
                    // If relative to root, add host
                    $src = $baseHostUrl . ltrim($src, '/');
                } else if( strpos($src, './') === 0 ) {
                    // If relative to current path, add baseUrl
                    $src = $baseUrl . substr($src, 2);
                } else if( !empty($srcInfo['scheme']) && !empty($srcInfo['host']) ) {
                    // Contians host and scheme, do nothing
                } else if( empty($srcInfo['scheme']) && empty($srcInfo['host']) ) {
                    // if not contains scheme or host, add base
                    $src = $baseUrl . ltrim($src, '/');
                } else if( empty($srcInfo['scheme']) && !empty($srcInfo['host']) ) {
                    // if contains host, but not scheme, add scheme?
                    $src = $baseUrlInfo['scheme'] . ltrim($src, '/');
                } else {
                    // Just add base
                    $src = $baseUrl . ltrim($src, '/');
                }
                // Ignore images that don't come from the same domain
                //if( strpos($src, $srcInfo['host']) === false ) {
                // @todo should we do this? disabled for now
                //continue;
                //}
                // Ignore images that don't end in an image extension
                if( !in_array($ext, array('jpg', 'jpeg', 'gif', 'png')) ) {
                    // @todo should we do this? disabled for now
                    //continue;
                }
                if( !in_array($src, $images) ) {
                    $images[] = $src;
                }
            }
        }

        // Unique
        $images = array_values(array_unique($images));

        // Truncate if greater than 20
        if( count($images) > 30 ) {
            array_splice($images, 30, count($images));
        }

        $this->_data['imageCount'] = count($images);
        $this->_data['images'] = $images;
    }
}