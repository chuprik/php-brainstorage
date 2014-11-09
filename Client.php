<?php

namespace kotchuprik\brainstorage;

use SleepingOwl\Apist\Apist;

class Client extends Apist
{
    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return 'http://brainstorage.me';
    }

    /**
     * Get all jobs on the page
     *
     * @param int $page
     *
     * @return array
     */
    public function getItems($page = 1)
    {
        return $this->get('/jobs?page=' . $page,
            Apist::filter('.jobs .job')->each([
                'title' => Apist::filter('.title')->attr('title')->trim(),
                'company' => Apist::filter('.company_name')->text(),
                'city' => Apist::filter('.location')->text(),
                'url' => Apist::filter('.title a')->attr('href'),
                'occupations' => Apist::filter('.occupations .occupation')->each(Apist::filter('*')->text()->trim()),
            ])
        );
    }

    /**
     * Get the full description of the job
     *
     * @param $url
     *
     * @return array
     */
    public function getItem($url)
    {
        return $this->get($this->getBaseUrl() . $url, [
            'requirements' => Apist::filter('.requirements')->html(),
            'bonuses' => Apist::filter('.bonuses')->html(),
            'skills' => Apist::filter('.tags .tag')->each(Apist::filter('*')->text()->trim()),
        ]);
    }
}
