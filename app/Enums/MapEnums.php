<?php

namespace App\Enums;


/**
 * Class MapEnums
 *
 * This class defines file-related enumerations, such as file types and their corresponding icons.
 *
 * @package App\Enums
 */

enum MapEnums
{
    const EnumsMap = [
        'FileTypes' => GeneralEnums::FileTypes,
        'InfoPageTypes' => GeneralEnums::InfoPageTypes,
        'ContactMessageTypes' => GeneralEnums::ContactMessageTypes,
        'ContactMessageStatuses' => GeneralEnums::ContactMessageStatuses,
        'PropertyTypes' => GeneralEnums::PropertyTypes,
        'Currencies' => GeneralEnums::Currencies,
        'ProjectStatuses' => GeneralEnums::ProjectStatuses,
        'SubsidiaryTypes' => GeneralEnums::SubsidiaryTypes,
        'SEOPages' => GeneralEnums::SEOPages,
        'HomePageSectionTypes' => GeneralEnums::HomePageSectionTypes,
    ];
}
