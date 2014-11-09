<?php

namespace kotchuprik\brainstorage;

use SleepingOwl\Apist\Apist;
use SleepingOwl\Apist\DomCrawler\Crawler;

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
                'id' => Apist::filter('.title a')->call(function (Crawler $node) {
                    return rtrim(ltrim($node->attr('href'), '/jobs/'), '/');
                }),
                'url' => Apist::filter('.title a')->attr('href'),
                'title' => Apist::filter('.title')->attr('title')->trim(),
                'company' => Apist::filter('.company_name')->text(),
                'city' => Apist::filter('.location')->text(),
                'occupations' => Apist::filter('.occupations .occupation')->each(Apist::filter('*')->text()->trim()),
            ])
        );
    }

    /**
     * Get the full description of the job
     *
     * @param int $id
     *
     * @return array
     */
    public function getItem($id)
    {
        return $this->get('/jobs/' . $id, [
            'requirements' => Apist::filter('.requirements')->html(),
            'bonuses' => Apist::filter('.bonuses')->html(),
            'skills' => Apist::filter('.tags .tag')->each(Apist::filter('*')->text()->trim()),
            'instructions' => Apist::filter('.instructions .text')->html(),
        ]);
    }
}
