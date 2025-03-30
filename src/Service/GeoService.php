<?php

namespace App\Service;

use App\Factories\CityFactory;
use App\Factories\CountryFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class GeoService
{
    public function __construct(
        private readonly CountryService $countryService,
        private readonly CityService $cityService,
        private readonly ParameterBagInterface $params
    )
    {

    }

    public function loadAndSaveGeoData(): void
    {
        $data = $this->loadGeoInfo();
        $this->handleGeoData($data);
    }

    public function loadGeoInfo(): array
    {
        $client = HttpClient::create();
        $url = $this->params->get('api_geo_url');

        if (!$url) {
            throw new \Exception('URL for geo is required!');
        }

        $response = $client->request('GET', $url, ['timeout' => 60]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('incorrect response from geo microservice');
        }

        $content = $response->getContent();

        return $content ? json_decode($content, true) : [];
    }

    public function handleGeoData(array $data)
    {
        $countries = [];
        $cities = [];

        foreach ($data as $geoItem) {
            $country = CountryFactory::create($geoItem['name'], $geoItem['code2'], $geoItem['code3']);
            $countries[$geoItem['code2']] = $country;
            foreach ($geoItem['cities'] ?? [] as $cityItem) {
                $city = CityFactory::create($cityItem['name'], $country, $cityItem['population']);
                $cities[] = $city;
            }
        }

        $this->countryService->saveAll($countries);//todo chanks
        $this->cityService->saveAll($cities);//todo chanks
    }

}
