<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $companyData = $this->getCompanyData();
        return view('about', compact('companyData'));
    }

    private function getCompanyData()
    {
        return [
            'stats' => [
                'users' => 10000,
                'trades_recorded' => 500000,
                'founded_year' => 2020,
                'support_availability' => '24/7'
            ],
            'team_size' => [
                'developers' => 15,
                'designers' => 5,
                'support' => 8,
                'data_scientists' => 3
            ],
            'achievements' => [
                [
                    'year' => 2023,
                    'title' => 'Best Fintech Award',
                    'description' => 'Thailand Fintech Awards'
                ],
                [
                    'year' => 2023,
                    'title' => 'ISO 27001 Certification',
                    'description' => 'Information Security Management'
                ],
                [
                    'year' => 2024,
                    'title' => '10,000+ Active Users',
                    'description' => 'Milestone Achievement'
                ]
            ]
        ];
    }
}
