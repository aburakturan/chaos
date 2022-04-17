<?php

namespace App\Models\Traits;

use Twitter;
use OpenGraph;
use SEOMeta;

trait MetaTrait
{
    protected $seoMetaDescLength = 170;
    protected $seoDefaultOgType = 'website';

    public function setMetaTags()
    {
        $this->setMetaTitle();
        $this->setMetaDescription();
        $this->setCanonical();
        $this->setLocale();
        $this->setAlternateLanguages();

        $this->setOgSiteName();
        $this->setOgType();
        $this->setOgImage();
        $this->setOgAPPId();

        $this->setTwitterCard();
        $this->setTwitterSite();
    }

    public function setMetaTitle()
    {
        if (method_exists($this, 'seoMetaTitle') && !empty($this->seoMetaTitle())) {
            SEOMeta::setTitle($this->seoMetaTitle());

            if ($this->seoMetaTitle()) {
                OpenGraph::setTitle($this->seoMetaTitle().config('seotools.meta.defaults.separator').config('seotools.meta.defaults.title'));
            }
        } elseif (method_exists($this, 'getTitle')) {
            if (isset($this->template) && $this->template == 'Home') {
                return;
            }

            SEOMeta::setTitle($this->getTitle());

            if ($this->getTitle()) {
                OpenGraph::setTitle($this->getTitle().config('seotools.meta.defaults.separator').config('seotools.meta.defaults.title'));
            } else {
                OpenGraph::setTitle($this->getTitle());
            }
        }
    }

    public function setMetaDescription()
    {
        if (method_exists($this, 'seoMetaDescription') && !empty($this->seoMetaDescription())) {
            SEOMeta::setDescription(strLimit($this->seoMetaDescription(), $this->seoMetaDescLength));
            OpenGraph::setDescription(strLimit($this->seoMetaDescription(), $this->seoMetaDescLength));
        } elseif (method_exists($this, 'getContent') && $this->getContent()) {
            SEOMeta::setDescription(strLimit($this->getContent(), $this->seoMetaDescLength));
            OpenGraph::setDescription(strLimit($this->getContent(), $this->seoMetaDescLength));
        } else {
            OpenGraph::setDescription(strLimit(setting('meta_description_'.app()->getLocale()), $this->seoMetaDescLength));
        }
    }

    public function setCanonical()
    {
        if (method_exists($this, 'seoCanonical')) {
            SEOMeta::setCanonical($this->seoCanonical());
            OpenGraph::setUrl($this->seoCanonical());
        } elseif (method_exists($this, 'getViewLink')) {
            SEOMeta::setCanonical($this->getViewLink());
            OpenGraph::setUrl($this->getViewLink());
        }
    }

    public function setLocale()
    {
        OpenGraph::addProperty('locale', config('app.locales')[app()->getLocale()]['locale']);
    }

    public function setAlternateLanguages()
    {
        $locales = config('app.locales');

        if (count($locales) > 1 && method_exists($this, 'getViewLink')) {
            foreach (config('app.locales') as $lang => $langMeta) {
                if ($this->getViewLink($lang)) {
                    SEOMeta::addAlternateLanguage($lang, $this->getViewLink($lang));
                }
            }
        }
    }

    public function setOgSiteName()
    {
        OpenGraph::setSiteName(setting('title_'.app()->getLocale()));
    }

    public function setOgType()
    {
        if (method_exists($this, 'seoOgType')) {
            OpenGraph::setType($this->seoOgType());
        } else {
            OpenGraph::setType($this->seoDefaultOgType);
        }
    }

    public function setOgImage()
    {
        if (method_exists($this, 'seoOGImage')) {
            OpenGraph::addImage($this->seoOGImage());
        } elseif (method_exists($this, 'getImage') && method_exists($this, 'hasImage') && $this->hasImage('og_image')) {
            OpenGraph::addImage($this->getImage('og_image'));
        } else {
            OpenGraph::addImage(asset(env('APP_OPENGRAPH_DEFAULT_IMAGE')));
        }
    }

    public function setOgAPPId()
    {
        if (env('FACEBOOK_APP_ID')) {
            SEOMeta::addMeta('fb:app_id', env('FACEBOOK_APP_ID'), 'property');
        }
    }

    public function setTwitterCard()
    {
        Twitter::setType('summary_large_image');
    }

    public function setTwitterSite()
    {
        if (setting('social_twitter')) {
            Twitter::setSite('@'.basename(setting('social_twitter')));
        }
    }
}
