<?php

namespace Eckinox\AddressBundle\Controller;

use Eckinox\AddressBundle\Api\AddressComplete\AddressCompleteApi;
use Eckinox\AddressBundle\Api\GooglePlaces\GooglePlacesApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AddressController extends AbstractController
{
    private Request $request;

    public function __construct(
        RequestStack $requestStack,
        private AddressCompleteApi $addressCompleteApi,
        private GooglePlacesApi $googlePlacesApi,
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getAddressPredictions(): Response
    {
        $serializer = $this->getSerializer();
        $searchQuery = $this->request->query->get("search");
        $previousId = $this->request->query->get("id") ?? "";

        $predictions = $this->getApi()->getPredictions($searchQuery, $previousId);
        $jsonPredictions = $serializer->serialize($predictions, 'json');

        return new Response($jsonPredictions);
    }

    public function getAddressDetails(): Response
    {
        $serializer = $this->getSerializer();
        $placeId = $this->request->query->get("id");
        $action = $this->request->query->get("action"); // Find|Retrieve used by CanadaPost API

        // if prediction is of type "Find", do another search instead
        if ($action == "Find") {
            return $this->getAddressPredictions();
        }

        $addressDetails = $this->getApi()->getAddressDetails($placeId);
        $jsonAddressDetails = $serializer->serialize($addressDetails, 'json');

        return new Response($jsonAddressDetails);
    }

    public function getSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    public function getApi(): AddressCompleteApi|GooglePlacesApi
    {
        $api = $this->request->query->get("api");

        return match ($api) {
            'addressComplete' => $this->addressCompleteApi,
            'googlePlaces' => $this->googlePlacesApi,
            default => throw new \InvalidArgumentException(sprintf('Api %s not found.', $api)),
        };
    }
}
